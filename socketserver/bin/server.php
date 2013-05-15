<?php
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__.'/../../bootstrap/autoload.php';
require_once __DIR__.'/../../bootstrap/start.php';


class Request implements MessageComponentInterface
{
    protected $clients;

    private $Item_m;
    private $ListItem_m;

    private $_JSONError = array(
        'status' => 400,
        'error'  => array(
            'name' => 'JSONError',
            'args' => 'Invalid JSON data'));
    private $_MethodError = array(
        'status' => 400,
        'error'  => array(
            'name' => 'MethodError',
            'args' => 'Invalid method call'));
    private $_ArgumentError = array(
        'status' => 400,
        'error'  => array(
            'name' => 'ArgumentError',
            'args' => 'Invalid argument'));
    private $_UnauthorizedError = array(
        'status' => 401,
        'error'  => array(
            'name' => 'Unauthorized',
            'args' => 'You are unauthorized for this operation'));


    public function __construct()
    {
        $this->clients = array();
        $this->Item_m = new ItemModel();
        $this->ListItem_m = new ItemListModel();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $json_msg)
    {
        echo sprintf('Connection %d sending message "%s"'."\n", $from->resourceId, $json_msg);

        $msg = json_decode($json_msg);

        if (is_null($msg))
        {
            $from->send(json_encode($this->_JSONError));
            return;
        }

        $method = (isset($msg->method) ? $msg->method : '');
        $args   = (isset($msg->args) ? $msg->args : '');

        // Safety first - check if $json->method exist
        if (!empty($method) && method_exists($this, $method))
        {
            $this->$method($from, $args);
        }
        else
        {
            $from->send(json_encode($this->_MethodError));
        }
    }

    public function setUserID(ConnectionInterface $from, $arg='')
    {
        $id = (int) $arg;
        if ($id > 0 && !isset($this->clients[$from->resourceId]->user_id))
        {
            $this->clients[$from->resourceId]->user_id = $id;
            $data = array(
                'status' => 200,
                'value'  => '');
            $json = json_encode($data);
            $from->send($json);
        }
        else
        {
            $from->send(json_encode($this->_ArgumentError));
        }
    }

    public function createItem(ConnectionInterface $from, $model='')
    {
        if (is_null($model)         || !is_object($model)      ||   // Are the model OK?
            !isset($model->title)   || empty($model->title)    ||   // Do we have a title?
            !isset($model->list_id) || $model->list_id <= 0)        // Do we have a list id?
        {
            $from->send(json_encode($this->_JSONError));
            return;
        }

        $item = $this->Item_m->save($model, $from->user_id);

        if (is_null($item))
        {
            $from->send(json_encode($this->_UnauthorizedError));
            return;
        }

        $owner = $this->ListItem_m->getOwner((int)$model->list_id);

        $from->send(json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'item:createFromForm',
                'args' => $item->toArray() ))));

        $json = json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'item:create',
                'args' => $item->toArray() )));

        if (count($owner) > 1)
        {
            foreach ($this->clients as $client)
            {
                if (in_array($client->user_id, $owner) && $client->user_id != $from->user_id)
                {
                    $client->send($json);
                }
            }
        }
    }

    public function deleteItem(ConnectionInterface $from, $model='')
    {
        if (is_null($model)         || !is_object($model)    ||
            !isset($model->id)      || $model->id <= 0       ||
            !isset($model->list_id) || $model->list_id <= 0)
        {
            $from->send(json_encode($this->_JSONError));
            return;
        }

        $item = Item::find($model->id);

        if (!is_null($item))
        {
            $item->subItems()->delete();    // Delete all subitem
            $item->delete();                // And delete the item

            $json = json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'item:delete',
                    'args' => $model)));

            $owner = $this->ListItem_m->getOwner((int)$model->list_id);

            if (count($owner) > 1)
            {
                foreach ($this->clients as $client)
                {
                    if (in_array($client->user_id, $owner) && $client->user_id != $from->user_id)
                    {
                        $client->send($json);
                    }
                }
            }
        }
    }

    public function updateItem(ConnectionInterface $from, $model='')
    {
        if (is_null($model)           || !is_object($model)       ||
            !isset($model->id)        || $model->id <= 0          ||
            !isset($model->list_id)   || $model->list_id <= 0     ||
            !isset($model->completed) || ($model->completed != 0 && $model->completed != 1) ||
            !isset($model->title)     || empty($model->title)     ||
            !isset($model->order)     || $model->order < 0)
        {
            $from->send(json_encode($this->_JSONError));
            return;
        }

        $status = $this->Item_m->update($model, $from->user_id);

        if (!$status)
        {
            $from->send(json_encode($this->_UnauthorizedError));
            return;
        }

        $json = json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'item:update',
                'args' => $model)));

        $owner = $this->ListItem_m->getOwner((int)$model->list_id);

        if (count($owner) > 1)
        {
            foreach ($this->clients as $client)
            {
                if (in_array($client->user_id, $owner) && $client->user_id != $from->user_id)
                {
                    $client->send($json);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->clients[$conn->resourceId]);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

$server = IoServer::factory(
	new WsServer(
		new Request()
		)
	, 8080
	);

$server->run();


    // public function echoMsg(ConnectionInterface $from, $arg='')
    // {
    //     if (!isset($arg->msg) || empty($arg->msg))
    //     {
    //         $from->send(json_encode($this->_ArgumentError));
    //     }
    //     else
    //     {
    //         $data = array(
    //             'status' => 200,
    //             'value'  => $arg->msg);
    //         $json = json_encode($data);
    //         $from->send($json);
    //     }
    // }

    // public function createList(ConnectionInterface $from, $model='')
    // {
    //     if (is_null($model) || !is_object($model))
    //     {
    //         $from->send(json_encode($this->_JSONError));
    //         return;
    //     }

    //     $model->id = 56;

    //     $data = array(
    //         'status' => 200,
    //         'fire'   => array(
    //             'name' => 'list:createFromForm',
    //             'args' => $model));
    //     $json = json_encode($data);
    //     $from->send($json);

    //     $json = json_encode(array(
    //         'status' => 200,
    //         'fire'   => array(
    //             'name' => 'list:create',
    //             'args' => $model)));

    //     foreach ($this->clients as $resourceId => $client) {
    //         if ($client->user_id != $from->user_id)
    //         {
    //             $client->send($json);
    //         }
    //     }
    // }
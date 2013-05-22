<?php

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'errorMessages.php';

class ItemHandler
{
    private $clients;    // Reference to the the server clients
    private $item_m;     // Item model
    private $listItem_m; // List model

    public function __construct(&$clients)
    {
        $this->clients = &$clients;
        $this->item_m = new ItemModel();
        $this->listItem_m = new ListItemModel();
    }

    /**
     * Crate a item
     * @param ConnectionInterface $from
     * @param object $model
     * @return void
     */
    public function create(ConnectionInterface $from, $model='')
    {
        if (is_null($model)         || !is_object($model)      ||   // Are the model OK?
            !isset($model->title)   || empty($model->title)    ||   // Do we have a title?
            !isset($model->list_id) || $model->list_id <= 0)        // Do we have a list id?
        {
            // Bad message from the client
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }

        $item = $this->item_m->save($model, $from->user_id);

        if (is_null($item))
        {
            global $_UnauthorizedError;
            $from->send(json_encode($_UnauthorizedError));
            return;
        }

        // Inform the user that everything went well
        $from->send(json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'item:createFromForm',
                'args' => $item->toArray() ))));

        $owners = $this->listItem_m->getOwner((int)$model->list_id);

        // Inform the other users (who also share the current list)
        if (count($owners) > 1)
        {
            $json = json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'item:create',
                'args' => $item->toArray() )));

            foreach ($this->clients as $client)
            {
                if (in_array($client->user_id, $owners) && $client->user_id != $from->user_id)
                {
                    $client->send($json);
                }
            }
        }
    }

    /**
     * Remove a item
     * @param ConnectionInterface $from
     * @param object $model
     * @return void
     */
    public function delete(ConnectionInterface $from, $model='')
    {
        if (is_null($model)         || !is_object($model)    ||
            !isset($model->id)      || $model->id <= 0       ||
            !isset($model->list_id) || $model->list_id <= 0)
        {
            // Bad message from the client
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }

        if ($this->item_m->delete((int) $model->id))
        {
            $json = json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'item:delete',
                    'args' => $model)));

            $owners = $this->listItem_m->getOwner((int)$model->list_id);

            // Inform the other users (who also share the current list)
            if (count($owners) > 1)
            {
                foreach ($this->clients as $client)
                {
                    if (in_array($client->user_id, $owners) && $client->user_id != $from->user_id)
                    {
                        $client->send($json);
                    }
                }
            }
        }
    }

    /**
     * Update a item
     * @param ConnectionInterface $from
     * @param object $model
     * @return void
     */
    public function update(ConnectionInterface $from, $model='')
    {
        if (is_null($model)           || !is_object($model)       ||
            !isset($model->id)        || $model->id <= 0          ||
            !isset($model->list_id)   || $model->list_id <= 0     ||
            !isset($model->completed) || ($model->completed != 0 && $model->completed != 1) ||
            !isset($model->title)     || empty($model->title)     ||
            !isset($model->order)     || $model->order < 0        ||
            !isset($model->due_date))
        {
            // Bad message from the client
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }

        $status = $this->item_m->update($model, $from->user_id);

        if (!$status)
        {
            global $_UnauthorizedError;
            $from->send(json_encode($_UnauthorizedError));
            return;
        }

        $owner = $this->listItem_m->getOwner((int)$model->list_id);

        // Inform the other users (who also share the current list)
        if (count($owner) > 1)
        {
            $json = json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'item:update',
                    'args' => $model)));
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

<?php
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__.'/../../bootstrap/autoload.php';
require_once __DIR__.'/../../bootstrap/start.php';

require __DIR__.'/../errorMessages.php';
require __DIR__.'/../ItemHandler.php';
require __DIR__.'/../SubItemHandler.php';
require __DIR__.'/../UserHandler.php';

class Request implements MessageComponentInterface
{
    protected $clients;

    private $item;
    private $subItem;
    private $user;

    public function __construct()
    {
        $this->clients = array();
        $this->item = new ItemHandler($this->clients);
        $this->subItem = new SubItemHandler($this->clients);
        $this->user = new UserHandler($this->clients);
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
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }
        $object = (isset($msg->object) ? $msg->object : '');
        $method = (isset($msg->method) ? $msg->method : '');
        $args   = (isset($msg->args) ? $msg->args : '');

        // Safety first - check if $json->object and method exist
        if (!empty($object) && isset($this->$object) &&
            !empty($method) && method_exists($this->$object, $method))
        {
            $this->$object->$method($from, $args);
        }
        else
        {
            global $_MethodError;
            $from->send(json_encode($_MethodError));
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

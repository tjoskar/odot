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

    public function __construct()
    {
        $this->clients = array();
    }

    /**
     * Called when a new connection is opend
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients[$conn->resourceId] = $conn;
        echo "New connection! ({$conn->resourceId})\n";
    }

    /**
     * Called when a message is send to the server
     * @param ConnectionInterface $from
     * @param string $json_msg
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $json_msg)
    {
        // Echo out the message (for debug)
        echo sprintf('Connection %d sending message "%s"'."\n", $from->resourceId, $json_msg);

        $msg = json_decode($json_msg);

        if (is_null($msg))
        {
            // Bad message from the client
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }

        $object = (isset($msg->object) ? $msg->object : '');
        $method = (isset($msg->method) ? $msg->method : '');
        $args   = (isset($msg->args)   ? $msg->args   : '');

        // Safety first - check if $json->object and method exist
        if (!empty($object) && isset($this->$object) &&
            !empty($method) && method_exists($this->$object, $method))
        {
            $this->$object->$method($from, $args);
        }
        else
        {
            // Bad method call
            global $_MethodError;
            $from->send(json_encode($_MethodError));
        }
    }

    /**
     * Called when the client close the connection
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->clients[$conn->resourceId]);

        // Print some debug message
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * Called if an error occurred
     * @param ConnectionInterface $conn
     * @param Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, Exception $e) {
        echo "Oh snap, an error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

// Create a server
$server = IoServer::factory(
	new WsServer(
		new Request()
		)
	, 8080
	);

// And boot it up
$server->run();

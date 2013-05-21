<?php

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'errorMessages.php';

class UserHandler
{
    private $clients; //Reference to the the server clients

    //Constructor
    public function __construct(&$clients)
    {
        $this->clients = &$clients;
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
            global $_ArgumentError;
            $from->send(json_encode($_ArgumentError));
        }
    }

    public function shareListWithUser(ConnectionInterface $from, $arg='')
    {
        $args = (array)$arg;
        
        //Validate argument
        if (isset($args) && isset($args['username']) && !empty($args['username']))
        {
            //Check if user exists
            $user = User::where('username', '=', $args['username'])->first();

            if (!is_null($user))
            {
                //Send success response
                $from->send(json_encode(array(
                    'status' => 200,
                    'fire'   => array(
                        'name' => 'sharePopup:listSharedWithUser',
                        'args' => $user->username ))));
                return;
            }

            //Else send invalid username
            $from->send(json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'sharePopup:listSharedWithUser',
                    'args' =>  '' ))));
        }
        else
        {
            global $_ArgumentError;
            $from->send(json_encode($_ArgumentError));
        }
    }
}


<?php

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'errorMessages.php';

class UserHandler
{
    private $clients;   // Reference to the the server clients
    private $share_m;
    private $listItem_m;

    public function __construct(&$clients)
    {
        $this->clients    = &$clients;          // Save an reference
        $this->share_m    = new ShareModel();   // Share model
        $this->listItem_m = new ListItemModel();// List model
    }

    /**
     * Give a connection a user id
     * @param ConnectionInterface $from
     * @param int $arg
     * @return void
     */
    public function setUserID(ConnectionInterface $from, $arg = 0)
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
            // Bad request
            global $_ArgumentError;
            $from->send(json_encode($_ArgumentError));
        }
        return;
    }

    /**
     * Get the usernames of the users how share the list
     * @param ConnectionInterface $from
     * @param object $arg
     * @return void
     */
    public function getUsersSharingListId(ConnectionInterface $from, $arg='')
    {
        // Validate argument
        if (isset($arg) && isset($arg->listId) && !empty($arg->listId) && $arg->listId > 0)
        {
            $response = $this->share_m->getUsernameForShareList($arg->listId, $this->clients[$from->resourceId]->user_id);

            // Send the response back
            $from->send(json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'sharePopup:usersSharingList',
                    'args' => $response ))));
        }
        else // Else send empty response
        {
            $from->send(json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'sharePopup:usersSharingList',
                    'args' =>  '' ))));
        }
        return;
    }

    /**
     * Share a list with a user
     * @param ConnectionInterface $from
     * @param object $arg
     * @return void
     */
    public function shareListWithUser(ConnectionInterface $from, $arg='')
    {
        // Validate argument
        if (isset($arg) &&
            isset($arg->username) && !empty($arg->username) &&
            isset($arg->listId)   && !empty($arg->listId))
        {
            // Check if user exists
            $user = $this->share_m->getUser($arg->username);
            $username = '';

            if (!is_null($user) && $arg->listId > 0)
            {
                // Check that user is not already sharing the list and
                // Check that list exist
                if ( !$this->share_m->isUserSharingList($arg->listId, $user->id) &&
                      $this->listItem_m->listExist($arg->listId) )
                {
                    // Share the list to the user
                    $this->share_m->shareList($user->id, $arg->listId);

                    $username = $user->username;

                    $list = ItemList::find($arg->listId)->toArray();

                    $json = json_encode(array(
                        'status' => 200,
                        'fire'   => array(
                            'name' => 'list:add',
                            'args' => $list )));

                    // Inform the the user that is now sharing the list
                    foreach ($this->clients as $client)
                    {
                        if ($client->user_id == $user->id)
                        {
                            $client->send($json);
                            break;
                        }
                    }
                }
            }

            // Send back a response to the user
            $from->send(json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'sharePopup:listSharedWithUser',
                    'args' =>  $username ))));
        }
        else
        {
            global $_ArgumentError;
            $from->send(json_encode($_ArgumentError));
        }
        return;
    }
}


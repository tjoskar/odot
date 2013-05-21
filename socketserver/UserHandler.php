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

    public function getUsersSharingListId(ConnectionInterface $from, $arg='')
    {
        $args = (array) $arg;
        if (isset($args) && isset($args['listId']) && !empty($args['listId']) &&
            $args['listId'] > 0)
        {
            $listId = $args['listId'];
            //$users = DB::table('user_lists')->select('user_id')->where('list_id', $listId)->get();
            /*
            $userIDs = DB::table('user_lists')->where('list_id', $listId)->lists('user_id');

            foreach ($userIDs as $userId)
            {
                $user = DB::table('users')->select('visible_name')->where('id', $userId)->get();
                var_dump($user[0]['visible_name']);
            } 
            */

            $usernames = DB::table('user_lists as ul')
            ->join('users as u', 'u.id', '=', 'ul.user_id')
            ->where('ul.list_id', $listId)
            ->where('u.id', '!=', $this->clients[$from->resourceId]->user_id)
            ->select('u.visible_name')->get();
            
            //Format the response
            $response = array();
            foreach ($usernames as $user)
            {
                array_push($response, $user->visible_name);
            }

            //Send the response back
            $from->send(json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'sharePopup:usersSharingList',
                    'args' => $response ))));
            return;
        }

        //Else send empty response
        $from->send(json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'sharePopup:usersSharingList',
                'args' =>  '' ))));
    }

    public function shareListWithUser(ConnectionInterface $from, $arg='')
    {
        $args = (array) $arg;
        
        //Validate argument
        if (isset($args) && 
            isset($args['username']) && !empty($args['username']) &&
            isset($args['listId']) && !empty($args['listId']))
        {
            //Check if user exists
            $user = User::where('username', '=', $args['username'])->first();
            $listId = $args['listId'];

            if (!is_null($user) && $listId > 0)
            {
                //Check that user is not already sharing the list and
                //Check that list exist
                if (is_null(DB::table('user_lists')->where('list_id', $listId)->where('user_id', $user->id)->get()) &&
                    DB::table('lists')->where('id', $listId)->count() == 1);
                {
                    //Share the list to the user
                    DB::table('user_lists')->insert(
                            array('user_id' => $user->id, 'list_id' => $listId)
                        );

                    //Send success response
                    $from->send(json_encode(array(
                        'status' => 200,
                        'fire'   => array(
                            'name' => 'sharePopup:listSharedWithUser',
                            'args' => $user->username ))));
                    return;
                }
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


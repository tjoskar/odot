<?php

use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'errorMessages.php';

class SubItemHandler
{
    private $clients; //Reference to the the server clients
    private $subItem_m;
    private $listItem_m;

    public function __construct(&$clients)
    {
        $this->clients = &$clients;
        $this->subItem_m  = new SubItemModel();
        $this->listItem_m = new ListItemModel();
    }

    public function create(ConnectionInterface $from, $model='')
    {
        if (is_null($model)         || !is_object($model)      ||   // Are the model OK?
            !isset($model->title)   || empty($model->title)    ||   // Do we have a title?
            !isset($model->item_id) || $model->item_id <= 0    ||   // Do we have a item id?
            !isset($model->list_id) || $model->list_id <= 0)        // Do we have a list id?
        {
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }

        $subItem = $this->subItem_m->save($model, $from->user_id);

        if (is_null($subItem))
        {
            global $_UnauthorizedError;
            $from->send(json_encode($_UnauthorizedError));
            return;
        }

        $from->send(json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'subItem:createFromForm',
                'args' => $subItem->toArray() ))));

        $owners = $this->listItem_m->getOwner((int)$model->list_id);

        if (count($owners) > 1)
        {
            $json = json_encode(array(
            'status' => 200,
            'fire'   => array(
                'name' => 'subItem:create',
                'args' => $subItem->toArray() )));

            foreach ($this->clients as $client)
            {
                if (in_array($client->user_id, $owners) && $client->user_id != $from->user_id)
                {
                    $client->send($json);
                }
            }
        }
    }

    public function delete(ConnectionInterface $from, $model='')
    {
        if (is_null($model)         || !is_object($model)    ||
            !isset($model->id)      || $model->id <= 0       ||
            !isset($model->list_id) || $model->list_id <= 0)
        {
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }

        if ($this->subItem_m->delete((int) $model->id))
        {
            $owners = $this->listItem_m->getOwner((int)$model->list_id);

            if (count($owners) > 1)
            {
                $json = json_encode(array(
                    'status' => 200,
                    'fire'   => array(
                        'name' => 'subItem:delete',
                        'args' => $model)));

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

    public function update(ConnectionInterface $from, $model='')
    {
        if (is_null($model)           || !is_object($model)       ||
            !isset($model->id)        || $model->id <= 0          ||
            !isset($model->list_id)   || $model->list_id <= 0     ||
            !isset($model->item_id)   || $model->item_id <= 0     ||
            !isset($model->completed) || ($model->completed != 0 && $model->completed != 1) ||
            !isset($model->title)     || empty($model->title)     ||
            !isset($model->order)     || $model->order < 0)
        {
            global $_JSONError;
            $from->send(json_encode($_JSONError));
            return;
        }

        $status = $this->subItem_m->update($model, $from->user_id);

        if (!$status)
        {
            global $_UnauthorizedError;
            $from->send(json_encode($_UnauthorizedError));
            return;
        }

        $owner = $this->listItem_m->getOwner((int)$model->list_id);

        if (count($owner) > 1)
        {
            $json = json_encode(array(
                'status' => 200,
                'fire'   => array(
                    'name' => 'subItem:update',
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
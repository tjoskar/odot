<?php

class DBmodel {

    private $_table;

    public function __construct()
    {
        $this->_table = new stdClass;

        // Set tables name
        $this->_table->item = 'items';
        $this->_table->userList = 'user_lists';
    }

    public function getNextItemOrder($list_id)
    {
        if (is_int($list_id))
        {
            return DB::table($this->_table->item)->where('list_id', $list_id)->max('order') + 1;
        }
        else
        {
            throw new Exception('Argument passed to '.__METHOD__.' must be an integer, '.gettype($list_id).' given. File: '.__FILE__.' Line: '. __LINE__);
        }
    }

    public function saveItem(stdClass $model, $user_id)
    {
        if (!isset($model->title)   || empty($model->title)    ||   // Do we have a title?
            !isset($model->list_id) || empty($model->list_id))      // Do we have a list id?
        {
            return NULL;
        }

        $ownList = DB::table($this->_table->userList)->where('user_id', $user_id)->where('list_id', $model->list_id)->count();

        if ($ownList == 1)
        {
            $item = new Item();
            $item->title   = $model->title;
            $item->list_id = $model->list_id;
            $item->order   = $this->getNextItemOrder((int) $model->list_id);

            $item->save();

            return $item;
        }
        else
        {
            return NULL;
        }


    }
}

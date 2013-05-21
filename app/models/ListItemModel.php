<?php

class ListItemModel {

    private $_table;

    public function __construct()
    {
        $this->_table = new stdClass;

        // Set tables name
        $this->_table->item = 'lists';
        $this->_table->userList = 'user_lists';
    }

    public function getNextOrderIndex()
    {
        return ItemList::max('order') + 1;
    }

    public function save(stdClass $model, $user_id)
    {
        if (!isset($model->title)   || empty($model->title)) // Do we have a title?
        {
            return NULL;
        }

        $list = new ItemList();
        $list->title = $model->title;
        //$list->user_id = $user_id;
        $list->order = $this->getNextOrderIndex();

        User::find($user_id)->lists()->save($list);

        return $list;
    }

    public function update(stdClass $model, $user_id)
    {
        if (!isset($model->id)        || empty($model->id)        ||
            !isset($model->title)     || empty($model->title)     ||
            !isset($model->order)     || empty($model->order))
        {
            return FALSE;
        }

        /**

            - We don't need tree SQL call to update one row
            - If we own the list => the list exist

        **/

        $ownList = DB::table($this->_table->userList)->where('user_id', $user_id)->where('list_id', $model->id)->count();

        if ($ownList == 1)
        {
            $list = ItemList::find($id);
            if (!is_null($list))
            {
                $list->title = $title;
                $list->order = $order;
                $list->save();
                return TRUE;
            }
        }

        return FALSE;
    }

    public function getOwner($list_id)
    {
        if (!is_int($list_id))
        {
            throw new Exception('Argument passed to '.__METHOD__.' must be an integer, '.gettype($list_id).' given. File: '.__FILE__.' Line: '. __LINE__);
        }

        $return = array();
        $owner = DB::table($this->_table->userList)->where('list_id', $list_id)->select('user_id')->get();

        if (is_array($owner))
        {
            foreach ($owner as $user)
            {
                array_push($return, (int) $user->user_id);
            }
        }

        return $return;
    }
}

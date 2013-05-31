<?php

class ItemModel {

    private $_table;

    public function __construct()
    {
        $this->_table = new stdClass;

        // Set tables name
        $this->_table->item = 'items';
        $this->_table->userList = 'user_lists';
    }

    /**
     * Returns a number that is the highest order
     * Used for sorting to make place a new item last
     * @param int $list_id
     * @return int
     */
    public function getNextOrderIndex($list_id)
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

    /**
     * Save an list model
     * @param stdClass $model
     * @param int $list_id
     * @return int
     */
    public function save(stdClass $model, $user_id)
    {
        if (!isset($model->title)   || empty($model->title)    ||   // Do we have a title?
            !isset($model->list_id) || empty($model->list_id))      // Do we have a list id?
        {
            throw new Exception('Incomplete model was passed to '.__METHOD__.'. File: '.__FILE__.' Line: '. __LINE__);
        }

        $ownList = DB::table($this->_table->userList)->where('user_id', $user_id)->where('list_id', $model->list_id)->count();

        if ($ownList == 1)
        {
            $item = new Item();
            $item->title   = $model->title;
            $item->list_id = $model->list_id;
            $item->order   = $this->getNextOrderIndex((int) $model->list_id);

            $item->save();

            return $item;
        }

        return NULL;
    }

    /**
     * Update an list model
     * @param stdClass $model
     * @param int $user_id
     * @return bool success
     */
    public function update(stdClass $model, $user_id)
    {
        if (!isset($model->id)        || $model->id <= 0          ||
            !isset($model->list_id)   || $model->list_id <= 0     ||
            !isset($model->completed) || ($model->completed != 0 && $model->completed != 1) ||
            !isset($model->title)     || empty($model->title)     ||
            !isset($model->order)     || $model->order < 0        ||
            !isset($model->due_date))
        {
            throw new Exception('Incomplete model was passed to '.__METHOD__.'. File: '.__FILE__.' Line: '. __LINE__);
        }

        $ownList = DB::table($this->_table->userList)->where('user_id', $user_id)->where('list_id', $model->list_id)->count();

        if ($ownList == 1)
        {
            $item = Item::find($model->id);

            if (!is_null($item))
            {
                $item->title     = $model->title;
                $item->completed = $model->completed;
                $item->order     = $model->order;
                $item->due_date  = $model->due_date;
                $item->save();
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Delete an list model
     * @param int $id
     * @return bool success
     */
    public function delete($id)
    {
        $item = Item::find($id);

        if (!is_null($item))
        {
            $item->subItems()->delete();    // Delete all subitem
            $item->delete();                // And delete the item
            return TRUE;
        }
        return FALSE;
    }
}

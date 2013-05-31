<?php

class SubItemModel {

    private $_table;

    public function __construct()
    {
        $this->_table = new stdClass;

        // Set tables name
        $this->_table->subItem = 'sub_items';
        $this->_table->userList = 'user_lists';
    }

    /**
     * Returns a number that is the highest order
     * Used for sorting to make place a new item last
     * @param int $item_id
     * @return int order
     */
    public function getNextOrderIndex($item_id)
    {
        if (is_int($item_id))
        {
            return DB::table($this->_table->subItem)->where('item_id', $item_id)->max('order') + 1;
        }
        else
        {
            throw new Exception('Argument passed to '.__METHOD__.' must be an integer, '.gettype($list_id).' given. File: '.__FILE__.' Line: '. __LINE__);
        }
    }

    /**
     * Save an sub item model
     * @param stdClass $model
     * @param int $user_id
     * @return SubItem subItem
     */
    public function save(stdClass $model, $user_id)
    {
        if (!isset($model->title)   || empty($model->title)    ||
            !isset($model->item_id) || empty($model->item_id)  ||
            !isset($model->list_id) || empty($model->list_id))
        {
            throw new Exception('Incomplete model was passed to '.__METHOD__.'. File: '.__FILE__.' Line: '. __LINE__);
        }

        $ownList = DB::table($this->_table->userList)->where('user_id', $user_id)->where('list_id', $model->list_id)->count();

        if ($ownList == 1)
        {
            $item = Item::find($model->item_id);
            if (!is_null($item))
            {
                $subItem = new SubItem();
                $subItem->title = $model->title;
                $subItem->list_id = $model->list_id;
                $subItem->item_id = $model->item_id;
                $subItem->order = $this->getNextOrderIndex((int) $model->item_id);

                $subItem->save();

                return $subItem;
            }
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Update an sub item model
     * @param stdClass $model
     * @param int $user_id
     * @return bool success
     */
    public function update(stdClass $model, $user_id)
    {
        if (!isset($model->id)        || $model->id <= 0          ||
            !isset($model->list_id)   || $model->list_id <= 0     ||
            !isset($model->item_id)   || $model->item_id <= 0     ||
            !isset($model->completed) || ($model->completed != 0 && $model->completed != 1) ||
            !isset($model->title)     || empty($model->title)     ||
            !isset($model->order)     || $model->order < 0)
        {
            throw new Exception('Incomplete model was passed to '.__METHOD__.'. File: '.__FILE__.' Line: '. __LINE__);
        }

        $ownList = DB::table($this->_table->userList)->where('user_id', $user_id)->where('list_id', $model->list_id)->count();

        if ($ownList == 1)
        {
            $subItem = SubItem::find($model->id);

            if (!is_null($subItem))
            {
                $subItem->title = $model->title;
                $subItem->list_id = $model->list_id;
                $subItem->item_id = $model->item_id;
                $subItem->order = $model->order;
                $subItem->completed = $model->completed;

                $subItem->save();
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Delete an sub item model
     * @param int $id
     * @return bool success
     */
    public function delete($id)
    {
        $subItem = SubItem::find($id);
        if (!is_null($subItem))
        {
            $subItem->delete();
            return TRUE;
        }
        return FALSE;
    }
}

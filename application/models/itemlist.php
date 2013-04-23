<?php

class ItemList extends Eloquent {

	public static $table = 'lists';

    public function items()
    {
        return $this->has_many('Item', 'list_id');
    }

    /*public function sub_items()
    {
        return $this->has_many('Sub_Item', 'list_id');
    }*/

    /**
     * get all items, inc. sub_item
     * @param int $list_id 
     * @return obj
     */
    /*public function getAllItems($list_id)
    {
        DB::table('items')
            ->left_join('sub_items', 'items.id', '=', 'sub_items.item_id')
            ->get();
    }*/

}


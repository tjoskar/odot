<?php

class Item extends Eloquent {

	protected $table = 'items';

    public function subItems()
    {
        return $this->hasMany('SubItem');
    }

    // public function getHigestOrder($list_id)
    // {
    //     return $this->where('list_id', '=', $list_id)->max('order') + 1;
    // }
}

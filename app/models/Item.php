<?php

class Item extends Eloquent {

	protected $table = 'items';

    public function subItems()
    {
        return $this->hasMany('SubItem');
    }

    public function scopeGetHighestOrder($query, $list_id)
    {
        return $query->where('list_id', '=', $list_id)->max('order');
    }

}

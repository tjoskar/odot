<?php

class Item extends Eloquent {

	protected $table = 'items';

    public function subItems()
    {
        return $this->hasMany('SubItem');
    }

}

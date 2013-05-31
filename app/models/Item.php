<?php

class Item extends Eloquent {

    protected $table = 'items';

    //Item relation to subitem
    public function subItems()
    {
        return $this->hasMany('SubItem');
    }
}

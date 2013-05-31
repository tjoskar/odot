<?php

class ItemList extends Eloquent {

	protected $table = 'lists';

    /**
     * Relation
     */
    public function items()
    {
        return $this->hasMany('Item', 'list_id');
    }

}


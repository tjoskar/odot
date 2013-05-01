<?php

class Item extends Eloquent {

	public static $table = 'items';

    public function subItems()
    {
        return $this->has_many('SubItem');
    }

}

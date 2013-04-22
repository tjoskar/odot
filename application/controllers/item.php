<?php

class Item_Controller extends Base_Controller {

	public $restful = true;

	public function get_index($item_id = 0)
	{
		if ($item_id <= 0)
		{
			return Response::json(array());
		}

		$item = Items::where('id', '=', $item_id)->first();
		$output = (is_object($item)) ? $item->attributes : array();
		
		return Response::json($output);
	}

}
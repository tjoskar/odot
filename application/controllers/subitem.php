<?php

class subItem_Controller extends Base_Controller {

	public $restful = true;

	/**
	 * Create a new subitem
	 * @return null
	 */
	public function post_index()
	{
		// Create a new subitem
		$input = Input::json(true);
		$response = SubItem::create($input);
		return Response::json($response->to_array());
	}

}
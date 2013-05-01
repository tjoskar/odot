<?php

class subItem_Controller extends Base_Controller {

	public $restful = true;

	/**
	 * Create a new subitem
	 * @return null
	 */
	public function post_index()
	{
		$input = Input::json(true);

		if (!is_array($input))
			return null;

		$response = SubItem::create($input);
		return Response::json($response->to_array());
	}

	/**
	 * Update a subitem
	 * @return null
	 */
	public function put_index($id = 0)
	{
		$input = Input::json();

		if (!is_object($input) || !is_numeric($id) || $id <= 0)
			return null;

		$subItem = SubItem::find($id);

		if (!is_null($subItem))
		{
			$subItem->title = $input->title;
			$subItem->save();
		}
	}

}
<?php

class Item_Controller extends Base_Controller {

	public $restful = true;

	/**
	 * Create a new item
	 * @return null
	 */
	public function post_index()
	{
		$input = Input::json(true);

		if (!is_array($input))
			return null;

		$response = Item::create($input);
		$response = $response->to_array();
		$response['sub_items'] = array();
		return Response::json($response);
	}

	public function get_index($item_id = 0)
	{
		if ($item_id <= 0)
		{
			return Response::json(array());
		}

		$item = Item::where('id', '=', $item_id)->first();
		$output = (is_object($item)) ? $item->attributes : array();

		return Response::json($output);
	}

	/**
	 * Update item
	 * @return null
	 */
	public function put_index($id = 0)
	{
		$input = Input::json();

		if (!is_object($input) || !is_numeric($id) || $id <= 0)
			return null;

		$item = Item::find($id);

		if (!is_null($item))
		{
			$item->title = $input->title;
			$item->save();
		}
	}

	/**
	 * Delete item
	 * @return null
	 */
	public function delete_index($id = 0)
	{
		if (!is_numeric($id) || $id <= 0)
			return null;

		$item = Item::find($id);

		if (!is_null($item))
		{
			$item->subItems()->delete();	// Delete all subitem
			$item->delete();				// And delete the item
		}
	}

}
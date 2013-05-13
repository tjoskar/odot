<?php

class ItemController extends BaseController {

	/**
	 * Store a newly created item in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$title     = Input::get('title', '');
		$list_id   = (int) Input::get('list_id', 0);
		$order     = (int) Item::where('list_id', '=', $list_id)->max('order') + 1;

		if (empty($title) || $list_id < 0 || $order < 0)
		{
			return '';
		}

		$item = new Item();
		$item->title = $title;
		$item->list_id = $list_id;
		$item->order = $order;

		$item->save();
		return $item;
	}

	/**
	 * Display the specified item.
	 *
	 * @param  int  $item_id
	 * @return Response
	 */
	public function show($item_id)
	{
		if ($item_id <= 0)
		{
			return Response::json(array());
		}

		$item = Item::where('id', '=', $item_id)->first();				// TODO: Can we use "find" here?
		$output = (is_object($item)) ? $item->attributes : array();

		return Response::json($output);
	}

	/**
	 * Update the specified item in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$title     = Input::get('title', '');
		$completed = (int) Input::get('completed', 0);
		$order     = (int) Input::get('order', 0);

		if (empty($title) || $order < 0 || ($completed != 0 && $completed != 1) || $id < 0)
		{
			return '';
		}

		$item = Item::find($id);

		if (!is_null($item))
		{
			$item->title     = $title;
			$item->completed = $completed;
			$item->order     = $order;
			$item->save();
		}
	}

	/**
	 * Remove the specified item from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$id = (int) $id;
		$item = Item::find($id);

		if (!is_null($item))
		{
			$item->subItems()->delete();	// Delete all subitem
			$item->delete();				// And delete the item
		}
	}

}
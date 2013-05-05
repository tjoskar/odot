<?php

class ListController extends \BaseController {

	/**
	 * Get all lists
	 *
	 * @return JSON obj
	 */
	public function index()
	{
		return ItemList::all();
	}

	/**
	 * Criate a new list.
	 *
	 * @return JSON obj
	 */
	public function store()
	{
		$title   = Input::get('title', '');
		$user_id = (int) Input::get('user_id', 0);
		$order   = (int) Input::get('order', 0);

		if (empty($title) || $user_id < 0 || $order < 0)
		{
			return '';
		}

		$list = new ItemList();
		$list->title = $title;
		$list->user_id = $user_id;
		$list->order = $order;

		$list->save();
		return $list;
	}

	/**
	 * Get list with id $id
	 *
	 *  {
	 * 	  id,
	 *    title,
	 * 	  ...,
	 *    item {
	 *      :id {
	 *        id,
	 *        title,
	 *        ...
	 *        sub_items [
	 *          {
	 *            id,
	 *            title,
	 *            ...
	 *          },
	 *          ...
	 *        ]
	 *      }
	 *    }
	 *  }
	 *
	 * @param int $id
	 * @return JSON obj
	 */
	public function show($id)
	{
		$output = array();
		$id = (int) $id;

		if ($id <= 0)
			return Response::json($output);

		$list = ItemList::find($id);

		if (!is_object($list))
			// The list do not exist
			return Response::json($output);

		// Get all (not sub) items associated with the current list
		$items = $list->items()->orderBy('order', 'desc')->get();

		$output = $list->toArray();
		$output['items'] = array();

		foreach ($items as $item_obj)
		{
			$item = $item_obj->toArray();
			$item['sub_items'] = array();			// Create an empty array so we can insert subitems later
			$output['items'][$item['id']] = $item;
		}

		$sub_items = SubItem::where('list_id', '=', $id)->orderBy('order', 'desc')->get();

		// Insert the subitems
		foreach ($sub_items as $sub_item_obj)
		{
			$sub_item = $sub_item_obj->toArray();
			array_push($output['items'][$sub_item['item_id']]['sub_items'], $sub_item);
		}

		// ... and off we go..
		return Response::json($output);
	}

	/**
	 * Update the specified list
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified list
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
<?php

class ListController extends BaseController {

	private $_userID;

	public function __construct() {
		if (Auth::check())
		{
			$this->_userID = Auth::user()->id;
		}
		else
		{
			App::abort(401, 'You are not authorized.');
		}
	}

	/**
	 * Get all lists
	 *
	 * @return JSON obj
	 */
	public function index()
	{
		return User::find($this->_userID)->lists;
	}

	/**
	 * Criate a new list.
	 *
	 * @return JSON obj
	 */
	public function store()
	{
		$title   = Input::get('title', '');
		$order   = (int) ItemList::max('order') + 1;

		if (empty($title) || $order < 0)
		{
			return '';
		}

		$list = new ItemList();
		$list->title = $title;
		$list->user_id = $this->_userID;
		$list->order = $order;

		User::find($this->_userID)->lists()->save($list);

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
		$items = $list->items()->get();

		$output = $list->toArray();
		$output['items'] = array();

		foreach ($items as $item_obj)
		{
			$item = $item_obj->toArray();
			$item['sub_items'] = array();			// Create an empty array so we can insert subitems later
			$output['items'][$item['id']] = $item;
		}

		$sub_items = SubItem::where('list_id', '=', $id)->get();

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
		$title = Input::get('title', '');
		$order = (int) Input::get('order', 0);

		if (empty($title) || $order < 0 || $id < 0)
		{
			return '';
		}

		$list = ItemList::find($id);

		if (!is_null($list))
		{
			$list->title = $title;
			$list->order = $order;
			$list->save();
		}
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
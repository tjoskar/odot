<?php

class SubitemController extends \BaseController {

	/**
	 * Create a new subitem
	 *
	 * @return null
	 */
	public function store()
	{
		$title     = Input::get('title', '');
		$list_id   = (int) Input::get('list_id', 0);
		$item_id   = (int) Input::get('item_id', 0);
		$order     = (int) Input::get('order', 0);

		if (empty($title) || $list_id < 0 || $item_id < 0 || $order < 0)
		{
			return '';
		}

		$subItem = new SubItem();
		$subItem->title = $title;
		$subItem->list_id = $list_id;
		$subItem->item_id = $item_id;
		$subItem->order = $order;

		$subItem->save();
		return $subItem;
	}

	/**
	 * Update a subitem
	 *
	 * @param  int  $id
	 * @return null
	 */
	public function update($id)
	{
		$title     = Input::get('title', '');
		$list_id   = (int) Input::get('list_id', 0);
		$item_id   = (int) Input::get('item_id', 0);
		$order     = (int) Input::get('order', 0);
		$completed = (int) Input::get('completed', 0);

		if (empty($title) ||
			$list_id < 0  ||
			$item_id < 0  ||
			$order   < 0  ||
			$id      < 0  ||
			($completed != 0 && $completed != 1))
		{
			return '';
		}

		$subItem = SubItem::find($id);

		if (!is_null($subItem))
		{
			$subItem->title = $title;
			$subItem->list_id = $list_id;
			$subItem->item_id = $item_id;
			$subItem->order = $order;
			$subItem->save();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
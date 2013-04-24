<?php

class Lists_Controller extends Base_Controller {

	public $restful = true;

	/**
	 * Get all lists
	 * @return JSON obj
	 */
	public function get_index()
	{
		$output = array();
		$lists = ItemList::all();
		if (is_array($lists))
		{
			foreach ($lists as $list) {
				array_push($output, $list->attributes);
			}	
		}

		return Response::json($output);
	}

	/**
	 * Get list with id $list_id
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
	 * @param int $list_id 
	 * @return JSON obj
	 */
	public function get_list($list_id)
	{
		$output = array();
		$list_id = (int) $list_id;

		if ($list_id <= 0)
			return Response::json($output);
		
		$list = ItemList::find($list_id);

		if (!is_object($list))
			// The list do not exist
			return Response::json($output);

		// Get all (not sub) items associated with the current list
		$items = $list->items()->order_by('order', 'desc')->get();

		$output = $list->to_array();
		$output['items'] = array();

		foreach ($items as $item_obj)
		{
			$item = $item_obj->to_array();
			$item['sub_items'] = array();			// Create an empty array so we can insert subitems later
			$output['items'][$item['id']] = $item;
		}

		$sub_items = SubItem::where('list_id', '=', $list_id)->order_by('order', 'desc')->get();
		
		// Insert the subitems
		foreach ($sub_items as $sub_item_obj)
		{
			$sub_item = $sub_item_obj->to_array();
			array_push($output['items'][$sub_item['item_id']]['sub_items'], $sub_item);
		}

		// ... and off we go..
		return Response::json($output);
	}

	/**
	 * Create a new list
	 * @return null
	 */
	public function post_list()
	{
		return 'Hejs';
		// Create a new list
	}

	/**
	 * Delete list
	 * @param int $list_id 
	 * @return none
	 */
	public function delete_list($list_id)
	{
		// Delete list
	}


}
<?php

class ListController extends BaseController {

	private $listItem_m;

	public function __construct()
    {
    	parent::__construct();
        $this->listItem_m = new ListItemModel();
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
		$model        = new ItemList();
		$model->title = Input::get('title', '');

		if (empty($model->title))
		{
			return Response::json(array('ststus' => 400));
		}

		$list = $this->listItem_m->save($model, $this->_userID);

		if (is_null($list))
		{
			return Response::json(array('ststus' => 400));
		}
		else
		{
			return $list;
		}
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
		$model        = new ItemList();
		$model->title = Input::get('title', '');
		$model->order = Input::get('order', -1);
		$model->id 	  = (int) $id;

		if (empty($model->order) || $model->order < 0 || $model->id <= 0)
		{
			return Response::json(array('ststus' => 400));
		}

		$list = $this->listItem_m->save($model, $this->_userID);

		if ($status)
		{
			return Response::json(array('status' => 200));
		}
		else
		{
			return Response::json(array('status' => 401));
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
		$id = (int) $id;
		$list = ListItem::find($id);

		/**

		    - What about user_lists ?

		**/


		if (!is_null($list))
		{
			$list->delete();
		}

		return;
	}

}
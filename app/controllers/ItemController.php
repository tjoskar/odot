<?php

class ItemController extends BaseController {

	private $Item_m;

	public function __construct()
    {
    	parent::__construct();
        $this->Item_m = new ItemModel();
    }

	/**
	 * Store a newly created item in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$model           = new stdClass;
		$model->title    = Input::get('title', '');
		$model->list_id  = (int) Input::get('list_id', 0);

		if (empty($model->title) || $model->list_id <= 0)
		{
			return Response::json(array('ststus' => 400));
		}

		$item = $this->Item_m->save($model, $this->_userID);

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

		$item = Item::find($item_id);
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
		$model            = new stdClass;
		$model->id        = $id;
		$model->list_id   = (int) Input::get('list_id', -1);
		$model->completed = (int) Input::get('completed', -1);
		$model->title     = (int) Input::get('title', '');
		$model->order     = (int) Input::get('order', -1);
        $model->due_date  = Input::get('due_date', '');

		if (empty($model->title) || $model->order  < 0 || ($model->completed != 0 && $model->completed != 1) || $model->id <= 0 || $model->list_id <= 0)
		{
			return Response::json(array('status' => 400));
		}

		$status = $this->Item_m->update($model, $this->_userID);

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
	 * Remove the specified item from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->Item_m->delete((int) $id);
	}

}

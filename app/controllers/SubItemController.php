<?php

class SubitemController extends BaseController {

	private $subItem_m;

	public function __construct()
    {
    	parent::__construct();
        $this->subItem_m = new SubItemModel();
    }

	/**
	 * Create a new subitem
	 *
	 * @return null
	 */
	public function store()
	{
		$model          = new stdClass;
		$model->title   = Input::get('title', '');
		$model->list_id = (int) Input::get('list_id', 0);
		$model->item_id = (int) Input::get('item_id', 0);

		if (empty($model->title) || $model->list_id <= 0 || $model->item_id <= 0)
		{
			return Response::json(array('ststus' => 400));
		}

		$subItem = $this->subItem_m->save($model, $this->_userID);

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
		$model            = new stdClass;
		$model->id 		  = (int) $id;
		$model->title     = Input::get('title', '');
		$model->list_id   = (int) Input::get('list_id', -1);
		$model->item_id   = (int) Input::get('item_id', -1);
		$model->order     = (int) Input::get('order', -1);
		$model->completed = (int) Input::get('completed', -1);

		if (empty($model->title)  ||
			$model->list_id <= 0  ||
			$model->item_id <= 0  ||
			$model->order   <  0  ||
			$model->id      <= 0  ||
			($model->completed != 0 && $model->completed != 1))
		{
			return Response::json(array('status' => 400));
		}

		$status = $this->subItem_m->update($model, $this->_userID);

		if (!$status)
		{
			return Response::json(array('status' => 401));
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
		$this->subItem_m->delete((int) $id);
	}

}
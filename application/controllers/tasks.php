<?php

class Tasks_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{
		$data = array(
			array(
				'id' => 3,
				'list_id' => 1,
				'title' => 'Buy milk',
				'time' => '1200000000',
				),
			array(
				'id' => 4,
				'list_id' => 1,
				'title' => 'Buy milk',
				'time' => '1200000000',
				),
			array(
				'id' => 5,
				'list_id' => 1,
				'title' => 'Buy milk',
				'time' => '1200000000',
				),
			array(
				'id' => 6,
				'list_id' => 1,
				'title' => 'Buy milk',
				'time' => '1200000000',
				),
			);

		return Response::json($data);
	}

}
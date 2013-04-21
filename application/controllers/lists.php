<?php

class Lists_Controller extends Base_Controller {

	public $restful = true;

	public function get_index($list_id = 0)
	{
		if ($list_id > 0)
			$type = 'list';
		else 
			$type = 'lists';
		
		$data = array(
			$type => 
			array(
				array(
					'title'    => 'To day',
					'owner'    => 'Oskar',
					'id'       => 1,
					'item_ids' => array(1, 2, 3, 4)
					),
				array(
					'title'    => 'Work',
					'owner'    => 'Jonas',
					'id'       => 2,
					'item_ids' => array(4, 5, 6, 7)
					),
				array(
					'title'    => 'School',
					'owner'    => 'Oskar',
					'id'       => 3,
					'item_ids' => array(1, 2, 3)
					),
				array(
					'title'    => 'Blandat',
					'owner'    => 'Oskar',
					'id'       => 4,
					'item_ids' => array(1)
					)
			));

		return Response::json($data);//, 200, array(), JSON_FORCE_OBJECT);
	}

}
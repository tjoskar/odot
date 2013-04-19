<?php

class Lists_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{
		$data = array(
			'lists' => 
			array(
				array(
					'title' => 'To day',
					'owner' => 'Oskar',
					'id' => 1
					),
				array(
					'title' => 'Work',
					'owner' => 'Jonas',
					'id' => 2
					),
				array(
					'title' => 'School',
					'owner' => 'Oskar',
					'id' => 3
					),
				array(
					'title' => 'Blandat',
					'owner' => 'Oskar',
					'id' => 4
					)
			));

		return Response::json($data);//, 200, array(), JSON_FORCE_OBJECT);
	}

}
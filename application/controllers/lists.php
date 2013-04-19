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
					'owner' => 'Oskar'
					),
				array(
					'title' => 'Work',
					'owner' => 'Jonas'
					),
				array(
					'title' => 'School',
					'owner' => 'Oskar'
					),
				array(
					'title' => 'Blandat',
					'owner' => 'Oskar'
					)
			));

		return Response::json($data);//, 200, array(), JSON_FORCE_OBJECT);
	}

}
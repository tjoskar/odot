<?php

class Tasks_Controller extends Base_Controller {

	public $restful = true;

	public function get_index()
	{

		$data = array(
			'tasks' => 
			array(
				array(
					'title' => 'Kill all jews',
					),
				array(
					'title' => 'Create a porn site',
					),
				array(
					'title' => 'Learn Ember',
					),
				array(
					'title' => 'Learn Laravel',
					),
				array(
					'title' => 'Update dropbox',
					),
				array(
					'title' => 'Update dropbox',
					),
				array(
					'title' => 'Update dropbox',
					)

			));

		return Response::json($data);
	}

}
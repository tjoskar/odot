<?php

class Items_Controller extends Base_Controller {

	public $restful = true;

	public function get_index($list_id = 0)
	{
		// $tasks = Item::all();

		// foreach ($tasks as $task)
		// {
		//      echo $task->name;
		// }

		// if ($list_id <= 0)
		// {
			$data = array(
				'items' => 
				array(
					array(
						'title' => 'Kill all jews',
						'list_id' => 6,
						),
					array(
						'title' => 'Create a porn site',
						'list_id' => 6,
						),
					array(
						'title' => 'Learn Ember',
						'list_id' => 1,
						),
					array(
						'title' => 'Learn Laravel',
						'list_id' => 1,
						),
					array(
						'title' => 'Update dropbox',
						'list_id' => 1,
						),
					array(
						'title' => 'Update dropbox',
						'list_id' => 1,
						),
					array(
						'title' => 'Update dropbox',
						'list_id' => 1,
						)
				)/*,
				'lists' => 
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
				)*/
				);
		// }
		// else
		// {
		// 	$data = array(
		// 			array(
		// 				'title' => $list_id.': Kill all jews',
		// 				),
		// 			array(
		// 				'title' => $list_id.': Create a porn site',
		// 				),
		// 			array(
		// 				'title' => $list_id.': Learn Ember',
		// 				),
		// 			array(
		// 				'title' => $list_id.': Learn Laravel',
		// 				),
		// 			array(
		// 				'title' => $list_id.': Update dropbox',
		// 				),
		// 			array(
		// 				'title' => $list_id.': Update dropbox',
		// 				),
		// 			array(
		// 				'title' => $list_id.': Update dropbox',
		// 				)
		// 		);
		// }

		return Response::json($data);
	}

}
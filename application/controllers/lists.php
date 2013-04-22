<?php

class Lists_Controller extends Base_Controller {

	public $restful = true;

	public function get_index($list_id = 0)
	{
		$output = array();

		if ($list_id == 0)
		{
			$lists = Lists::all();
			if (is_array($lists))
			{
				foreach ($lists as $list) {
					array_push($output, $list->attributes);
				}	
			}
		}
		elseif ($list_id > 0)
		{
			$tasks = Lists::where('list_id', '=', $list_id);
			if (is_array($tasks))
			{
				foreach ($tasks as $task) {
					array_push($output, $task->attributes);
				}
			}
		}

		return Response::json($output);
	}
}
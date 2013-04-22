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
			$items = Items::where('list_id', '=', $list_id)->get();
			if (is_array($items))
			{
				foreach ($items as $item) {
					array_push($output, $item->attributes);
				}
			}
		}

		return Response::json($output);
	}
}
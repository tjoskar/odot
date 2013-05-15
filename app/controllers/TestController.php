<?php

class TestController extends BaseController {

	public function getIndex()
	{
		$data = array('Oskar', 'Karlsson');

        $DBmodel = new DBmodel();

        $item = new StdClass;
        $item->title   = 'test';
        $item->list_id = '1';

        $t = $DBmodel->saveItem($item, 6);
        var_dump($t);

	}

}

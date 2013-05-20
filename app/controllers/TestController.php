<?php

class TestController extends Controller {

	public function getIndex()
	{
		$data = array('Oskar', 'Karlsson');

    $model = new ListItemModel();

    echo '<pre>';
    var_dump($model->getOwner(1));
    echo '</pre>';

  }

}

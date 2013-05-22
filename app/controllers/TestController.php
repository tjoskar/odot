<?php

/**
 * This class is a debug-class
 * @package default
 */

class TestController extends Controller {

	public function getIndex()
	{
        return;

        var_dump(App::environment());

        $m = new ListItemModel();

        //$num_of_sharing = $m->numSharing(4);

        //var_dump($num_of_sharing);

        var_dump($m->delete(4));

  }

}

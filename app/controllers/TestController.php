<?php

class TestController extends Controller {

	public function getIndex()
	{
		$data = array('Oskar', 'Karlsson');

        var_dump(App::environment());

        $m = new ListItemModel();

        // Get number of sharing
        //$num_of_sharing = $share_m->numSharing(4);

        //var_dump($num_of_sharing);

        var_dump($m->delete(4));





  }

}

<?php

class BaseController extends Controller {

	protected $_userID;

	public function __construct()
	{
		if (Auth::check())
		{
			$this->_userID = Auth::user()->id;
		}
		else
		{
			App::abort(401, 'You are not authorized.');
		}
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function missingMethod($parameters)
	{
    	return 'Vad syslar du med?';
	}

}
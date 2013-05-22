<?php

class BaseController extends Controller {

	protected $_userID;

    /**
     * Check if the user are login
     * @return void
     */
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


    /**
     * This function is calld when the user are trying to
     * access a function that dont exist
     * @param type $parameters
     * @return void
     */
	public function missingMethod($parameters)
	{
        App::abort(404, 'Cant find the requested methhod.');
	}

}

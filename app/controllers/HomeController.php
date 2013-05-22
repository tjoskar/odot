<?php

class HomeController extends Controller {

    /**
     * Start the ODOT app
     * @return View
     */
	public function index()
	{
		if (Auth::check())
		{
			return View::make('home');
		}

		return View::make('login');
	}

}

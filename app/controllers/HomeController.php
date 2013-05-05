<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
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
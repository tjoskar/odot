<?php

class Home_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/

	public function action_index() {
		return View::make('index');
	}
	
	public function action_get_login() {
		return View::make('login');
	}

	public function action_post_login() {
		$userdata = array(
        	'username'      => Input::get('username'),
        	'password'      => Input::get('password')
	    );

	    if ( Auth::attempt($userdata) )
	    {
	        // we are now logged in, go to home
	        Redirect::to('');
	        return true;
	    }
	    
	    // auth failure! lets go back to the login
	    return Redirect::to('login')->with('login_errors', true);
        // pass any error notification you want
        // i like to do it this way :)
	}

	public function action_get_logout() {
		Auth::logout();
    	return Redirect::to('login');
	}
}
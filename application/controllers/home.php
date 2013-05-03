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

    public $restful = true;

	public function get_index() {
		
		if(Auth::check()) {
			return View::make('index');	
		}

		return View::make('login');
	}

	public function post_login() {
		$userdata = array(
        	'username'      => Input::get('username'),
        	'password'      => Input::get('password')
	    );

	    if ( Auth::attempt($userdata) )
	    {
	        // we are now logged in
            $result = array('result' => 'Success');
            return json_encode($result);
	    }
	    
	    // auth failure!
        $result = array('result' => 'Failed');
        return json_encode($result);    
    }

	public function get_logout() {
		Auth::logout();
    	return Redirect::to('login');
	}

    public function post_register() {
        
        $username = Input::get('username');
        $password = Input::get('password');

        if (is_null($username) || empty($username) || is_null($password) || empty($password)) {
            $result = array('result' => 'Failed');
            return json_encode($result);
        }

        $user = new User();
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->save();
        
        $userdata = array(
            'username' => $username,
            'password' => $password
        );

        if ( Auth::attempt($userdata) )
        {
            $result = array('result' => 'Success');
            return json_encode($result);
        }

        $result = array('result' => 'Failed');
        return json_encode($result);
    }
}







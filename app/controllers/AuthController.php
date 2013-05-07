<?php

class AuthController extends \BaseController {

	public function postLogin()
    {
		// if (Request::ajax())
		$userdata = array(
        	'username'      => Input::get('username', ''),
        	'password'      => Input::get('password', '')
	    );

	    if ( Auth::attempt($userdata) )
	    {
	        // We are now logged in
            return json_encode(array('result' => 'Success'));
	    }

	    // Auth failure!
        return json_encode(array('result' => 'Failed'));
    }

    public function postLoginfacebook() 
    {
        
        $visible_name = Input::get('visible_name', '');
        $facebook_id = Input::get('facebook_id', '');

        $user = User::where('facebook_id', '=', $facebook_id)->first();
        
        //Create if non existing user
        if (is_null($user))
        {
            $user = new User();
            $user->facebook_id = $facebook_id;
            $user->visible_name = $visible_name;
            $user->save();
        }

        Auth::loginUsingId($user->id);
        return json_encode(array('result' => 'Success'));
    }

	public function getLogout() 
    {
		Auth::logout();
    	return Redirect::to('login');
	}

    public function postRegister()
    {
        // if (Request::ajax())
        $username = Input::get('username', '');
        $password = Input::get('password', '');

        if (empty($username) || empty($password))
        {
            return json_encode(array('result' => 'Failed'));
        }

        $user = new User();
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->save();

        if (Auth::login($user->id))
        {
            return json_encode(array('result' => 'Success'));
        }

        return json_encode(array('result' => 'Failed'));
    }

}
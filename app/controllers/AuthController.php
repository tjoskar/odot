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

        $userdata = array(
            'username' => $username,
            'password' => $password
        );

        if ( Auth::attempt($userdata) )
        {
            return json_encode(array('result' => 'Success'));
        }

        return json_encode(array('result' => 'Failed'));
    }

}
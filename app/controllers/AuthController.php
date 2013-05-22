<?php

/**

    - COMMENT CODE

**/


class AuthController extends Controller {

    /**
     * Handler the login post data
     * @return JSON object
     */
	public function postLogin()
    {
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
        $username = Input::get('username', '');
        $visible_name = Input::get('visible_name', '');
        $facebook_id = Input::get('facebook_id', '');

        $user = User::where('username', '=', $username)->where('facebook_id', '=', $facebook_id)->first();

        //Create if non existing user
        if (is_null($user))
        {
            $user = new User();
            $user->username = $username;
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
    	return json_encode(array('result' => 'Success'));
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
        $user->visible_name = $username;
        $user->save();

        Auth::loginUsingId($user->id);
        return json_encode(array('result' => 'Success'));
    }

}

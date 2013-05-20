<?php

class ShareListController extends Controller {

    public function postIsvalidusername()
    {
        $username = Input::get('username', '');
        $user = User::where('username', '=', $username)->first();

        if (!is_null($user))
        {
            return json_encode(array('result' => 'True'));
        }

        return json_encode(array('result' => 'False'));
    }
}
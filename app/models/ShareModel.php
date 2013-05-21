<?php

class ShareModel {

    private $_table;

    public function __construct()
    {
        $this->_table = new stdClass;

        // Set tables name
        $this->_table->subItem = 'sub_items';
        $this->_table->userList = 'user_lists';
    }

    public function getUsernameForShareList($list_id, $exept_userID)
    {
        $return = array();

        if ($list_id <= 0 && $exept_userID <= 0)
            return $return;

        $usernames = DB::table('user_lists as ul')
            ->join('users as u', 'u.id', '=', 'ul.user_id')
            ->where('ul.list_id', $list_id)
            ->where('u.id', '!=', $exept_userID)
            ->select('u.visible_name')->get();

        if (!is_null($usernames))
        {
            // Format the response
            foreach ($usernames as $user)
            {
                array_push($return, $user->visible_name);
            }
        }
        return $return;
    }

    public function getUser($username)
    {
        return User::where('username', '=', $username)->first();
    }

    public function isUserSharingList($list_id, $user_id)
    {
        $db = DB::table('user_lists')->where('list_id', $list_id)->where('user_id', $user_id)->get();
        return !empty($db);
    }

    public function shareList($user_id, $list_id)
    {
        DB::table('user_lists')->insert(
            array('user_id' => $user_id, 'list_id' => $list_id)
        );
    }

    public function removeSharing($user_id, $list_id)
    {
        DB::table('user_lists')->where('user_id', $user_id)->where('list_id', $list_id)->delete();
    }

    public function numSharing($list_id)
    {
        return DB::table('user_lists')->where('list_id', $list_id)->count('id');
    }

}

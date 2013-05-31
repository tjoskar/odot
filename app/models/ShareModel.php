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

    /**
     * Get the usernames for the users sharing the list
     * @param int $list_id
     * @param int $exept_userID
     * @return array usernames
     */
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

    /**
     * Get the user with username an ListItem model
     * @param String $username
     * @return User user
     */
    public function getUser($username)
    {
        return User::where('username', '=', $username)->first();
    }

    /**
     * Is the user sharing the list
     * @param int $list_id
     * @param int $user_id
     * @return bool isSharing
     */
    public function isUserSharingList($list_id, $user_id)
    {
        $db = DB::table('user_lists')->where('list_id', $list_id)->where('user_id', $user_id)->get();
        return !empty($db);
    }

    /**
     * Share list with user
     * @param int $user_id
     * @param int $list_id
     * @return void
     */
    public function shareList($user_id, $list_id)
    {
        DB::table('user_lists')->insert(
            array('user_id' => $user_id, 'list_id' => $list_id)
        );
    }

    /**
     * Stop sharing list with user
     * @param int $user_id
     * @param int $list_id
     * @return bool success
     */
    public function removeSharing($user_id, $list_id)
    {
        DB::table('user_lists')->where('user_id', $user_id)->where('list_id', $list_id)->delete();
    }

    /**
     * Number of users sharing list
     * @param int $list_id
     * @return int numUsers
     */
    public function numSharing($list_id)
    {
        return DB::table('user_lists')->where('list_id', $list_id)->count('id');
    }

}

<?php

class UserListsTableSeeder extends Seeder {

    public function run()
    {

    	DB::table('user_lists')->delete();

        $user_lists = array(
            array(
                'user_id' => 1,     // Oskar
                'list_id' => 1),    // Today
            array(
                'user_id' => 1,     // Oskar
                'list_id' => 2),    // Work
            array(
                'user_id' => 1,     // Oskar
                'list_id' => 3),    // School
            array(
                'user_id' => 1,     // Oskar
                'list_id' => 4),    // Bucket List
            array(
                'user_id' => 2,     // Jonas
                'list_id' => 1),    // Today
            array(
                'user_id' => 2,     // Jonas
                'list_id' => 5),    // Trädgården
            array(
                'user_id' => 3,     // Jonas facebook
                'list_id' => 1),    // Today
            array(
                'user_id' => 3,     // Jonas facebook
                'list_id' => 6),    // Blandat
            array(
                'user_id' => 3,     // Jonas facebook
                'list_id' => 7),    // Bilen
            array(
                'user_id' => 4,     // John Doe
                'list_id' => 1),    // Today
            array(
                'user_id' => 4,     // John Doe
                'list_id' => 8),    // Skolan
        );

        DB::table('user_lists')->insert($user_lists);
    }

}

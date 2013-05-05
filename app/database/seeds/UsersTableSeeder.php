<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	// DB::table('users')->delete();

        $users = array(
            array(
                'username'  => 'Oskar',
                'password'  => Hash::make('arm'),
                'created_at'  => new DateTime,
                'updated_at' => new DateTime)
        );

        DB::table('users')->insert($users);
    }

}
<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
    	DB::table('users')->delete();

        $users = array(
            array( // ID 1
                'username'     => 'Oskar',
                'password'     => Hash::make('osk'),
                'created_at'   => new DateTime,
                'updated_at'   => new DateTime,
                'visible_name' => null,
                'facebook_id'  => null),
            array( // ID 2
                'username'     => 'Jonas',
                'password'     => Hash::make('jon'),
                'created_at'   => new DateTime,
                'updated_at'   => new DateTime,
                'visible_name' => null,
                'facebook_id'  => null),
            array( // ID 3
                'username'     => 'j.bromo',
                'password'     => null,
                'created_at'   => new DateTime,
                'updated_at'   => new DateTime,
                'visible_name' => 'Jonas Bromö',
                'facebook_id'  => '100000048721511'),
            array( // ID 4
                'username'     => 'JohnDoe',
                'password'     => Hash::make('joh'),
                'created_at'   => new DateTime,
                'updated_at'   => new DateTime,
                'visible_name' => null,
                'facebook_id'  => null),
        );

        DB::table('users')->insert($users);
    }

}

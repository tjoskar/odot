<?php

class ListsTableSeeder extends Seeder {

    public function run()
    {
    	DB::table('lists')->delete();

        $lists = array(
            array(  // ID 1
                'title'      => 'Today',
                'order'      => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(  // ID 2
                'title'      => 'Work',
                'order'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(  // ID 3
                'title'      => 'School',
                'order'      => 2,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(  // ID 4
                'title'      => 'Bucket List',
                'order'      => 3,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(  // ID 5
                'title'      => 'Trädgården',
                'order'      => 4,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(  // ID 6
                'title'      => 'Blandat',
                'order'      => 5,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(  // ID 7
                'title'      => 'Bilen',
                'order'      => 6,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(  // ID 8
                'title'      => 'Skolan',
                'order'      => 7,
                'created_at' => new DateTime,
                'updated_at' => new DateTime)
        );

        DB::table('lists')->insert($lists);
    }

}

<?php

class ItemsTableSeeder extends Seeder {

    public function run()
    {
    	DB::table('items')->delete();

        $items = array(
            array( // ID 1
                'list_id'    => 1,          // Today
                'title'      => 'Äta lunch',
                'completed'  => 0,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 2
                'list_id'    => 1,          // Today
                'title'      => 'Se på tv',
                'completed'  => 0,
                'order'      => 1,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 3
                'list_id'    => 1,          // Today
                'title'      => 'Läsa mail',
                'completed'  => 0,
                'order'      => 2,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 4
                'list_id'    => 1,          // Today
                'title'      => 'Vakna',
                'completed'  => 1,
                'order'      => 3,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 5
                'list_id'    => 2,          // Work
                'title'      => 'Löneförhandla',
                'completed'  => 0,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 6
                'list_id'    => 3,          // School
                'title'      => 'Ta examen',
                'completed'  => 0,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 7
                'list_id'    => 4,          // Bucket List
                'title'      => 'Run New York marathon',
                'completed'  => 0,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 8
                'list_id'    => 5,          // Trädgården
                'title'      => 'Plantera om alla träd',
                'completed'  => 1,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 9
                'list_id'    => 6,          // Blandat
                'title'      => 'Ät godis',
                'completed'  => 0,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 10
                'list_id'    => 7,          // Bilen
                'title'      => 'Byt tändstift',
                'completed'  => 0,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array( // ID 11
                'list_id'    => 8,          // Skolan
                'title'      => 'Gör klart alla labbar',
                'completed'  => 0,
                'order'      => 0,
                'due_date'   => null,
                'created_at' => new DateTime,
                'updated_at' => new DateTime)

        );

        DB::table('items')->insert($items);
    }

}

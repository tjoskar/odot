<?php

class SubItemsTableSeeder extends Seeder {

    public function run()
    {
    	DB::table('sub_items')->delete();

        $sub_items = array(
            array(
                'list_id'    => 1,  // Today
                'item_id'    => 1,  // Äta lunch
                'title'      => 'Beställa',
                'completed'  => 1,
                'order'      => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(
                'list_id'    => 1,  // Today
                'item_id'    => 1,  // Äta lunch
                'title'      => 'Äta',
                'completed'  => 0,
                'order'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(
                'list_id'    => 1,  // Today
                'item_id'    => 1,  // Äta lunch
                'title'      => 'Betala',
                'completed'  => 0,
                'order'      => 2,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(
                'list_id'    => 1,  // Today
                'item_id'    => 2,  // Se på tv
                'title'      => 'Family guy',
                'completed'  => 0,
                'order'      => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
            array(
                'list_id'    => 1,  // Today
                'item_id'    => 2,  // Se på tv
                'title'      => 'Dexter',
                'completed'  => 1,
                'order'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime),
        );

        DB::table('sub_items')->insert($sub_items);
    }

}

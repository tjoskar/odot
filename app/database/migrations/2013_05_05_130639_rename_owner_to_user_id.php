<?php

use Illuminate\Database\Migrations\Migration;

class RenameOwnerToUserId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lists', function($table)
		{
    		$table->renameColumn('owner', 'user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lists', function($table)
		{
    		$table->renameColumn('user_id', 'owner');
		});
	}

}
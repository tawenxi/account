<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScaffoldinterfacesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scaffoldinterfaces', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('package');
			$table->string('migration');
			$table->string('model');
			$table->string('controller');
			$table->string('views');
			$table->string('tablename');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scaffoldinterfaces');
	}

}

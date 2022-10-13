<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('SKR')->nullable()->default('');
			$table->string('SKYH')->nullable()->default('');
			$table->string('SKZH')->nullable()->default('');
			$table->string('ZFFS')->nullable()->default('');
			$table->string('ZY')->nullable()->default('');
			$table->string('amount')->nullable()->default('');
			$table->string('beizhu')->nullable()->default('');
			$table->boolean('done')->nullable()->default(0);
			$table->string('label')->nullable()->default('');
			$table->string('tagged')->nullable()->default('0');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tasks');
	}

}

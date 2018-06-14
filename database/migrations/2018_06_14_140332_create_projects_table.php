<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('village_id')->nullable();
			$table->string('category');
			$table->string('name');
			$table->integer('year')->nullable();
			$table->integer('bidprice')->nullable();
			$table->integer('contractprice')->nullable();
			$table->integer('budget')->nullable();
			$table->integer('settlementprice')->nullable();
			$table->text('describe', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}

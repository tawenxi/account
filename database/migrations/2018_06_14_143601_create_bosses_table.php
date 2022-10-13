<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBossesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bosses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('bank');
			$table->string('bankaccount');
			$table->decimal('totalpayout', 10)->nullable();
			$table->integer('payoutcount')->nullable();
			$table->boolean('supportpoor')->default(0);
			$table->string('description')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bosses');
	}

}

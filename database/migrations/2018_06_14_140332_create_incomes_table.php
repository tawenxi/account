<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIncomesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incomes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('date');
			$table->string('zhaiyao');
			$table->string('xingzhi')->nullable();
			$table->float('amount', 10, 0);
			$table->float('cost')->nullable();
			$table->string('kemu')->nullable();
			$table->string('pid')->nullable();
			$table->string('beizhu')->nullable();
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
		Schema::drop('incomes');
	}

}

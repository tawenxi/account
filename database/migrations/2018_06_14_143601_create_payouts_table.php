<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payouts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('payee');
			$table->string('payeeaccount');
			$table->string('payeebanker');
			$table->float('amount', 10, 0)->nullable();
			$table->string('zhaiyao');
			$table->string('zbid');
			$table->string('kemu');
			$table->string('label')->nullable()->default('0');
			$table->string('kemuname');
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
		Schema::drop('payouts');
	}

}

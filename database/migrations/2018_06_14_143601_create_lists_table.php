<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lists', function(Blueprint $table)
		{
			$table->string('gsdm')->default('');
			$table->string('kjqj');
			$table->string('pzly')->default('');
			$table->string('pzh');
			$table->string('pzrq');
			$table->string('fjzs')->default('0');
			$table->string('srID')->default('9');
			$table->string('sr')->default('刘小勇');
			$table->integer('shID')->default(-1);
			$table->string('sh')->default('');
			$table->string('jsr')->default('');
			$table->integer('jzrID')->default(-1);
			$table->string('jzr')->default('');
			$table->string('srrq');
			$table->string('shrq')->default('');
			$table->string('jzrq')->default('');
			$table->string('pzhzkmdy')->default('0');
			$table->string('pzhzbz')->default('0');
			$table->string('zt')->default('1');
			$table->string('pzzy');
			$table->decimal('pzje', 20);
			$table->string('CN')->default('');
			$table->string('BZ')->default('');
			$table->string('kjzg')->default('遂川财政局');
			$table->string('idpzh')->default('');
			$table->increments('id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lists');
	}

}

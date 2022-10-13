<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFenlusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fenlus', function(Blueprint $table)
		{
			$table->string('gsdm')->default('');
			$table->string('kjqj');
			$table->string('pzly')->default('');
			$table->string('pzh');
			$table->integer('flh');
			$table->string('zy');
			$table->string('kmdm');
			$table->string('wbdm')->default('');
			$table->string('hl')->default('1');
			$table->enum('jdbz', array('借','贷'));
			$table->string('wbje')->default('0');
			$table->decimal('je', 20);
			$table->string('spz')->default(' ');
			$table->string('wldrq');
			$table->string('sl')->default('0');
			$table->string('dj')->default('0');
			$table->string('bmdm')->default('');
			$table->string('wldm')->default('001');
			$table->string('xmdm')->default('');
			$table->string('fzsm1')->default(' ');
			$table->string('fzsm2')->default(' ');
			$table->string('fzsm3')->default(' ');
			$table->string('fzsm4')->default(' ');
			$table->string('fzsm5')->default(' ');
			$table->string('fzsm6')->default(' ');
			$table->string('fzsm7')->default(' ');
			$table->string('fzsm8')->default(' ');
			$table->string('fzsm9')->default(' ');
			$table->string('cess')->default('0');
			$table->string('fplx')->default('');
			$table->string('fprq')->default('');
			$table->string('fphfw1')->default('0');
			$table->string('fphfw2')->default('0');
			$table->string('jsfs')->default(' ');
			$table->string('zydm')->default('');
			$table->string('fzdm4')->default('');
			$table->string('fzdm5')->default('');
			$table->string('fzdm6')->default('');
			$table->string('fzdm7')->default('');
			$table->string('fzdm8')->default('');
			$table->string('fzdm9')->default('');
			$table->string('fzdm10')->default('');
			$table->integer('list_id')->unsigned();
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
		Schema::drop('fenlus');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuzzledbsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guzzledbs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('body', 65535)->nullable();
			$table->string('DZKDM');
			$table->string('DZKMC');
			$table->string('YSDWDM');
			$table->string('YSDWMC');
			$table->string('ZJXZDM');
			$table->string('ZJXZMC');
			$table->string('ZFFSDM');
			$table->string('YSKMDM');
			$table->string('YSKMMC');
			$table->string('JFLXDM');
			$table->string('JFLXMC');
			$table->string('ZCLXDM');
			$table->string('ZCLXMC');
			$table->string('XMDM');
			$table->string('XMMC');
			$table->string('ZBLYDM');
			$table->string('ZBLYMC');
			$table->string('ZJLYMC');
			$table->bigInteger('YKJHZB');
			$table->bigInteger('YYJHJE');
			$table->bigInteger('KYJHJE');
			$table->string('YSGLLXDM');
			$table->string('YSGLLXMC');
			$table->string('NEWYSKMDM');
			$table->string('ZBID');
			$table->string('ZY');
			$table->string('ZBWH');
			$table->timestamps();
			$table->integer('useable')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('guzzledbs');
	}

}

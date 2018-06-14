<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZbAppliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zb_applies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('DZKDM')->nullable();
			$table->string('DZKMC')->nullable();
			$table->string('YSDWDM')->nullable();
			$table->string('YSDWMC')->nullable();
			$table->string('ZJXZDM')->nullable();
			$table->string('ZJXZMC')->nullable();
			$table->string('YSKMDM')->nullable();
			$table->string('YSKMMC')->nullable();
			$table->string('JFLXDM')->nullable();
			$table->string('JFLXMC')->nullable();
			$table->string('XMDM')->nullable();
			$table->string('XMMC')->nullable();
			$table->string('ZBLYDM')->nullable();
			$table->string('ZBLYMC')->nullable();
			$table->string('ZBJE')->nullable();
			$table->string('YFPJE')->nullable();
			$table->string('ZBYE')->nullable();
			$table->string('YKJHZB')->nullable();
			$table->string('YYJHJE')->nullable();
			$table->string('KYJHJE')->nullable();
			$table->string('YSGLLXDM')->nullable();
			$table->string('YSGLLXMC')->nullable();
			$table->string('NEWYSKMDM')->nullable();
			$table->string('ZBID')->nullable();
			$table->string('ZY')->nullable();
			$table->string('ZBWH')->nullable();
			$table->string('KZZLDM1')->nullable();
			$table->string('SYJE')->nullable();
			$table->string('JYJE')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zb_applies');
	}

}

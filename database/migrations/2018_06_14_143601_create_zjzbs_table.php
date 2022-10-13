<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZjzbsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zjzbs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('DZKDM')->default('');
			$table->string('DZKMC')->default('');
			$table->string('YSDWDM')->default('');
			$table->string('YSDWMC')->default('');
			$table->string('ZJXZDM')->default('');
			$table->string('ZJXZMC')->default('');
			$table->string('ZFFSDM')->default('');
			$table->string('YSKMDM')->default('');
			$table->string('YSKMMC')->default('');
			$table->string('JFLXDM')->default('');
			$table->string('JFLXMC')->default('');
			$table->string('ZCLXDM')->default('');
			$table->string('ZCLXMC')->default('');
			$table->string('XMDM')->default('');
			$table->string('XMMC')->default('');
			$table->string('ZBLYDM')->default('');
			$table->string('ZBLYMC')->default('');
			$table->string('ZJLYMC')->default('');
			$table->decimal('YKJHZB', 12)->default(0.00);
			$table->decimal('YYJHJE', 12)->default(0.00);
			$table->decimal('KYJHJE', 12)->default(0.00);
			$table->string('YSGLLXDM')->default('');
			$table->string('YSGLLXMC')->default('');
			$table->string('NEWYSKMDM')->default('');
			$table->string('ZBID')->default('');
			$table->string('ZY')->default('');
			$table->string('ZBWH')->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zjzbs');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGlPzmlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gl_pzml', function(Blueprint $table)
		{
			$table->char('gsdm', 12);
			$table->char('kjqj', 6)->index('_WA_Sys_kjqj_114A936A');
			$table->char('pzly', 2)->index('_WA_Sys_pzly_114A936A');
			$table->char('pzh', 10)->index('_WA_Sys_pzh_114A936A');
			$table->char('pzrq', 10)->index('_WA_Sys_pzrq_114A936A');
			$table->integer('fjzs');
			$table->integer('srID')->index('_WA_Sys_srID_114A936A');
			$table->char('sr', 10)->nullable();
			$table->integer('shID');
			$table->char('sh', 10)->nullable();
			$table->char('jsr', 10)->nullable();
			$table->integer('jzrID');
			$table->char('jzr', 10)->nullable();
			$table->char('srrq', 10);
			$table->char('shrq', 10);
			$table->char('jzrq', 10);
			$table->char('pzhzkmdy', 1)->nullable();
			$table->string('pzhzbz', 20)->nullable()->index('_WA_Sys_pzhzbz_114A936A');
			$table->boolean('zt')->index('_WA_Sys_zt_114A936A');
			$table->string('pzzy', 100)->nullable();
			$table->decimal('pzje', 20)->nullable();
			$table->string('CN', 10)->nullable();
			$table->string('BZ', 20)->nullable();
			$table->string('kjzg', 10)->nullable();
			$table->char('idpzh', 33)->nullable();
			$table->primary(['gsdm','kjqj','pzly','pzh']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gl_pzml');
	}

}

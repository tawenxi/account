<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGlPznrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gl_pznr', function(Blueprint $table)
		{
			$table->char('gsdm', 12);
			$table->char('kjqj', 6)->index('_WA_Sys_kjqj_1332DBDC');
			$table->char('pzly', 2)->index('_WA_Sys_pzly_1332DBDC');
			$table->char('pzh', 10)->index('_WA_Sys_pzh_1332DBDC');
			$table->smallInteger('flh')->index('_WA_Sys_flh_1332DBDC');
			$table->string('zy', 100)->nullable();
			$table->char('kmdm', 16)->index('_WA_Sys_kmdm_1332DBDC');
			$table->char('wbdm', 10)->index('_WA_Sys_wbdm_1332DBDC');
			$table->float('hl', 10, 0);
			$table->char('jdbz', 2)->index('_WA_Sys_jdbz_1332DBDC');
			$table->float('wbje', 10, 0);
			$table->decimal('je', 20);
			$table->char('spz', 30)->nullable();
			$table->char('wldrq', 8)->nullable();
			$table->float('sl', 10, 0);
			$table->float('dj', 10, 0);
			$table->char('bmdm', 12)->index('_WA_Sys_bmdm_1332DBDC');
			$table->char('wldm', 20)->index('_WA_Sys_wldm_1332DBDC');
			$table->char('xmdm', 12)->index('_WA_Sys_xmdm_1332DBDC');
			$table->string('fzsm1', 30)->nullable();
			$table->string('fzsm2', 30)->nullable();
			$table->string('fzsm3', 30)->nullable();
			$table->string('fzsm4', 30)->nullable();
			$table->string('fzsm5', 30)->nullable();
			$table->string('fzsm6', 30)->nullable();
			$table->string('fzsm7', 30)->nullable();
			$table->string('fzsm8', 30);
			$table->string('fzsm9', 30)->nullable();
			$table->float('cess', 10, 0);
			$table->char('fplx', 10);
			$table->char('fprq', 8);
			$table->integer('fphfw1');
			$table->integer('fphfw2');
			$table->char('jsfs', 20)->nullable();
			$table->char('zydm', 6)->nullable()->index('_WA_Sys_zydm_1332DBDC');
			$table->char('fzdm4', 12)->nullable()->index('_WA_Sys_fzdm4_1332DBDC');
			$table->char('fzdm5', 12)->nullable()->index('_WA_Sys_fzdm5_1332DBDC');
			$table->char('fzdm6', 12)->nullable()->index('_WA_Sys_fzdm6_1332DBDC');
			$table->char('fzdm7', 12)->nullable()->index('_WA_Sys_fzdm7_1332DBDC');
			$table->char('fzdm8', 12)->nullable()->index('_WA_Sys_fzdm8_1332DBDC');
			$table->char('fzdm9', 12)->nullable()->index('_WA_Sys_fzdm9_1332DBDC');
			$table->char('fzdm10', 12)->nullable()->index('_WA_Sys_fzdm10_1332DBDC');
			$table->primary(['gsdm','kjqj','pzly','pzh','flh']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gl_pznr');
	}

}

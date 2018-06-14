<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZbsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zbs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('GSDM');
			$table->string('KJND');
			$table->string('MXZBLB');
			$table->string('MXZBBH');
			$table->string('MXZBWH');
			$table->string('MXZBXH');
			$table->string('ZZBLB');
			$table->string('ZZBBH');
			$table->string('FWRQ');
			$table->string('DZKDM');
			$table->string('YSDWDM');
			$table->string('ZBLYDM');
			$table->string('YSKMDM');
			$table->string('ZJXZDM');
			$table->string('JFLXDM');
			$table->string('ZCLXDM');
			$table->string('XMDM');
			$table->string('ZFFSDM');
			$table->bigInteger('JE');
			$table->string('ZY');
			$table->string('LRR_ID');
			$table->string('LRR');
			$table->string('LR_RQ');
			$table->string('XGR_ID');
			$table->string('CSR_ID');
			$table->string('CSR');
			$table->string('CS_RQ');
			$table->string('HQBZ');
			$table->string('HQWCBZ');
			$table->string('SHJBR_ID');
			$table->string('SHR_ID');
			$table->string('SHR');
			$table->string('SH_RQ');
			$table->string('SNJZ');
			$table->string('NCYS');
			$table->string('BNZA');
			$table->string('BNZF');
			$table->string('BNBF');
			$table->bigInteger('ZBYE');
			$table->string('SJLY')->default('');
			$table->string('YZBLB');
			$table->string('YSGLLXDM');
			$table->string('ZBZT');
			$table->string('TZBZ');
			$table->string('JZRQ');
			$table->string('ZBID');
			$table->string('ZBIDWM')->default('');
			$table->string('DCBZ')->default('');
			$table->string('DCRID')->default('');
			$table->string('STAMP')->default('');
			$table->string('OAZT');
			$table->string('TZH');
			$table->string('JZR_ID');
			$table->string('PZFLH');
			$table->string('JZR_ID1');
			$table->string('PZFLH1');
			$table->string('DJZT');
			$table->string('SCJHJE');
			$table->string('DYBZ');
			$table->string('YWLXDM');
			$table->string('XMFLDM');
			$table->string('SJWH')->default('');
			$table->string('KZZLDM1')->default('');
			$table->string('ASHR_ID')->default('');
			$table->string('ASHR')->default('');
			$table->string('ASH_RQ')->default('');
			$table->string('ASHJD')->default('');
			$table->string('AXSHJD')->default('');
			$table->string('ASFTH')->default('');
			$table->string('ZBLB')->default('');
			$table->string('DZKMC')->default('');
			$table->string('ZBLYMC')->default('');
			$table->string('YSDWMC')->default('');
			$table->string('YSDWQC')->default('');
			$table->string('YSKMMC')->default('');
			$table->string('YSKMQC')->default('');
			$table->string('ZJXZMC')->default('');
			$table->string('XMMC')->default('');
			$table->string('YSGLLXMC')->default('');
			$table->string('HQNAME')->default('');
			$table->string('ZZBWH')->default('');
			$table->string('XMFLMC')->default('');
			$table->string('YWLXMC')->default('');
			$table->string('ZZBXH')->default('');
			$table->string('account_number', 50)->nullable();
			$table->bigInteger('yeamount')->default(0);
			$table->string('JFLXQC', 50)->nullable();
			$table->string('JFLXMC', 50)->nullable();
			$table->boolean('KYX')->default(0);
			$table->string('beizhu', 100)->nullable()->default('');
			$table->string('prezbid', 20)->nullable()->default('');
			$table->string('originzbid', 20)->nullable()->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zbs');
	}

}

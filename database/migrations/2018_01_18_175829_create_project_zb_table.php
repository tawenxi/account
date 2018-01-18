<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectZbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_zb', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsignned();
            $table->integer('zb_id')->unsignned();
            $table->decimal('amount',10,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_zb');
    }
}

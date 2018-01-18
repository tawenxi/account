<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('village');
            $table->string('category');
            $table->string('name');
            $table->integer('year')->nullable();
            $table->integer('bidprice')->nullable();
            $table->integer('contractprice')->nullable();
            $table->integer('settlementprice')->nullable();
            $table->text('describe')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

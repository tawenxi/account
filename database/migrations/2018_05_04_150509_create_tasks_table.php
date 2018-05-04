<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('SKR')->default('')->nullable();
            $table->string('SKYH')->default('')->nullable();

            $table->string('SKZH')->default('')->nullable();
            $table->string('ZFFS')->default('')->nullable();
            $table->string('ZY')->default('')->nullable();
            $table->string('amount')->default('')->nullable();
            $table->string('beizhu')->default('')->nullable();

            $table->boolean('done')->default(false)->nullable();
            $table->string('label')->default('')->nullable();
            $table->string('tagged')->default(false)->nullable();

        });
    }











    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

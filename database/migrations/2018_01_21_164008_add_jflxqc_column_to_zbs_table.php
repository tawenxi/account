<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJflxqcColumnToZbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
    {
        Schema::table('zbs', function (Blueprint $table) {
             $table->string('JFLXQC')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zbs', function (Blueprint $table) {
            $table->dropColumn('JFLXQC');
        });
    }
}
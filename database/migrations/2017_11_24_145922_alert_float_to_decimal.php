<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertFloatToDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fenlus', function (Blueprint $table) {
            $table->decimal('je',20,2)->change();
        });

        // Schema::table('lists', function (Blueprint $table) {
        //     $table->decimal('pzje',20,2)->change();
        // });

        // Schema::table('GL_Pznr', function (Blueprint $table) {
        //     $table->decimal('je',20,2)->change();
        // });

        // Schema::table('GL_Pzml', function (Blueprint $table) {
        //     $table->decimal('pzje',20,2)->change();
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fenlus', function (Blueprint $table) {
            //
        });
    }
}

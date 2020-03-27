<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlyerAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flyer_area', function (Blueprint $table) {
            $table->unsignedBigInteger('flyer_id');
            $table->unsignedBigInteger('area_id');
        });

        Schema::table('flyer_area', function ($table) {
            $table->foreign('flyer_id')->references('id')->on('flyers')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flyer_area', function (Blueprint $table) {
            //
        });
    }
}

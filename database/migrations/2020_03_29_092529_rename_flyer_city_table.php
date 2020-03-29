<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFlyerCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flyer_city', function (Blueprint $table) {
            $table->dropForeign(['flyer_id']);
            $table->dropForeign(['city_id']);
            $table->renameColumn('flyer_id', 'offer_id');
         });

         Schema::rename('flyer_city', 'offer_city');

         Schema::table('offer_city', function (Blueprint $table) {
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('city_id')->references('id')->on('cities');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlyerCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flyer_city', function(Blueprint $table)
		{
			$table->bigInteger('flyer_id')->unsigned();
			$table->bigInteger('city_id')->unsigned();
        });

        Schema::table('flyer_city', function ($table) {
            $table->foreign('flyer_id')->references('id')->on('flyers')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flyer_city');
	}

}

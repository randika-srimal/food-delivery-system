<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cities', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('district_id')->index('fk_cities_districts1_idx');
			$table->string('name_en', 45)->nullable();
			$table->string('name_si', 45)->nullable();
			$table->string('name_ta', 45)->nullable();
			$table->string('sub_name_en', 45)->nullable();
			$table->string('sub_name_si', 45)->nullable();
			$table->string('sub_name_ta', 45)->nullable();
			$table->string('postcode', 15)->nullable();
			$table->float('latitude', 10, 0)->nullable();
			$table->float('longitude', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cities');
	}

}

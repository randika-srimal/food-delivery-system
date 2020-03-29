<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_en');
            $table->string('css_class')->default('sub-category-default');
            $table->unsignedBigInteger('main_category_id');
            $table->timestamps();
        });

        Schema::table('offer_sub_categories', function ($table) {
            $table->foreign('main_category_id')->references('id')->on('offer_main_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_sub_categories');
    }
}

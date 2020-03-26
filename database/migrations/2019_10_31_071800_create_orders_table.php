<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pack_id');
            $table->unsignedBigInteger('area_id');
            $table->string('status')->default('Placed');
            $table->date('required_date');
            $table->text('other')->nullable();
            $table->timestamps();
        });

        Schema::table('orders', function ($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pack_id')->references('id')->on('packs')->onDelete('cascade');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_user_id_foreign');
            $table->dropForeign('orders_pack_id_foreign');
            $table->dropForeign('orders_aera_id_foreign');
            $table->dropIfExists('orders');
        });
    }
}

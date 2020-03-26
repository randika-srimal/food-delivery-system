<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('price');
            $table->text('items');
            $table->unsignedBigInteger('agent_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('packs', function ($table) {
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packs', function (Blueprint $table) {
            $table->dropForeign('packs_agent_id_foreign');
            $table->dropIfExists('packs');
        });
    }
}

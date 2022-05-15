<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_group', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('city_id')->onDelete('cascade');
            // $table->unsignedBigInteger('group_id')->onDelete('cascade');
            $table->foreignId('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreignId('group_id')->references('id')->on('groups')->onDelete('cascade');
            $table->timestamps();

            // $table->foreign('city_id')->references('id')->on('cities');
            // $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_group');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDangerousAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dangerous_areas', function (Blueprint $table) {
            $table->id();
            $table->double('latitude')->nullable(); //lat
            $table->double('longitude')->nullable(); //lng
            $table->unsignedBigInteger('disaster_category_id');
            $table->timestamps();

            $table->foreign('disaster_category_id')->references('id')->on('disaster_categories')->onDeleteCascade();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dangerous_areas');
    }
}

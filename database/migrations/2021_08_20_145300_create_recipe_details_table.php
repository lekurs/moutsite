<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('recipe_details', function (Blueprint $table) {
//            $table->id();
//            $table->text('description');
//            $table->text('picture_path')->nullable();
//            $table->string('slug', 255);
//            $table->timestamps();
//            $table->foreignId('user_id')->constrained();
////            $table->foreignId('device_id')->constrained();
//            $table->foreignId('recipe_id')->constrained();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('recipe_details');
    }
}

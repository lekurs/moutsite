<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimationsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimations_details', function (Blueprint $table) {
            $table->id();
            $table->string('product', 255);
            $table->text('description');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_price');
            $table->string('total_row', 100);
            $table->string('total_row_notax', 100);
            $table->string('total_row_tax', 100);
            $table->unsignedInteger('display_order');
            $table->unsignedInteger('estimation_id');
            $table->foreignId('taxe_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimations_details');
    }
}

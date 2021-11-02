<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimations', function (Blueprint $table) {
            $table->id();
            $table->string('reference', '255')->nullable();
            $table->string('title', '255');
            $table->boolean('validation')->default(false);
            $table->boolean('in_progress')->default(true);
            $table->date('validation_date')->nullable();
            $table->string('month', '2');
            $table->string('year', 4);
            $table->unsignedInteger('validation_duration');
            $table->text('observation')->nullable();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('contact_validator_id')->constrained('users');
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
        Schema::dropIfExists('estimations');
    }
}

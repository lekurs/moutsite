<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', '255');
            $table->text('description');
//            $table->text('result');
//            $table->string('mediaPortfolioProjectPath', 255);
//            $table->string('background_img_path', 255);
//            $table->string('colorProject', 7);
            $table->string('slug', 255);
            $table->boolean('in_progress')->default(true);
            $table->timestamp('endProject');
            $table->timestamps();
            $table->foreignId('client_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

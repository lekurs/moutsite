<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('contacts', function (Blueprint $table) {
//            $table->id();
//            $table->string('name', 150);
//            $table->string('lastname', 150);
//            $table->string('email', 255)->unique();
//            $table->string('phone', 20)->unique();
//            $table->string('slug', 255)->unique();
//            $table->string('fonction', 255)->nullable();
//            $table->string('picture_path', 255)->nullable();
//            $table->string('contact_function', 255);
//            $table->timestamps();
////            $table->integer('client_id')->unsigned();
////            $table->foreign('client_id')->references('id')->on('clients')
////                ->onDelete('cascade');
//            $table->foreignId('client_id')->constrained()->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}

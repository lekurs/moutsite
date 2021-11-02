<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->string('address', 255)->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('siren')->nullable();
            $table->string('slug', 255)->unique();
            $table->string('logo')->nullable();

            $table->timestamps();
        });

        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE clients CHANGE COLUMN zip zip INT(5) UNSIGNED ZEROFILL NULL ');
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}

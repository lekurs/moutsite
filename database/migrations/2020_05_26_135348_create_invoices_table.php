<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->boolean('advance')->default(false);
            $table->string('amount', 100)->nullable();
            $table->string('amount_no_tax', 100)->nullable();
            $table->string('amount_tax', 100)->nullable();
            $table->boolean('paid')->default(false);
            $table->string('month', '2');
            $table->string('year', '4');
            $table->text('observation')->nullable();
            $table->date('paiment_date')->nullable();
            $table->foreignId('estimation_id')->constrained()->nullable();
            $table->foreignId('client_id')->constrained();
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
        Schema::dropIfExists('invoices');
    }
}

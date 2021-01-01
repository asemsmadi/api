<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->string('Message');
            /*
             * 1 => add balance for investor
             * 6 => Removed By Admin
             * 2 => profit balance
             * 3 => Transfer From Investor
             * 4 => Transfer To Investor
             */
            $table->enum('type', [1, 2, 3, 4, 5, 6, 7, 8, 9]);
            $table->unsignedBigInteger('investor_id');
            $table->foreign('investor_id')->on('investors')->references('id')->cascadeOnDelete();
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
        Schema::dropIfExists('transactions');
    }
}

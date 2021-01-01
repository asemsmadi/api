<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->string('note');
            /*
             * 1 => wait to accept from Admin
             * 2 => success Transfer
             * 4 => Reject by admin
             */
            $table->enum('status', [1, 2, 3, 4, 5, 6]);
            $table->unsignedBigInteger('investor_id_From');
            $table->foreign('investor_id_From')->references('id')->on('investors');
            $table->unsignedBigInteger('investor_id_To');
            $table->foreign('investor_id_To')->references('id')->on('investors');
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
        Schema::dropIfExists('transfers');
    }
}

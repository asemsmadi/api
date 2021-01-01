<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->string('UserImage')->nullable();
            $table->string('UserCardImage')->nullable();
            $table->string('PassPortImage')->nullable();
            $table->string('PassPortNo')->nullable();
            $table->enum('accept', ['yes', 'no'])->default('no');
            $table->string('sponsorName')->nullable();
            $table->string('sponsorCardImage')->nullable();
            $table->string('sponsorPhone')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('investors');
    }
}

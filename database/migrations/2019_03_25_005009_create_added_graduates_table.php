<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddedGraduatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('added_graduates', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('graduate_id');
            $table->string('response_id')->nullable();
            $table->unique(['user_id', 'graduate_id']);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->onDelete('cascade');
            $table->foreign('response_id')->references('response_id')->on('responses')->onDelete('cascade');
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
        Schema::dropIfExists('added_graduates');
    }
}
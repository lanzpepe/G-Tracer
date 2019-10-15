<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->string('response_id')->primary();
            $table->string('company_name', 128);
            $table->string('company_address');
            $table->string('company_position', 128);
            $table->string('remarks')->nullable();
            $table->string('graduate_id');
            $table->string('user_id');
            $table->unique(['user_id', 'graduate_id']);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('graduate_id')->references('graduate_id')->on('graduates')->onDelete('cascade');
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
        Schema::dropIfExists('responses');
    }
}

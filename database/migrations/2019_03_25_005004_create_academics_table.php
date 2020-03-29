<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->string('academic_id')->primary();
            $table->string('code', 16);
            $table->string('degree', 64);
            $table->string('major', 64)->nullable();
            $table->string('department', 64);
            $table->string('school', 128);
            $table->string('year', 4);
            $table->string('batch', 16);
            $table->string('user_id')->nullable();
            $table->string('graduate_id')->nullable();
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
        Schema::dropIfExists('academics');
    }
}

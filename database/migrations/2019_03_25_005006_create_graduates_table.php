<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduates', function (Blueprint $table) {
            $table->string('graduate_id')->primary();
            $table->string('last_name', 64);
            $table->string('first_name', 64);
            $table->string('middle_name', 64);
            $table->string('gender', 8);
            $table->string('code', 16);
            $table->string('degree', 128);
            $table->string('major', 128)->nullable();
            $table->string('department', 128);
            $table->string('school', 128);
            $table->string('school_year', 32);
            $table->string('batch', 32);
            $table->string('image_uri')->nullable();
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('set null');
            $table->unique(['graduate_id', 'last_name', 'first_name', 'middle_name']);
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
        Schema::dropIfExists('graduates');
    }
}

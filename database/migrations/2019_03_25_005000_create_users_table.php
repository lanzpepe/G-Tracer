<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id', 32)->primary();
            $table->string('last_name', 64);
            $table->string('first_name', 64);
            $table->string('middle_name', 64);
            $table->string('gender', 8);
            $table->string('birth_date', 32);
            $table->string('image_uri')->nullable();
            $table->unique(['last_name', 'first_name', 'middle_name']);
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
        Schema::dropIfExists('users');
    }
}

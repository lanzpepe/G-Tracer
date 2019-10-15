<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraduateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduate_tasks', function (Blueprint $table) {
            $table->string('task_id')->primary();
            $table->string('description');
            $table->string('deadline');
            $table->unsignedInteger('respondent_count');
            $table->unsignedInteger('reward_points');
            $table->boolean('status');
            $table->string('graduate_id');
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
        Schema::dropIfExists('graduate_tasks');
    }
}

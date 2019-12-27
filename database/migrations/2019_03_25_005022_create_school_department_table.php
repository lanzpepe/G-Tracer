<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_department', function (Blueprint $table) {
            $table->string('school_id', 32);
            $table->string('dept_id', 32);
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unique(['dept_id', 'school_id']);
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
        Schema::dropIfExists('school_department');
    }
}

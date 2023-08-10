<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        if(!Schema::hasTable('employees'))
        {
         Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('job_title')->nullable();
            $table->string('hiring_date')->nullable();
            $table->string('image')->nullable();
            $table->date('birthday')->nullable(); 
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('address')->nullable(); 
            $table->string('slug');
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}

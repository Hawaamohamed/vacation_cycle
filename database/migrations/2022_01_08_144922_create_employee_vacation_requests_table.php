<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeVacationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_vacation_requests', function (Blueprint $table) {
            $table->increments('id'); 
            $table->integer('request_id');   
            $table->date('vacation_from');  
            $table->date('vacation_to');  
            $table->longText('reason')->nullable();  
            $table->string('vacation_type'); 
            $table->integer('year'); 
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('employee_id');  
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('employee_vacation_requests');
    }
}

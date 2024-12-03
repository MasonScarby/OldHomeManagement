<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRostersTable extends Migration
{
    public function up()
{
    Schema::create('rosters', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->unsignedBigInteger('supervisor_id');
        $table->unsignedBigInteger('doctor_id');
        $table->unsignedBigInteger('caregiver1_id');
        $table->unsignedBigInteger('caregiver2_id');
        $table->unsignedBigInteger('caregiver3_id');
        $table->unsignedBigInteger('caregiver4_id');
        
        // Define foreign keys
        $table->foreign('supervisor_id')->references('id')->on('users');
        $table->foreign('doctor_id')->references('id')->on('users');
        $table->foreign('caregiver1_id')->references('id')->on('users');
        $table->foreign('caregiver2_id')->references('id')->on('users');
        $table->foreign('caregiver3_id')->references('id')->on('users');
        $table->foreign('caregiver4_id')->references('id')->on('users');
        
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('rosters');
    }

}

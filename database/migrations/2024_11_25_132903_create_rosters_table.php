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
        $table->unsignedBigInteger('supervisor');
        $table->unsignedBigInteger('doctor');
        $table->unsignedBigInteger('caregiver1');
        $table->unsignedBigInteger('caregiver2');
        $table->unsignedBigInteger('caregiver3');
        $table->unsignedBigInteger('caregiver4');
        
        // Define foreign keys
        $table->foreign('supervisor')->references('id')->on('users');
        $table->foreign('doctor')->references('id')->on('users');
        $table->foreign('caregiver1')->references('id')->on('users');
        $table->foreign('caregiver2')->references('id')->on('users');
        $table->foreign('caregiver3')->references('id')->on('users');
        $table->foreign('caregiver4')->references('id')->on('users');
        
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('rosters');
    }

}

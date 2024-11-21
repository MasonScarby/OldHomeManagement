<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('caregiver1');
            $table->unsignedBigInteger('caregiver2');
            $table->unsignedBigInteger('caregiver3');
            $table->unsignedBigInteger('caregiver4');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('supervisor_id')->references('id')->on('supervisors')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('caregiver1')->references('id')->on('caregivers')->onDelete('cascade');
            $table->foreign('caregiver2')->references('id')->on('caregivers')->onDelete('cascade');
            $table->foreign('caregiver3')->references('id')->on('caregivers')->onDelete('cascade');
            $table->foreign('caregiver4')->references('id')->on('caregivers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rosters');
    }
};
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
            $table->foreignId('supervisor_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('caregiver1')->constrained('caregivers')->onDelete('cascade');
            $table->foreignId('caregiver2')->constrained('caregivers')->onDelete('cascade');
            $table->foreignId('caregiver3')->constrained('caregivers')->onDelete('cascade');
            $table->foreignId('caregiver4')->constrained('caregivers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rosters');
    }
};
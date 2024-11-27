<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_logs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('caregiver_id')->constrained('users')->onDelete('cascade');
            $table->boolean('morning_med_status')->default(false);
            $table->boolean('afternoon_med_status')->default(false);
            $table->boolean('night_med_status')->default(false);
            $table->boolean('breakfast_status')->default(false);
            $table->boolean('lunch_status')->default(false);
            $table->boolean('dinner_status')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_logs');
    }
};
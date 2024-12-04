<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prescription', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade'); 
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade'); 
            $table->string(column: 'morning_med');
            $table->string(column: 'afternoon_med');
            $table->string(column: 'night_med');
            $table->string(column: 'comment')->nullable();
            $table->date('date');
            
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription');
    }
};
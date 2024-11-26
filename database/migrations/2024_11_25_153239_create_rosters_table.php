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
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('supervisor');
            $table->unsignedBigInteger('doctor');
            $table->unsignedBigInteger('caregiver1');
            $table->unsignedBigInteger('caregiver2');
            $table->unsignedBigInteger('caregiver3');
            $table->unsignedBigInteger('caregiver4');
            $table->timestamps();

            $table->foreign('supervisor')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('doctor')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('caregiver1')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('caregiver2')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('caregiver3')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('caregiver4')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};

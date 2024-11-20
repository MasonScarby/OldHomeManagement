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
            $table->string('supervisor');
            $table->string('doctor');
            $table->string('caregiver1');
            $table->string('caregiver2');
            $table->string('caregiver3');
            $table->string('caregiver4');
            $table->string('role_id')->default('0');

        
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rosters');
    }
    
    
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('email', 30)->unique();
            $table->string('password', 255);
            $table->string('phone', 15);
            $table->date('date_of_birth');
            $table->boolean('is_approved')->default(false); // Set default value to false
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

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
        Schema::create('teacher_cruds', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->nullable()->unique();
            $table->string('teacher_name');
            $table->string('role')->default('teacher');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('password');
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->string('image')->nullable();
            $table->string('email');
            $table->string('mobile');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('qualification');
            $table->integer('experience')->nullable();
            $table->string('documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_cruds');
    }
};

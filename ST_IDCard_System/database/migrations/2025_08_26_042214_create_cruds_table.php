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
        Schema::create('cruds', function (Blueprint $table) {
            $table->id();
            $table->string('student_uid', 50)->unique()->default('std_uid_2450');
            $table->string('name', 100);
            $table->string('father_name', 100);
            $table->string('mother_name', 100);
            $table->string('email', 100)->unique();
            $table->string('mobile', 15);
            $table->enum('gender', ['Male', 'Female']);
            $table->date('dob')->nullable();
            $table->string('class_name')->nullable();
            $table->string('image')->nullable(); // profile image path
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruds');
    }
};

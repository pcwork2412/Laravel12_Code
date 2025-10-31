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
        Schema::create('marksheet_histories', function (Blueprint $table) {
            $table->id();
            $table->string('student_uid', 20);
            $table->string('student_name', 100);
            $table->string('class_name', 20);
            $table->string('section_name', 10);
            $table->enum('generation_type', ['single', 'classwise'])->default('single');
            $table->enum('action_type', ['preview', 'generate'])->default('generate');
            $table->string('generated_by', 50)->nullable();
            $table->timestamp('generated_at');
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['class_name', 'section_name']);
            $table->index('student_uid');
            $table->index('generated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marksheet_histories');
    }
};

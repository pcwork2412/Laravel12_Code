<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('id_card_histories', function (Blueprint $table) {
            $table->id();
            $table->string('student_uid');
            $table->string('student_name');
            $table->string('class_name');
            $table->string('section_name');
            $table->enum('action_type', ['preview', 'generate'])->default('preview');
            $table->enum('generation_type', ['single', 'classwise'])->default('single');
            $table->string('generated_by')->nullable(); // Admin/User who generated
            $table->timestamp('generated_at');
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index('student_uid');
            $table->index(['class_name', 'section_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('id_card_histories');
    }
};
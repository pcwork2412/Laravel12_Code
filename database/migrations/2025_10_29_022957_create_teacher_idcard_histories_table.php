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
        Schema::create('teacher_idcard_histories', function (Blueprint $table) {
            $table->id();
               $table->string('teacher_id');
            $table->string('teacher_name');
            $table->string('mobile');
            $table->string('email');
            $table->enum('action_type', ['preview', 'generate'])->default('preview');
            $table->enum('generation_type', ['single', 'classwise'])->default('single');
            $table->string('generated_by')->nullable(); // Admin/User who generated
            $table->timestamp('generated_at');
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index('teacher_id');
            $table->index(['mobile', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_idcard_histories');
    }
};

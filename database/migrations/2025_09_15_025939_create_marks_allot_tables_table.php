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
        
         Schema::create('marks_allot_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->string('subject_name');
            $table->integer('max_marks')->default(100);
            $table->integer('obtained_marks');
            $table->string('exam_type')->nullable(); // Midterm/Final/Unit Test
            $table->year('year')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('cruds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks_allot_tables');
    }
};

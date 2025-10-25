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
        Schema::create('teacher_sub_sections', function (Blueprint $table) {
            $table->id();
           $table->unsignedBigInteger('allotment_id');
    $table->unsignedBigInteger('section_id');
    $table->timestamps();

    $table->foreign('allotment_id')->references('id')->on('teacher_allotments')->onDelete('cascade');
    $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_sub_sections');
    }
};

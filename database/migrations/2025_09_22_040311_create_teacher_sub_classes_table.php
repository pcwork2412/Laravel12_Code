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
        Schema::create('teacher_sub_classes', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('allotment_id'); // teacher_allotments id
            $table->unsignedBigInteger('class_id');     // sub class id
            $table->timestamps();

            // Foreign keys (optional but recommended)
            $table->foreign('allotment_id')->references('id')->on('teacher_allotments')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('std_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_sub_classes');
    }
};

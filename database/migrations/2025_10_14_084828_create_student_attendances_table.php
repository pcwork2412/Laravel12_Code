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
    Schema::create('student_attendances', function (Blueprint $table) {
        $table->id();

        // Foreign keys
        $table->unsignedBigInteger('student_id');
        $table->unsignedBigInteger('class_id');
        $table->unsignedBigInteger('section_id');

        // Data fields
        $table->date('date');
        $table->enum('status', ['Present', 'Absent', 'Leave'])->default('Present');
        $table->string('reason')->nullable();

        $table->timestamps();

        // Foreign Key Constraints
        $table->foreign('student_id')->references('id')->on('cruds')->onDelete('cascade');
        $table->foreign('class_id')->references('id')->on('std_classes')->onDelete('cascade');
        $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};

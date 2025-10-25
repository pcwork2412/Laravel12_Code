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
        Schema::create('teacher_attendances', function (Blueprint $table) {
            $table->id();
        // Foreign keys
        $table->unsignedBigInteger('teacher_id');

        // Data fields
        $table->date('date');
        $table->enum('status', ['Present', 'Absent', 'Leave','Holiday'])->default('Present');
        $table->string('reason')->nullable();

        $table->timestamps();

        // Foreign Key Constraints
        $table->foreign('teacher_id')->references('id')->on('teacher_cruds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_attendances');
    }
};

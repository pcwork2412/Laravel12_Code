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
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id');
            $table->string('student_uid', 50)->unique();
            $table->string('promoted_class_name')->nullable();
            $table->string('section')->nullable();
            $table->string('student_name')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('mother_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('father_occupation_income')->nullable();
            $table->string('mother_mobile')->nullable();
            $table->string('father_mobile')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('local_guardian')->nullable();
            $table->string('state_belong')->nullable();
            $table->string('whatsapp_mobile')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('email_id')->nullable();
            $table->string('aadhaar_number', 12)->nullable();
            $table->enum('ration_card_type', ['APL', 'BPL', 'Antyodaya'])->nullable();
            $table->enum('physically_handicapped', ['Yes', 'No'])->nullable(); // ENUM type for Yes/No
            $table->string('image')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name_branch')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();

            $table->foreign('class_id')->references('id')->on('std_classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');


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

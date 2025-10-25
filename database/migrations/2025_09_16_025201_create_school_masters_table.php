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
        Schema::create('school_masters', function (Blueprint $table) {
            $table->id();
            $table->string('school_logo')->nullable();
            $table->string('school_name')->nullable();
            $table->string('school_tagline')->nullable();
            $table->string('school_address')->nullable();
            $table->string('school_session')->nullable();
            $table->string('school_principal_sign')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_masters');
    }
};

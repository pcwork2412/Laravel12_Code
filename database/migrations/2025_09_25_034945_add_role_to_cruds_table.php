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
        Schema::table('cruds', function (Blueprint $table) {
            $table->string('role')->default('student')->after('id'); // after id, optional
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruds', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
};

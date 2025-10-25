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
        Schema::table('teacher_allotments', function (Blueprint $table) {
             $table->foreign('teacher_id')
                  ->references('id')->on('teacher_cruds')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_allotments', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
        });
    }
};

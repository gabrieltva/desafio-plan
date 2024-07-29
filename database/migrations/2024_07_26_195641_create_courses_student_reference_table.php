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
        Schema::create('courses_student_reference', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('course_id')->references('id')->on('courses')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_student_reference');
    }
};

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
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId(column: 'exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId(column: 'student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId(column: 'question')->constrained('questions')->onDelete('cascade');
            $table->string('answer');
            $table->boolean('correct');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
};

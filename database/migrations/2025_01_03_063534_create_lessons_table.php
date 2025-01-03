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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('description');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('file')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};

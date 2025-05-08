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
        Schema::create('grades', function (Blueprint $table) {
            $table->uuid('grade_id')->primary();
            $table->foreignUuid('student_id')->constrained('students','student_id');
            $table->foreignUuid('course_id')->constrained('courses','course_id');
            $table->float('grade_score');
            $table->string('grade_symbol');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};

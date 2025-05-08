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
        Schema::create('attendences', function (Blueprint $table) {
            $table->uuid('attendence_id')->primary();
            $table->foreignUuid('student_id')->constrained('students','student_id');
            $table->foreignUuid('session_id')->constrained('session','session_id');
            $table->enum('attendence_status',['hadir','izin','sakit','alfa']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendences');
    }
};

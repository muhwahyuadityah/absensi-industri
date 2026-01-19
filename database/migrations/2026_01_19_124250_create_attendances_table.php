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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained('attendance_sessions')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['HADIR', 'SAKIT', 'IZIN', 'CUTI', 'ALFA']);
            $table->text('notes')->nullable(); // catatan jika sakit/izin/cuti
            $table->timestamps();

            // Pastikan 1 karyawan tidak bisa diabsen 2x dalam 1 session
            $table->unique(['attendance_session_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
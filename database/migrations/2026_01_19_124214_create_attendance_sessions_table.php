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
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('area_id')->nullable()->constrained('areas')->onDelete('set null');
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            $table->string('photo_path'); // path file foto grup
            $table->decimal('latitude', 10, 8)->nullable(); // GPS koordinat
            $table->decimal('longitude', 11, 8)->nullable();
            $table->date('session_date'); // tanggal absensi (tanggal check-in)
            $table->time('session_time'); // waktu foto diambil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};
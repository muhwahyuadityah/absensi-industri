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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('employee_type', ['AREA_BASED', 'NON_AREA'])->after('email')->nullable();
            $table->unsignedBigInteger('area_id')->after('employee_type')->nullable();
            $table->unsignedBigInteger('shift_id')->after('area_id')->nullable();
            $table->string('department')->after('shift_id')->nullable();
            $table->string('position')->after('department')->nullable();
            $table->string('employee_number')->after('position')->unique()->nullable();
            $table->boolean('is_active')->after('employee_number')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'employee_type',
                'area_id',
                'shift_id',
                'department',
                'position',
                'employee_number',
                'is_active',
            ]);
        });
    }
};
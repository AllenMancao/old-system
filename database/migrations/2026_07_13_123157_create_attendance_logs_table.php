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
        Schema::create('attendance_logs', function (Blueprint $table) {

            $table->id();
            $table->foreignId('intern_profile_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->date('date');
            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->decimal('rendered_hours', 6, 2)
                ->default(0);
            $table->enum('status', [
                'Present',
                'Late',
                'Absent',
                'Incomplete',
            ])->default('Incomplete');
            $table->text('activity_description')->nullable();
            $table->timestamps();
            $table->unique(['intern_profile_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};

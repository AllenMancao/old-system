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
        Schema::create('intern_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('course_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('hte_unit_id')
                ->nullable()
                ->constrained('hte_units')
                ->nullOnDelete();
            $table->string('student_number')->unique();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedSmallInteger('required_hours');
            $table->decimal('current_hours',6,2)
                ->default(0);
            $table->enum('status',[
                'Pending',
                'Active',
                'Completed'
            ])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_profiles');
    }
};

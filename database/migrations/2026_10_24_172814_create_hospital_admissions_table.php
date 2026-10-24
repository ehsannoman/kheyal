<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_admissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('hospital_name');
            $table->string('illness_name')->nullable();

            $table->date('admission_date');
            $table->date('discharge_date')->nullable();

            $table->string('doctor_name')->nullable();

            $table->text('treatment_details')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_admissions');
    }
};
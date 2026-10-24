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
        Schema::create('illness_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->string('illness_name');
            $table->date('diagnosed_at')->nullable();
            $table->enum('status', ['ongoing', 'recovered'])
                ->default('ongoing');

            $table->string('doctor_name')->nullable();
            $table->string('hospital_name')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('illness_histories');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('prescription_id')->nullable()->constrained('prescriptions')->onDelete('set null');
            $table->string('name');
            $table->string('dosage')->nullable();
            $table->string('form')->nullable();
            $table->string('frequency')->nullable();
            $table->integer('duration_days')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->integer('remaining_quantity')->nullable();
            $table->integer('low_stock_threshold')->default(5);
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
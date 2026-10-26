
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_conditions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('condition_name', 100);
            $table->date('diagnosed_at')->nullable();

            $table->enum('status', [
                'active',
                'controlled',
                'resolved',
            ])->default('active');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                ['patient_id', 'condition_name'],
                'patient_condition_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_conditions');
    }
};

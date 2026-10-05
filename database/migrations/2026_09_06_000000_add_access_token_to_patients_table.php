<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // access_token = patient-er PWA link/QR-er gopon chabi. Login lagbe na -
            // ei token soho URL-i patient-ke identify kore.
            $table->string('access_token', 64)->nullable()->unique()->after('id');

            // Quick-dial button-e ei number-e call/WhatsApp jabe (patient view theke)
            $table->string('caregiver_phone', 20)->nullable()->after('relation');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['access_token', 'caregiver_phone']);
        });
    }
};

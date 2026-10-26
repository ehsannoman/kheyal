<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/patients', function () {
    return view('patients.index');
});

Route::get('/patients/{id}', function ($id) {
    return view('patients.show', ['patientId' => (int) $id]);
});

Route::get('/appointments', function () {
    return view('appointments.index');
});

Route::get('/prescriptions/scan', function () {
    return view('prescriptions.scan');
});

Route::get('/prescriptions', function () {
    return view('prescriptions.index');
});

Route::get('/health-history', function () {
    return view('health-history.index');
});

Route::get('/vitals-health', function () {
    return view('vitals-health.index');
});

Route::get('/checkins', function () {
    return view('checkins.index');
});

Route::get('/medication-management', function () {
    return view('medication-management.index');
});

Route::get('/sos-alerts', function () {
    return view('sos-alerts.index');
});

// Patient PWA - token diye access, caregiver login lage na
Route::get('/patient/{token}/home', function ($token) {
    return view('patient-app.home', ['token' => $token]);
});

Route::get('/patient/{token}/manifest.json', function ($token) {
    return response()->json([
        'name' => 'খেয়াল',
        'short_name' => 'খেয়াল',
        'description' => 'আপনার ওষুধ, চেক-ইন ও SOS সহায়ক',
        'start_url' => "/patient/{$token}/home",
        'scope' => "/patient/{$token}/",
        'display' => 'standalone',
        'background_color' => '#f7f5ef',
        'theme_color' => '#f7f5ef',
        'orientation' => 'portrait-primary',
        'icons' => [
            [
                'src' => '/icons/icon-192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any maskable',
            ],
            [
                'src' => '/icons/icon-512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable',
            ],
        ],
    ])->header('Content-Type', 'application/manifest+json');
});

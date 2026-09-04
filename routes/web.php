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
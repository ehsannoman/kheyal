<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoseLogController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('patients', PatientController::class);

    Route::get('/patients/{patientId}/medications', [MedicationController::class, 'index']);
    Route::post('/patients/{patientId}/medications', [MedicationController::class, 'store']);
    Route::apiResource('medications', MedicationController::class)->except(['index', 'store']);

    Route::post('/patients/{patientId}/dose-logs/generate', [DoseLogController::class, 'generate']);
    Route::get('/patients/{patientId}/dose-logs/today', [DoseLogController::class, 'today']);
    Route::get('/patients/{patientId}/adherence', [DoseLogController::class, 'adherence']);
    Route::put('/dose-logs/{id}/mark', [DoseLogController::class, 'mark']);

    Route::get('/appointments', [AppointmentController::class, 'indexAll']);
    Route::get('/patients/{patientId}/appointments', [AppointmentController::class, 'index']);
    Route::get('/patients/{patientId}/appointments/upcoming', [AppointmentController::class, 'upcoming']);
    Route::post('/patients/{patientId}/appointments', [AppointmentController::class, 'store']);
    Route::apiResource('appointments', AppointmentController::class)->except(['index', 'store']);
});
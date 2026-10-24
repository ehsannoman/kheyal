<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\SosAlertController;
use App\Http\Controllers\Api\CheckinController;
use App\Http\Controllers\Api\PushSubscriptionController;
use App\Http\Controllers\Api\PatientPortalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoseLogController;
use App\Http\Controllers\Api\PatientPushSubscriptionController;
use App\Http\Controllers\Api\IllnessHistoryController;
use App\Http\Controllers\Api\HospitalAdmissionController;
use App\Http\Controllers\Api\PrescriptionHistoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Patient PWA - login lage na, gopon token diye identify hoy (caregiver ekbar QR/link diye setup kore dey)
Route::prefix('patient/{token}')->group(function () {
    Route::get('/me', [PatientPortalController::class, 'me']);
    Route::get('/dose-logs/today', [PatientPortalController::class, 'todayDoses']);
    Route::put('/dose-logs/{id}/mark', [PatientPortalController::class, 'markDose']);
    Route::get('/checkins/latest', [PatientPortalController::class, 'latestCheckin']);
    Route::post('/checkins', [PatientPortalController::class, 'storeCheckin']);
    Route::post('/sos', [PatientPortalController::class, 'triggerSos']);
    Route::get('/appointments/upcoming', [PatientPortalController::class, 'upcomingAppointments']);
    Route::get('/push/vapid-public-key', [PatientPushSubscriptionController::class, 'vapidPublicKey']);
    Route::post('/push/subscribe', [PatientPushSubscriptionController::class, 'subscribe']);
    Route::post('/push/unsubscribe', [PatientPushSubscriptionController::class, 'unsubscribe']);
    Route::post('/appointments/{id}/acknowledge',[PatientPortalController::class, 'acknowledgeAppointment']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('patients', PatientController::class);
    Route::post('/patients/{id}/access-link', [PatientController::class, 'generateAccessLink']);
    Route::post('/patients/{id}/access-link/reset', [PatientController::class, 'resetAccessLink']);

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

    Route::get('/sos-alerts', [SosAlertController::class, 'indexAll']);
    Route::get('/patients/{patientId}/sos-alerts', [SosAlertController::class, 'index']);
    Route::post('/patients/{patientId}/sos', [SosAlertController::class, 'store']);
    Route::put('/sos-alerts/{id}/resolve', [SosAlertController::class, 'resolve']);

    Route::get('/checkins/latest', [CheckinController::class, 'latestAll']);
    Route::get('/patients/{patientId}/checkins', [CheckinController::class, 'index']);
    Route::get('/patients/{patientId}/checkins/latest', [CheckinController::class, 'latest']);
    Route::post('/patients/{patientId}/checkins', [CheckinController::class, 'store']);

    Route::get('/push/vapid-public-key', [PushSubscriptionController::class, 'vapidPublicKey']);
    Route::post('/push/subscribe', [PushSubscriptionController::class, 'subscribe']);
    Route::post('/push/unsubscribe', [PushSubscriptionController::class, 'unsubscribe']);

    Route::get('/patients/{patientId}/illness-histories',[IllnessHistoryController::class, 'index']);
    Route::post('/patients/{patientId}/illness-histories',[IllnessHistoryController::class, 'store']);
    Route::get('/patients/{patientId}/illness-histories/{id}',[IllnessHistoryController::class, 'show']);
    Route::put('/patients/{patientId}/illness-histories/{id}',[IllnessHistoryController::class, 'update']);
    Route::delete('/patients/{patientId}/illness-histories/{id}',[IllnessHistoryController::class, 'destroy']);

    Route::get('/patients/{patientId}/hospital-admissions',[HospitalAdmissionController::class, 'index']);
    Route::post('/patients/{patientId}/hospital-admissions',[HospitalAdmissionController::class, 'store']);
    Route::get('/patients/{patientId}/hospital-admissions/{id}',[HospitalAdmissionController::class, 'show']);
    Route::put('/patients/{patientId}/hospital-admissions/{id}',[HospitalAdmissionController::class, 'update']);
    Route::delete('/patients/{patientId}/hospital-admissions/{id}',[HospitalAdmissionController::class, 'destroy']);

    Route::get('/patients/{patientId}/prescription-history',[PrescriptionHistoryController::class, 'index']);
    Route::get('/patients/{patientId}/prescription-history/{id}',[PrescriptionHistoryController::class, 'show']);
});
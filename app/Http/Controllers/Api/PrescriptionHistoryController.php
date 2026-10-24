<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PrescriptionHistoryController extends Controller
{
private function findPatient(Request $request, int $patientId): ?Patient
{
return $request->user()
->patients()
->find($patientId);
}

// GET: List prescription history
public function index(Request $request, int $patientId)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$prescriptions = $patient->prescriptions()
->with('medications')
->orderByDesc('prescription_date')
->orderByDesc('id')
->get();

return response()->json([
'patient_id' => $patient->id,
'prescriptions' => $prescriptions,
]);
}

// GET: Show a single prescription
public function show(Request $request, int $patientId, int $id)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$prescription = $patient->prescriptions()
->with('medications')
->find($id);

if (!$prescription) {
return response()->json([
'message' => 'Prescription not found',
], 404);
}

return response()->json([
'prescription' => $prescription,
]);
}
}
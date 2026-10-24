<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IllnessHistoryController extends Controller
{
private function findPatient(Request $request, int $patientId): ?Patient
{
return $request->user()
->patients()
->find($patientId);
}

// GET /api/patients/{patientId}/illness-histories
public function index(Request $request, int $patientId)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$histories = $patient->illnessHistories()
->orderByDesc('diagnosed_at')
->orderByDesc('id')
->get();

return response()->json([
'patient_id' => $patient->id,
'illness_histories' => $histories,
]);
}

// POST /api/patients/{patientId}/illness-histories
public function store(Request $request, int $patientId)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$validated = $request->validate([
'illness_name' => ['required', 'string', 'max:255'],
'diagnosed_at' => ['nullable', 'date', 'before_or_equal:today'],
'follow_up_date' => ['nullable', 'date'],
'status' => ['sometimes', Rule::in(['ongoing', 'recovered'])],
'doctor_name' => ['nullable', 'string', 'max:255'],
'hospital_name' => ['nullable', 'string', 'max:255'],
'notes' => ['nullable', 'string'],
]);

$history = $patient->illnessHistories()->create($validated);

return response()->json([
'message' => 'Illness history created successfully',
'illness_history' => $history,
], 201);
}

// GET /api/illness-histories/{id}
public function show(Request $request, int $patientId, int $id)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$history = $patient->illnessHistories()->find($id);

if (!$history) {
return response()->json([
'message' => 'Illness history not found',
], 404);
}

return response()->json([
'illness_history' => $history,
]);
}

// PUT /api/patients/{patientId}/illness-histories/{id}
public function update(Request $request, int $patientId, int $id)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$history = $patient->illnessHistories()->find($id);

if (!$history) {
return response()->json([
'message' => 'Illness history not found',
], 404);
}

$validated = $request->validate([
'illness_name' => ['sometimes', 'required', 'string', 'max:255'],
'diagnosed_at' => ['sometimes', 'nullable', 'date', 'before_or_equal:today'],
'follow_up_date' => ['sometimes', 'nullable', 'date'],
'status' => ['sometimes', Rule::in(['ongoing', 'recovered'])],
'doctor_name' => ['sometimes', 'nullable', 'string', 'max:255'],
'hospital_name' => ['sometimes', 'nullable', 'string', 'max:255'],
'notes' => ['sometimes', 'nullable', 'string'],
]);

$history->update($validated);

return response()->json([
'message' => 'Illness history updated successfully',
'illness_history' => $history->fresh(),
]);
}

// DELETE /api/patients/{patientId}/illness-histories/{id}
public function destroy(Request $request, int $patientId, int $id)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$history = $patient->illnessHistories()->find($id);

if (!$history) {
return response()->json([
'message' => 'Illness history not found',
], 404);
}

$history->delete();

return response()->json([
'message' => 'Illness history deleted successfully',
]);
}
}
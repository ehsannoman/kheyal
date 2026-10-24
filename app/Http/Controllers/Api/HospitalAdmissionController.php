<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class HospitalAdmissionController extends Controller
{
private function findPatient(Request $request, int $patientId): ?Patient
{
return $request->user()
->patients()
->find($patientId);
}

// GET: List all admissions
public function index(Request $request, int $patientId)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$admissions = $patient->hospitalAdmissions()
->orderByDesc('admission_date')
->orderByDesc('id')
->get();

return response()->json([
'patient_id' => $patient->id,
'hospital_admissions' => $admissions,
]);
}

// POST: Create an admission
public function store(Request $request, int $patientId)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$validated = $request->validate([
'hospital_name' => ['required', 'string', 'max:255'],
'illness_name' => ['nullable', 'string', 'max:255'],
'admission_date' => ['required', 'date', 'before_or_equal:today'],
'discharge_date' => [
'nullable',
'date',
'after_or_equal:admission_date',
'before_or_equal:today',
],
'doctor_name' => ['nullable', 'string', 'max:255'],
'treatment_details' => ['nullable', 'string'],
'notes' => ['nullable', 'string'],
]);

$admission = $patient->hospitalAdmissions()->create($validated);

return response()->json([
'message' => 'Hospital admission created successfully',
'hospital_admission' => $admission,
], 201);
}

// GET: Show one admission
public function show(Request $request, int $patientId, int $id)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$admission = $patient->hospitalAdmissions()->find($id);

if (!$admission) {
return response()->json([
'message' => 'Hospital admission not found',
], 404);
}

return response()->json([
'hospital_admission' => $admission,
]);
}

// PUT: Update an admission
public function update(Request $request, int $patientId, int $id)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$admission = $patient->hospitalAdmissions()->find($id);

if (!$admission) {
return response()->json([
'message' => 'Hospital admission not found',
], 404);
}

$validated = $request->validate([
'hospital_name' => ['sometimes', 'required', 'string', 'max:255'],
'illness_name' => ['sometimes', 'nullable', 'string', 'max:255'],
'admission_date' => [
'sometimes',
'required',
'date',
'before_or_equal:today',
],
'discharge_date' => [
'sometimes',
'nullable',
'date',
'after_or_equal:admission_date',
'before_or_equal:today',
],
'doctor_name' => ['sometimes', 'nullable', 'string', 'max:255'],
'treatment_details' => ['sometimes', 'nullable', 'string'],
'notes' => ['sometimes', 'nullable', 'string'],
]);

$admission->update($validated);

return response()->json([
'message' => 'Hospital admission updated successfully',
'hospital_admission' => $admission->fresh(),
]);
}

// DELETE: Delete an admission
public function destroy(Request $request, int $patientId, int $id)
{
$patient = $this->findPatient($request, $patientId);

if (!$patient) {
return response()->json([
'message' => 'Patient not found',
], 404);
}

$admission = $patient->hospitalAdmissions()->find($id);

if (!$admission) {
return response()->json([
'message' => 'Hospital admission not found',
], 404);
}

$admission->delete();

return response()->json([
'message' => 'Hospital admission deleted successfully',
]);
}
}
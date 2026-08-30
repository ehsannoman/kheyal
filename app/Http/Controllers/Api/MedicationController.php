<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicationController extends Controller
{
    // GET /api/patients/{patientId}/medications - patient-er shob medicine dekhায়
    public function index(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $medications = $patient->medications()->with('schedules')->get();

        return response()->json($medications);
    }

    // POST /api/patients/{patientId}/medications - notun medicine + schedule add kore
    public function store(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:100',
            'form' => 'nullable|string|max:50',
            'frequency' => 'nullable|string|max:100',
            'duration_days' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'total_quantity' => 'nullable|integer|min:0',
            'instructions' => 'nullable|string',
            'schedule_times' => 'required|array|min:1',
            'schedule_times.*' => 'date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        $medication = $patient->medications()->create([
            'name' => $data['name'],
            'dosage' => $data['dosage'] ?? null,
            'form' => $data['form'] ?? null,
            'frequency' => $data['frequency'] ?? null,
            'duration_days' => $data['duration_days'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'total_quantity' => $data['total_quantity'] ?? null,
            'remaining_quantity' => $data['total_quantity'] ?? null,
            'instructions' => $data['instructions'] ?? null,
        ]);

        foreach ($data['schedule_times'] as $time) {
            $medication->schedules()->create([
                'scheduled_time' => $time,
            ]);
        }

        return response()->json([
            'message' => 'Medication added successfully',
            'medication' => $medication->load('schedules'),
        ], 201);
    }

    // GET /api/medications/{id} - ekটা specific medicine-er detail
    public function show(Request $request, $id)
    {
        $medication = Medication::with(['schedules', 'patient'])->find($id);

        if (!$medication || $medication->patient->caregiver_id !== $request->user()->id) {
            return response()->json(['message' => 'Medication not found'], 404);
        }

        return response()->json($medication);
    }

    // PUT /api/medications/{id} - medicine update kore
    public function update(Request $request, $id)
    {
        $medication = Medication::with('patient')->find($id);

        if (!$medication || $medication->patient->caregiver_id !== $request->user()->id) {
            return response()->json(['message' => 'Medication not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'dosage' => 'nullable|string|max:100',
            'form' => 'nullable|string|max:50',
            'frequency' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $medication->update($validator->validated());

        return response()->json([
            'message' => 'Medication updated successfully',
            'medication' => $medication,
        ]);
    }

    // DELETE /api/medications/{id} - medicine delete kore
    public function destroy(Request $request, $id)
    {
        $medication = Medication::with('patient')->find($id);

        if (!$medication || $medication->patient->caregiver_id !== $request->user()->id) {
            return response()->json(['message' => 'Medication not found'], 404);
        }

        $medication->delete();

        return response()->json(['message' => 'Medication deleted successfully']);
    }
}
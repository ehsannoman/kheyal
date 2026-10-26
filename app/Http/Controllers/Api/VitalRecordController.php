<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\VitalRecord;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VitalRecordController extends Controller
{
    public function index(Request $request, int $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $records = $patient->vitalRecords()
            ->orderByDesc('measured_at')
            ->paginate(20);

        return response()->json($records);
    }

    public function store(Request $request, int $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $validated = $request->validate([
            'systolic' => ['nullable', 'integer', 'between:1,300'],
            'diastolic' => ['nullable', 'integer', 'between:1,200'],
            'heart_rate' => ['nullable', 'integer', 'between:1,300'],
            'temperature' => ['nullable', 'numeric', 'between:25,45'],
            'spo2' => ['nullable', 'numeric', 'between:0,100'],
            'blood_glucose' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'weight' => ['nullable', 'numeric', 'between:0,500'],
            'measured_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $measurementFields = [
            'systolic',
            'diastolic',
            'heart_rate',
            'temperature',
            'spo2',
            'blood_glucose',
            'weight',
        ];

        if (!collect($measurementFields)->contains(
            fn ($field) => isset($validated[$field])
        )) {
            throw ValidationException::withMessages([
                'measurements' => [
                    'At least one vital measurement is required.',
                ],
            ]);
        }

        if (
            isset($validated['systolic'], $validated['diastolic'])
            && $validated['systolic'] <= $validated['diastolic']
        ) {
            throw ValidationException::withMessages([
                'systolic' => [
                    'Systolic pressure must be greater than diastolic pressure.',
                ],
            ]);
        }

        $record = $patient->vitalRecords()->create([
            ...$validated,
            'recorded_by' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Vital record created successfully.',
            'vital_record' => $record,
        ], 201);
    }

    public function show(Request $request, int $patientId, int $id)
    {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $record = $patient->vitalRecords()
            ->findOrFail($id);

        return response()->json([
            'vital_record' => $record,
        ]);
    }

    public function update(Request $request, int $patientId, int $id)
    {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $record = $patient->vitalRecords()
            ->findOrFail($id);

        $validated = $request->validate([
            'systolic' => ['sometimes', 'nullable', 'integer', 'between:1,300'],
            'diastolic' => ['sometimes', 'nullable', 'integer', 'between:1,200'],
            'heart_rate' => ['sometimes', 'nullable', 'integer', 'between:1,300'],
            'temperature' => ['sometimes', 'nullable', 'numeric', 'between:25,45'],
            'spo2' => ['sometimes', 'nullable', 'numeric', 'between:0,100'],
            'blood_glucose' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'weight' => ['sometimes', 'nullable', 'numeric', 'between:0,500'],
            'measured_at' => ['sometimes', 'required', 'date'],
            'notes' => ['sometimes', 'nullable', 'string', 'max:5000'],
        ]);

        $measurementFields = [
            'systolic',
            'diastolic',
            'heart_rate',
            'temperature',
            'spo2',
            'blood_glucose',
            'weight',
        ];

        $merged = array_merge(
            $record->only($measurementFields),
            $validated
        );

        $hasMeasurement = collect($measurementFields)->contains(
            fn ($field) => isset($merged[$field])
        );

        if (!$hasMeasurement) {
            throw ValidationException::withMessages([
                'measurements' => [
                    'At least one vital measurement is required.',
                ],
            ]);
        }

        if (
            isset($merged['systolic'], $merged['diastolic'])
            && $merged['systolic'] <= $merged['diastolic']
        ) {
            throw ValidationException::withMessages([
                'systolic' => [
                    'Systolic pressure must be greater than diastolic pressure.',
                ],
            ]);
        }

        $record->update($validated);

        return response()->json([
            'message' => 'Vital record updated successfully.',
            'vital_record' => $record->fresh(),
        ]);
    }

    public function destroy(Request $request, int $patientId, int $id)
    {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $record = $patient->vitalRecords()
            ->findOrFail($id);

        $record->delete();

        return response()->json([
            'message' => 'Vital record deleted successfully.',
        ]);
    }
}

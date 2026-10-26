<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientCondition;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PatientConditionController extends Controller
{
    private const COMMON_CONDITIONS = [
        'Diabetes',
        'Asthma',
        'Arthritis',
        'Hypertension',
        'Heart Disease',
        'Kidney Disease',
        'Thyroid Disorder',
        'Other',
    ];

    public function options()
    {
        return response()->json([
            'conditions' => self::COMMON_CONDITIONS,
        ]);
    }

    public function index(Request $request, int $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        return response()->json([
            'conditions' => $patient->conditions()
                ->orderBy('condition_name')
                ->get(),
        ]);
    }

    public function store(Request $request, int $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $validated = $request->validate([
            'condition_name' => [
                'required',
                'string',
                'max:100',
                Rule::in(self::COMMON_CONDITIONS),
            ],
            'custom_condition_name' => [
                'required_if:condition_name,Other',
                'nullable',
                'string',
                'max:100',
            ],
            'diagnosed_at' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],
            'status' => [
                'sometimes',
                Rule::in(['active', 'controlled', 'resolved']),
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $conditionName = $validated['condition_name'] === 'Other'
            ? trim($validated['custom_condition_name'] ?? '')
            : $validated['condition_name'];

        if ($conditionName === '') {
            throw ValidationException::withMessages([
                'custom_condition_name' => [
                    'Please enter the condition name.',
                ],
            ]);
        }

        $existing = $patient->conditions()
            ->whereRaw('LOWER(condition_name) = ?', [
                mb_strtolower($conditionName),
            ])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'This condition already exists for this patient.',
                'condition' => $existing,
            ], 409);
        }

        $condition = $patient->conditions()->create([
            'condition_name' => $conditionName,
            'diagnosed_at' => $validated['diagnosed_at'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Patient condition created successfully.',
            'condition' => $condition,
        ], 201);
    }

    public function update(
        Request $request,
        int $patientId,
        int $id
    ) {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $condition = $patient->conditions()
            ->findOrFail($id);

        $validated = $request->validate([
            'condition_name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::in(self::COMMON_CONDITIONS),
            ],
            'custom_condition_name' => [
                'required_if:condition_name,Other',
                'nullable',
                'string',
                'max:100',
            ],
            'diagnosed_at' => [
                'sometimes',
                'nullable',
                'date',
                'before_or_equal:today',
            ],
            'status' => [
                'sometimes',
                Rule::in(['active', 'controlled', 'resolved']),
            ],
            'notes' => ['sometimes', 'nullable', 'string', 'max:5000'],
        ]);

        if (isset($validated['condition_name'])) {
            $conditionName = $validated['condition_name'] === 'Other'
                ? trim($validated['custom_condition_name'] ?? '')
                : $validated['condition_name'];

            if ($conditionName === '') {
                throw ValidationException::withMessages([
                    'custom_condition_name' => [
                        'Please enter the condition name.',
                    ],
                ]);
            }

            $validated['condition_name'] = $conditionName;
        } elseif (isset($validated['custom_condition_name'])) {
            throw ValidationException::withMessages([
                'condition_name' => [
                    'Send condition_name as Other when using a custom name.',
                ],
            ]);
        }

        unset($validated['custom_condition_name']);

        if (isset($validated['condition_name'])) {
            $duplicate = $patient->conditions()
                ->whereRaw('LOWER(condition_name) = ?', [
                    mb_strtolower($validated['condition_name']),
                ])
                ->where('id', '!=', $condition->id)
                ->exists();

            if ($duplicate) {
                return response()->json([
                    'message' => 'This condition already exists for this patient.',
                ], 409);
            }
        }

        $condition->update($validated);

        return response()->json([
            'message' => 'Patient condition updated successfully.',
            'condition' => $condition->fresh(),
        ]);
    }

    public function destroy(
        Request $request,
        int $patientId,
        int $id
    ) {
        $patient = $request->user()
            ->patients()
            ->findOrFail($patientId);

        $condition = $patient->conditions()
            ->findOrFail($id);

        $condition->delete();

        return response()->json([
            'message' => 'Patient condition deleted successfully.',
        ]);
    }
}

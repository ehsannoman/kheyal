<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    // GET /api/patients - caregiver-er nijer shob patient list dekhায়
    public function index(Request $request)
    {
        $patients = $request->user()->patients()->get();

        return response()->json($patients);
    }

    // POST /api/patients - notun patient add kore
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|string|max:50',
            'relation' => 'nullable|string|max:100',
            'caregiver_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient = $request->user()->patients()->create($validator->validated());

        return response()->json([
            'message' => 'Patient added successfully',
            'patient' => $patient,
        ], 201);
    }

    // GET /api/patients/{id} - ekটা specific patient-er detail dekhায়
    public function show(Request $request, $id)
    {
        $patient = $request->user()->patients()->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    // PUT /api/patients/{id} - patient-er info update kore
    public function update(Request $request, $id)
    {
        $patient = $request->user()->patients()->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'nullable|string|max:50',
            'relation' => 'nullable|string|max:100',
            'caregiver_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient->update($validator->validated());

        return response()->json([
            'message' => 'Patient updated successfully',
            'patient' => $patient,
        ]);
    }

    // DELETE /api/patients/{id} - patient delete kore
    public function destroy(Request $request, $id)
    {
        $patient = $request->user()->patients()->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully']);
    }

    // POST /api/patients/{id}/access-link - patient-er PWA link toiri/dekhায় (na thakle toiri kore)
    public function generateAccessLink(Request $request, $id)
    {
        $patient = $request->user()->patients()->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $token = $patient->ensureAccessToken();

        return response()->json([
            'url' => url("/patient/{$token}/home"),
        ]);
    }

    // POST /api/patients/{id}/access-link/reset - purono link kaj korbe na emon kore notun link banay
    public function resetAccessLink(Request $request, $id)
    {
        $patient = $request->user()->patients()->find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $patient->update(['access_token' => \Illuminate\Support\Str::random(48)]);

        return response()->json([
            'url' => url("/patient/{$patient->access_token}/home"),
        ]);
    }
}
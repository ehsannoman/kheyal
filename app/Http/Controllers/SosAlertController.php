<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SosAlert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SosAlertController extends Controller
{
    // GET /api/sos-alerts - caregiver-er shob patient-er SOS alert eksathe dekhায় (notun ta age)
    public function indexAll(Request $request)
    {
        $patientIds = $request->user()->patients()->pluck('id');

        $alerts = SosAlert::whereIn('patient_id', $patientIds)
            ->with('patient')
            ->orderByDesc('triggered_at')
            ->get();

        return response()->json($alerts);
    }

    // GET /api/patients/{patientId}/sos-alerts - ekta patient-er shob SOS alert dekhায়
    public function index(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $alerts = $patient->sosAlerts()->orderByDesc('triggered_at')->get();

        return response()->json($alerts);
    }

    // POST /api/patients/{patientId}/sos - patient SOS trigger kore, shob caregiver-ke alert jay
    public function store(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $alert = $patient->sosAlerts()->create([
            'triggered_at' => Carbon::now(),
            'resolved' => false,
        ]);

        // TODO: push/email notification shob caregiver-ke pathano (future work - notification system)

        return response()->json([
            'message' => 'SOS alert triggered',
            'sos_alert' => $alert,
        ], 201);
    }

    // PUT /api/sos-alerts/{id}/resolve - caregiver SOS alert resolved mark kore
    public function resolve(Request $request, $id)
    {
        $alert = SosAlert::with('patient')->find($id);

        if (!$alert || $alert->patient->caregiver_id !== $request->user()->id) {
            return response()->json(['message' => 'SOS alert not found'], 404);
        }

        $alert->update([
            'resolved' => true,
            'resolved_at' => Carbon::now(),
            'resolved_by' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'SOS alert resolved',
            'sos_alert' => $alert,
        ]);
    }
}
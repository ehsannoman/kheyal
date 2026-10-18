<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckinController extends Controller
{
    // GET /api/checkins/latest - caregiver-er shob patient-er sobcheye recent check-in eksathe dekhায়
    public function latestAll(Request $request)
    {
        $todayStart = Carbon::now('Asia/Dhaka')
            ->startOfDay()
            ->utc();

        $tomorrowStart = Carbon::now('Asia/Dhaka')
            ->startOfDay()
            ->addDay()
            ->utc();

        $patients = $request->user()
            ->patients()
            ->with([
                'checkins' => function ($query) use (
                    $todayStart,
                    $tomorrowStart
                ) {
                    $query->where('checked_in_at', '>=', $todayStart)
                        ->where('checked_in_at', '<', $tomorrowStart)
                        ->orderByDesc('checked_in_at')
                        ->limit(1);
                }
            ])
            ->get();

        return response()->json(
            $patients->map(function ($patient) {
                return [
                    'patient_id' => $patient->id,
                    'patient_name' => $patient->name,
                    'latest_checkin' => $patient->checkins->first(),
                ];
            })
        );
    }

    // GET /api/patients/{patientId}/checkins - ekta patient-er shob check-in history dekhায়
    public function index(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $checkins = $patient->checkins()->orderByDesc('checked_in_at')->get();

        return response()->json($checkins);
    }

    // GET /api/patients/{patientId}/checkins/latest - patient-er sobcheye recent check-in dekhায়
    public function latest(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $checkin = $patient->checkins()->orderByDesc('checked_in_at')->first();

        return response()->json($checkin);
    }

    // POST /api/patients/{patientId}/checkins - patient dainik wellness status submit kore
    public function store(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:fine,not_well,need_help',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $checkin = $patient->checkins()->create([
            'status' => $request->status,
            'checked_in_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Check-in recorded',
            'checkin' => $checkin,
        ], 201);
    }
}
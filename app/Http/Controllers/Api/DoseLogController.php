<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoseLog;
use App\Models\Medication;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoseLogController extends Controller
{
    // POST /api/patients/{patientId}/dose-logs/generate - ajker date-er jonno dose_logs generate kore
    public function generate(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $today = Carbon::now('Asia/Dhaka')->startOfDay();
        $generatedCount = 0;

        $medications = $patient->medications()->where('is_active', true)->with('schedules')->get();

        foreach ($medications as $medication) {
            foreach ($medication->schedules as $schedule) {
                if (!$schedule->is_active) {
                    continue;
                }

                $exists = DoseLog::where('schedule_id', $schedule->id)
                    ->where('scheduled_date', $today->toDateString())
                    ->exists();

                if (!$exists) {
                    DoseLog::create([
                        'schedule_id' => $schedule->id,
                        'medication_id' => $medication->id,
                        'patient_id' => $patient->id,
                        'scheduled_date' => $today,
                        'scheduled_time' => $schedule->scheduled_time,
                        'status' => 'pending',
                    ]);
                    $generatedCount++;
                }
            }
        }

        return response()->json([
            'message' => "Generated {$generatedCount} dose log(s) for today",
            'date' => $today->toDateString(),
        ]);
    }

    // GET /api/patients/{patientId}/dose-logs/today - ajker shob dose dekhায়
    public function today(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $doseLogs = DoseLog::where('patient_id', $patient->id)
            ->where('scheduled_date', Carbon::now('Asia/Dhaka')->toDateString())
            ->with('medication')
            ->orderBy('scheduled_time')
            ->get();

        return response()->json($doseLogs);
    }

    // PUT /api/dose-logs/{id}/mark - dose ta taken/missed/skipped mark kore
    public function mark(Request $request, $id)
    {
        $doseLog = DoseLog::with('patient')->find($id);

        if (!$doseLog || $doseLog->patient->caregiver_id !== $request->user()->id) {
            return response()->json(['message' => 'Dose log not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:taken,missed,skipped',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $doseLog->update([
            'status' => $request->status,
            'taken_at' => $request->status === 'taken' ? now() : null,
            'marked_by_type' => 'caregiver',
            'marked_by_id' => $request->user()->id,
        ]);

        if ($request->status === 'taken') {
            $medication = $doseLog->medication;
            if ($medication->remaining_quantity !== null && $medication->remaining_quantity > 0) {
                $medication->decrement('remaining_quantity');
            }
        }

        return response()->json([
            'message' => 'Dose marked successfully',
            'dose_log' => $doseLog,
        ]);
    }

    // GET /api/patients/{patientId}/adherence - adherence percentage calculate kore
    public function adherence(Request $request, $patientId)
    {
        $patient = $request->user()->patients()->find($patientId);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $totalDoses = DoseLog::where('patient_id', $patient->id)->count();
        $takenDoses = DoseLog::where('patient_id', $patient->id)->where('status', 'taken')->count();
        $missedDoses = DoseLog::where('patient_id', $patient->id)->where('status', 'missed')->count();

        $adherencePercentage = $totalDoses > 0 ? round(($takenDoses / $totalDoses) * 100, 1) : 0;

        return response()->json([
            'total_doses' => $totalDoses,
            'taken' => $takenDoses,
            'missed' => $missedDoses,
            'adherence_percentage' => $adherencePercentage,
        ]);
    }
}
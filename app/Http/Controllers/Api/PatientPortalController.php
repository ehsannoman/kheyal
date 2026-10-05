<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\DoseLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientPortalController extends Controller
{
    // Shob method-e token diye patient khuje ber kora hoy - login lage na,
    // token-i identity. Vul/purono token dile 404 dey.
    protected function resolvePatient(string $token)
    {
        return \App\Models\Patient::where('access_token', $token)->first();
    }

    // GET /api/patient/{token}/me - patient-er nijer nam-poricoy dekhায়
    public function me($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json(['message' => 'Invalid link'], 404);
        }

        return response()->json([
            'id' => $patient->id,
            'name' => $patient->name,
            'caregiver_phone' => $patient->caregiver_phone,
        ]);
    }

    // GET /api/patient/{token}/dose-logs/today - ajker oshudher list dekhায় (age generate kore neয়)
    public function todayDoses($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json(['message' => 'Invalid link'], 404);
        }

        $today = Carbon::today();

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
                }
            }
        }

        $doseLogs = DoseLog::where('patient_id', $patient->id)
            ->where('scheduled_date', $today->toDateString())
            ->with('medication')
            ->orderBy('scheduled_time')
            ->get();

        return response()->json($doseLogs);
    }

    // PUT /api/patient/{token}/dose-logs/{id}/mark - patient nije "niyechi/nei ni" bole mark kore
    public function markDose(Request $request, $token, $id)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json(['message' => 'Invalid link'], 404);
        }

        $doseLog = DoseLog::where('patient_id', $patient->id)->find($id);

        if (!$doseLog) {
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
            'marked_by_type' => 'patient',
            'marked_by_id' => $patient->id,
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

    // GET /api/patient/{token}/checkins/latest - ajker check-in dewa hoyeche kina dekhায়
    public function latestCheckin($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json(['message' => 'Invalid link'], 404);
        }

        $checkin = $patient->checkins()->orderByDesc('checked_in_at')->first();

        return response()->json($checkin);
    }

    // POST /api/patient/{token}/checkins - patient nije dainik wellness status dey
    public function storeCheckin(Request $request, $token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json(['message' => 'Invalid link'], 404);
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

    // POST /api/patient/{token}/sos - patient SOS button chaple shob caregiver-ke alert jay
    public function triggerSos($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json(['message' => 'Invalid link'], 404);
        }

        $alert = $patient->sosAlerts()->create([
            'triggered_at' => Carbon::now(),
            'resolved' => false,
        ]);

        // TODO: caregiver-ke immediate push notification pathano (future work)

        return response()->json([
            'message' => 'SOS alert triggered',
            'sos_alert' => $alert,
        ], 201);
    }

    // GET /api/patient/{token}/appointments/upcoming - পরবর্তী অ্যাপয়েন্টমেন্ট দেখায়
    public function upcomingAppointments($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json(['message' => 'Invalid link'], 404);
        }

        $appointments = $patient->appointments()
            ->where('appointment_date', '>=', Carbon::now())
            ->orderBy('appointment_date')
            ->limit(3)
            ->get();

        return response()->json($appointments);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\DoseLog;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SosAlertNotification;
use App\Notifications\CheckinNotification;

class PatientPortalController extends Controller
{
    // Token diye patient identify kora hoy.
    protected function resolvePatient(string $token)
    {
        return Patient::where('access_token', $token)->first();
    }

    // GET /api/patient/{token}/me
    public function me($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        return response()->json([
            'id' => $patient->id,
            'name' => $patient->name,
            'caregiver_phone' => $patient->caregiver_phone,
        ]);
    }

    // GET /api/patient/{token}/dose-logs/today
    public function todayDoses($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        $today = Carbon::today();

        $medications = $patient->medications()
            ->where('is_active', true)
            ->with('schedules')
            ->get();

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

    // PUT /api/patient/{token}/dose-logs/{id}/mark
    public function markDose(Request $request, $token, $id)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        $doseLog = DoseLog::where('patient_id', $patient->id)
            ->find($id);

        if (!$doseLog) {
            return response()->json([
                'message' => 'Dose log not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:taken,missed,skipped',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent changing an already completed dose
        |--------------------------------------------------------------------------
        */

        if (in_array($doseLog->status, ['taken', 'missed', 'skipped'])) {
            return response()->json([
                'message' => 'This dose has already been completed.',
                'dose_log' => $doseLog,
            ], 422);
        }

        $doseLog->status = $request->status;
        $doseLog->taken_at = $request->status === 'taken'
            ? now()
            : null;

        $doseLog->marked_by_type = 'patient';
        $doseLog->marked_by_id = $patient->id;

        $doseLog->save();

        /*
        |--------------------------------------------------------------------------
        | Decrease medicine quantity only when taken
        |--------------------------------------------------------------------------
        */

        if ($request->status === 'taken') {

            $medication = $doseLog->medication;

            if (
                $medication &&
                $medication->remaining_quantity !== null &&
                $medication->remaining_quantity > 0
            ) {
                $medication->decrement('remaining_quantity');
            }
        }

        return response()->json([
            'message' => 'Dose marked successfully',
            'dose_log' => $doseLog->fresh('medication'),
        ]);
    }

    // GET /api/patient/{token}/checkins/latest
    public function latestCheckin($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        $today = Carbon::today();

        $checkin = $patient->checkins()
            ->whereDate('checked_in_at', $today)
            ->orderByDesc('checked_in_at')
            ->first();

        return response()->json($checkin);
    }

    // POST /api/patient/{token}/checkins
    public function storeCheckin(Request $request, $token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:fine,not_well,need_help',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | One daily check-in
        |--------------------------------------------------------------------------
        */

        $todayCheckin = $patient->checkins()
            ->whereDate('checked_in_at', Carbon::today())
            ->first();

        if ($todayCheckin) {
            return response()->json([
                'message' => 'Today check-in has already been submitted.',
                'checkin' => $todayCheckin,
            ], 422);
        }

        $checkin = $patient->checkins()->create([
            'status' => $request->status,
            'checked_in_at' => Carbon::now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify caregiver
        |--------------------------------------------------------------------------
        */

        $caregiver = $patient->caregiver;

        if ($caregiver) {
            $caregiver->notify(
                new CheckinNotification($checkin, $patient)
            );
        }

        return response()->json([
            'message' => 'Check-in recorded',
            'checkin' => $checkin,
        ], 201);
    }

    // POST /api/patient/{token}/sos
    public function triggerSos($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent accidental duplicate SOS
        |--------------------------------------------------------------------------
        */

        $recentAlert = $patient->sosAlerts()
            ->where('resolved', false)
            ->where(
                'triggered_at',
                '>=',
                Carbon::now()->subMinutes(2)
            )
            ->latest('triggered_at')
            ->first();

        if ($recentAlert) {
            return response()->json([
                'message' => 'An SOS alert is already active.',
                'sos_alert' => $recentAlert,
            ], 200);
        }

        $alert = $patient->sosAlerts()->create([
            'triggered_at' => Carbon::now(),
            'resolved' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Immediate caregiver push notification
        |--------------------------------------------------------------------------
        */

        $caregiver = $patient->caregiver;

        if ($caregiver) {
            $caregiver->notify(
                new SosAlertNotification($alert, $patient)
            );
        }

        return response()->json([
            'message' => 'SOS alert triggered',
            'sos_alert' => $alert,
        ], 201);
    }

    // GET /api/patient/{token}/appointments/upcoming
    public function upcomingAppointments($token)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        $appointments = $patient->appointments()
            ->where('appointment_date', '>=', Carbon::now())
            ->whereNull('reminders_stopped_at')
            ->orderBy('appointment_date')
            ->limit(3)
            ->get();

        return response()->json($appointments);
    }

    // POST /api/patient/{token}/appointments/{id}/acknowledge
    public function acknowledgeAppointment($token, $id)
    {
        $patient = $this->resolvePatient($token);

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid link'
            ], 404);
        }

        $appointment = $patient->appointments()
            ->where('id', $id)
            ->first();

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found'
            ], 404);
        }

        $appointment->reminders_stopped_at = now();
        $appointment->reminded = true;
        $appointment->save();

        return response()->json([
            'message' => 'Appointment reminder stopped',
            'appointment' => $appointment,
        ]);
    }
}
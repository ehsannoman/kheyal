<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Timezone helper
    |--------------------------------------------------------------------------
    |
    | Caregiver form থেকে appointment_date আসে Bangladesh local time হিসেবে।
    | যেমন:
    |
    | 2026-10-08T20:00
    |
    | এটাকে Asia/Dhaka ধরে parse করে UTC-তে convert করে database-এ save করব।
    |
    */

    private function parseAppointmentDate(string $value): Carbon
    {
        return Carbon::createFromFormat(
            'Y-m-d\TH:i',
            $value,
            'Asia/Dhaka'
        )->utc();
    }


    // GET /api/appointments
    // caregiver-er shob patient-er shob appointment
    public function indexAll(Request $request)
    {
        $patientIds = $request->user()
            ->patients()
            ->pluck('id');

        $appointments = Appointment::whereIn('patient_id', $patientIds)
            ->with('patient')
            ->orderBy('appointment_date')
            ->get();

        return response()->json($appointments);
    }


    // GET /api/patients/{patientId}/appointments
    // patient-er shob appointment
    public function index(Request $request, $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->find($patientId);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found'
            ], 404);
        }

        $appointments = $patient->appointments()
            ->orderBy('appointment_date')
            ->get();

        return response()->json($appointments);
    }


    // GET /api/patients/{patientId}/appointments/upcoming
    // shudhu future appointment
    public function upcoming(Request $request, $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->find($patientId);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found'
            ], 404);
        }

        $appointments = $patient->appointments()
            ->where(
                'appointment_date',
                '>=',
                Carbon::now('UTC')
            )
            ->orderBy('appointment_date')
            ->get();

        return response()->json($appointments);
    }


    // POST /api/patients/{patientId}/appointments
    // notun appointment add kore
    public function store(Request $request, $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->find($patientId);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'prescription_id' => 'nullable|integer|exists:prescriptions,id',
            'doctor_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | Form থেকে:
        |
        | 2026-10-08T20:00
        |
        | এটাকে Asia/Dhaka ধরে UTC-তে convert করছি।
        |
        | Dhaka 20:00
        |       ↓
        | UTC 14:00
        |
        | Database-এ UTC 14:00 থাকবে।
        |
        */

        try {

            $appointmentDate = $this->parseAppointmentDate(
                $data['appointment_date']
            );

        } catch (\Throwable $e) {

            return response()->json([
                'message' => 'Invalid appointment date/time.'
            ], 422);
        }


        $appointment = $patient->appointments()->create([

            'prescription_id' =>
                $data['prescription_id'] ?? null,

            'doctor_name' =>
                $data['doctor_name'] ?? null,

            'location' =>
                $data['location'] ?? null,

            'appointment_date' =>
                $appointmentDate,

            'notes' =>
                $data['notes'] ?? null,

        ]);


        return response()->json([
            'message' => 'Appointment added successfully',
            'appointment' => $appointment,
        ], 201);
    }


    // GET /api/appointments/{id}
    // specific appointment-er detail
    public function show(Request $request, $id)
    {
        $appointment = Appointment::with('patient')
            ->find($id);

        if (
            !$appointment ||
            $appointment->patient->caregiver_id !==
            $request->user()->id
        ) {
            return response()->json([
                'message' => 'Appointment not found'
            ], 404);
        }

        return response()->json($appointment);
    }


    // PUT /api/appointments/{id}
    // appointment update kore
    public function update(Request $request, $id)
    {
        $appointment = Appointment::with('patient')
            ->find($id);

        if (
            !$appointment ||
            $appointment->patient->caregiver_id !==
            $request->user()->id
        ) {
            return response()->json([
                'message' => 'Appointment not found'
            ], 404);
        }


        $validator = Validator::make($request->all(), [
            'doctor_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'appointment_date' => 'sometimes|required|date',
            'notes' => 'nullable|string',
        ]);


        if ($validator->fails()) {

            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }


        $data = $validator->validated();


        /*
        |--------------------------------------------------------------------------
        | Appointment date update
        |--------------------------------------------------------------------------
        */

        if (isset($data['appointment_date'])) {

            try {

                $data['appointment_date'] =
                    $this->parseAppointmentDate(
                        $data['appointment_date']
                    );

            } catch (\Throwable $e) {

                return response()->json([
                    'message' => 'Invalid appointment date/time.'
                ], 422);
            }
        }


        $appointment->update($data);


        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => $appointment,
        ]);
    }


    // DELETE /api/appointments/{id}
    // appointment delete kore
    public function destroy(Request $request, $id)
    {
        $appointment = Appointment::with('patient')
            ->find($id);

        if (
            !$appointment ||
            $appointment->patient->caregiver_id !==
            $request->user()->id
        ) {
            return response()->json([
                'message' => 'Appointment not found'
            ], 404);
        }


        $appointment->delete();


        return response()->json([
            'message' => 'Appointment deleted successfully'
        ]);
    }
}
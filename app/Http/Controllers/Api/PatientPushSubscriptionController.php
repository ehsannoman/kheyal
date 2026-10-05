<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientPushSubscriptionController extends Controller
{
    /**
     * GET /api/patient/{token}/push/vapid-public-key
     */
    public function vapidPublicKey(string $token)
    {
        $patient = Patient::where('access_token', $token)->first();

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid patient token.'
            ], 404);
        }

        return response()->json([
            'public_key' => config('webpush.vapid.public_key'),
        ]);
    }

    /**
     * POST /api/patient/{token}/push/subscribe
     */
    public function subscribe(Request $request, string $token)
    {
        $patient = Patient::where('access_token', $token)->first();

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid patient token.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|string',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $patient->updatePushSubscription(
            $request->endpoint,
            $request->input('keys.p256dh'),
            $request->input('keys.auth')
        );

        return response()->json([
            'message' => 'Patient subscribed to push notifications.'
        ]);
    }

    /**
     * POST /api/patient/{token}/push/unsubscribe
     */
    public function unsubscribe(Request $request, string $token)
    {
        $patient = Patient::where('access_token', $token)->first();

        if (!$patient) {
            return response()->json([
                'message' => 'Invalid patient token.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $patient->deletePushSubscription(
            $request->endpoint
        );

        return response()->json([
            'message' => 'Patient unsubscribed from push notifications.'
        ]);
    }
}
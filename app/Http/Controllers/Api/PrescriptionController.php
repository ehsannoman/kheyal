<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PrescriptionController extends Controller
{
    /**
     * POST /api/patients/{patientId}/prescriptions
     * Caregiver-er patient-er prescription image upload kore.
     */
    public function store(Request $request, int $patientId)
    {
        $patient = $request->user()
            ->patients()
            ->find($patientId);

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found',
            ], 404);
        }

        $validated = $request->validate([
            'image' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ]);

        $path = $validated['image']->store(
            'prescriptions',
            'local'
        );

        try {
            $prescription = Prescription::create([
                'patient_id' => $patient->id,
                'uploaded_by' => $request->user()->id,
                'image_path' => $path,
                'status' => 'pending',
            ]);
        } catch (\Throwable $e) {
            Storage::disk('local')->delete($path);

            throw $e;
        }

        return response()->json([
            'message' => 'Prescription image uploaded successfully',
            'prescription' => $prescription,
        ], 201);
    }

    
    /**
     * GET /api/prescriptions
     * Caregiver-er shob patient-er prescription list.
     */
    public function index(Request $request)
    {
        $prescriptions = Prescription::query()
            ->whereHas('patient', function ($query) use ($request) {
                $query->where(
                    'caregiver_id',
                    $request->user()->id
                );
            })
            ->with('patient:id,name')
            ->latest()
            ->get();

        return response()->json([
            'prescriptions' => $prescriptions,
        ]);
    }

    
    /**
     * GET /api/prescriptions/{prescriptionId}
     * নির্দিষ্ট প্রেসক্রিপশনের বিস্তারিত দেখায়।
     */
    public function show(Request $request, int $prescriptionId)
    {
        $prescription = Prescription::query()
            ->whereHas('patient', function ($query) use ($request) {
                $query->where(
                    'caregiver_id',
                    $request->user()->id
                );
            })
            ->with('patient:id,name')
            ->find($prescriptionId);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found',
            ], 404);
        }

        return response()->json([
            'prescription' => $prescription,
        ]);
    }

    /**
 * GET /api/prescriptions/{prescriptionId}/image
 * অনুমোদিত caregiver-কে prescription image দেখায়।
 */
    public function showImage(Request $request, int $prescriptionId)
    {
        $prescription = Prescription::query()
            ->whereHas('patient', function ($query) use ($request) {
                $query->where(
                    'caregiver_id',
                    $request->user()->id
                );
            })
            ->find($prescriptionId);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found',
            ], 404);
        }

        $imagePath = $prescription->image_path;
        $disk = Storage::disk('local');

        if (!$imagePath || !$disk->exists($imagePath)) {
            return response()->json([
                'message' => 'Prescription image not found',
            ], 404);
        }

        return response()->file(
            $disk->path($imagePath),
            [
                'Cache-Control' => 'private, no-store',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    /**
     * PUT /api/prescriptions/{prescriptionId}
     * প্রেসক্রিপশনের তথ্য আপডেট করে।
     */
    public function update(Request $request, int $prescriptionId)
    {
        $prescription = Prescription::query()
            ->whereHas('patient', function ($query) use ($request) {
                $query->where(
                    'caregiver_id',
                    $request->user()->id
                );
            })
            ->find($prescriptionId);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found',
            ], 404);
        }

        $validated = $request->validate([
            'doctor_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'prescription_date' => ['sometimes', 'nullable', 'date'],
            'follow_up_date' => ['sometimes', 'nullable', 'date'],
            'notes' => ['sometimes', 'nullable', 'string', 'max:5000'],
        ]);

        $prescription->fill($validated);
        $prescription->save();

        return response()->json([
            'message' => 'Prescription updated successfully',
            'prescription' => $prescription->load('patient:id,name'),
        ]);
    }

    
/**
 * DELETE /api/prescriptions/{prescriptionId}
 * প্রেসক্রিপশন ও তার সংরক্ষিত ছবি মুছে দেয়।
 */
    public function destroy(Request $request, int $prescriptionId)
    {
        $prescription = Prescription::query()
            ->whereHas('patient', function ($query) use ($request) {
                $query->where(
                    'caregiver_id',
                    $request->user()->id
                );
            })
            ->find($prescriptionId);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found',
            ], 404);
        }

        $imagePath = $prescription->image_path;

        // প্রথমে database record মুছে ফেলি
        $prescription->delete();

        // তারপর সংরক্ষিত ছবি মুছে ফেলি
        if ($imagePath) {
            Storage::disk('local')->delete($imagePath);
        }

        return response()->json([
            'message' => 'Prescription deleted successfully',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Services\OcrSpaceService;
use App\Services\GroqPrescriptionService;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    /**
     * POST /api/patients/{patientId}/prescriptions
     * Caregiver-er patient-er prescription image upload kore.
     */
    
    public function store(
        Request $request,
        int $patientId,
        OcrSpaceService $ocrService,
        GroqPrescriptionService $groqService
    ) {
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
                'status' => 'processing',
            ]);
        } catch (\Throwable $e) {
            Storage::disk('local')->delete($path);
            throw $e;
        }

        try {
            // Step 1: Extract text from prescription image
            $ocrResult = $ocrService->extractText($path);

            $rawOcrText = $ocrResult['text'];

            // Save original OCR text
            $prescription->raw_ocr_text = $rawOcrText;
            $prescription->save();

            // Step 2: Refine OCR text using Groq
            $parsedData = $groqService->refine($rawOcrText);

            // Step 3: Save AI extracted data
            $prescription->ai_parsed_data = $parsedData;

            // Caregiver has not confirmed the extracted information yet
            $prescription->status = 'pending';

            $prescription->save();

            return response()->json([
                'message' => 'Prescription uploaded and processed successfully. Caregiver confirmation required.',
                'prescription' => $prescription->load('patient:id,name'),
            ], 201);

        } catch (\Throwable $e) {

            Log::error('Prescription processing failed', [
                'prescription_id' => $prescription->id,
                'error' => $e->getMessage(),
            ]);

            $prescription->status = 'failed';
            $prescription->save();

            return response()->json([
                'message' => 'Prescription image uploaded, but OCR or AI processing failed.',
                'prescription' => $prescription->load('patient:id,name'),
            ], 201);
        }
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
            'ai_parsed_data' => ['sometimes', 'array'],
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
 * POST /api/prescriptions/{prescriptionId}/confirm
 * Caregiver prescription review kore approve kore.
 */
    public function confirm(Request $request, int $prescriptionId)
    {
        $prescription = Prescription::query()
            ->whereHas('patient', function ($query) use ($request) {
                $query->where('caregiver_id', $request->user()->id);
            })
            ->find($prescriptionId);

        if (!$prescription) {
            return response()->json([
                'message' => 'Prescription not found',
            ], 404);
        }

        if ($prescription->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending prescriptions can be confirmed',
            ], 422);
        }

        // Lock record to prevent simultaneous duplicate approval
        $confirmed = \Illuminate\Support\Facades\DB::transaction(function () use ($prescriptionId) {

            $prescription = Prescription::whereKey($prescriptionId)
                ->lockForUpdate()
                ->first();

            if (!$prescription || $prescription->status !== 'pending') {
                return false;
            }

            $prescription->update([
                'status' => 'confirmed',
            ]);

            return true;
        });

        if (!$confirmed) {
            return response()->json([
                'message' => 'Prescription has already been confirmed',
            ], 422);
        }

        return response()->json([
            'message' => 'Prescription confirmed successfully',
            'prescription' => $prescription->fresh()->load('patient:id,name'),
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

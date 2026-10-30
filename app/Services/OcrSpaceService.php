<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class OcrSpaceService
{
    public function extractText(string $imagePath): array
    {
        $apiKey = config('services.ocr_space.api_key');

        if (empty($apiKey)) {
            throw new RuntimeException(
                'OCR.space API key is not configured.'
            );
        }

        $disk = Storage::disk('local');

        if (!$disk->exists($imagePath)) {
            throw new RuntimeException(
                'Prescription image not found.'
            );
        }

        $response = Http::timeout(60)
            ->withHeaders([
                'apikey' => $apiKey,
            ])
            ->attach(
                'file',
                $disk->get($imagePath),
                basename($imagePath)
            )
            ->post(config('services.ocr_space.url'), [
                'OCREngine' => '3',
                'isOverlayRequired' => 'false',
            ]);

        $response->throw();

        $data = $response->json();

        if (!is_array($data)) {
            throw new RuntimeException(
                'Invalid OCR.space response.'
            );
        }

        if (($data['IsErroredOnProcessing'] ?? false) === true) {
            $message = $data['ErrorMessage']
                ?? 'OCR processing failed.';

            throw new RuntimeException(
                is_array($message)
                    ? implode('; ', $message)
                    : (string) $message
            );
        }

        $results = $data['ParsedResults'] ?? [];
        $text = '';

        foreach ($results as $result) {
            $text .= ($result['ParsedText'] ?? '') . "\n";
        }

        $text = trim($text);

        if ($text === '') {
            throw new RuntimeException(
                'OCR did not extract any text.'
            );
        }

        return [
            'text' => $text,
            'engine' => 3,
        ];
    }
}

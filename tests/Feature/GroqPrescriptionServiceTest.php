<?php

namespace Tests\Feature;

use App\Services\GroqPrescriptionService;
use Tests\TestCase;

class GroqPrescriptionServiceTest extends TestCase
{
    public function test_groq_can_refine_prescription_ocr_text(): void
    {
        $ocrText = <<<'TEXT'
        Dr. Rahman
        Hospital: City Hospital
        Prescription Date: 2026-10-20

        Napa 500 mg
        1 tablet twice daily for 5 days

        Follow up after 1 month
        TEXT;

        $result = app(GroqPrescriptionService::class)
            ->refine($ocrText, '2026-10-20');

        // Verify the top-level structure.
        $this->assertIsArray($result);
        $this->assertArrayHasKey('doctor_name', $result);
        $this->assertArrayHasKey('hospital', $result);
        $this->assertArrayHasKey('prescription_date', $result);
        $this->assertArrayHasKey('medicines', $result);
        $this->assertArrayHasKey('follow_up', $result);
        $this->assertArrayHasKey('overall_uncertainties', $result);

        // Verify medicine structure.
        $this->assertNotEmpty($result['medicines']);
        
foreach ($result['medicines'] as $medicine) {
    $this->assertIsArray($medicine);

    $this->assertArrayHasKey('name', $medicine);
    $this->assertArrayHasKey('dosage', $medicine);
    $this->assertArrayHasKey('frequency', $medicine);
}

$this->assertNotEmpty(
    $result['follow_up']['instruction'] ?? null,
    'The stated follow-up instruction should be extracted.'
);


        $medicine = $result['medicines'][0];

        $this->assertIsArray($medicine);
        $this->assertArrayHasKey('name', $medicine);
        $this->assertArrayHasKey('strength', $medicine);
        $this->assertArrayHasKey('dosage', $medicine);
        $this->assertArrayHasKey('frequency', $medicine);
        $this->assertArrayHasKey('duration', $medicine);

        // Print only the parsed result, not API credentials.
        fwrite(
            STDERR,
            "\nParsed prescription result:\n"
            . json_encode(
                $result,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
            . "\n"
        );
    }
    
public function test_groq_interprets_three_part_dosage_notation(): void
{
    $ocrText = <<<'TEXT'
    Dr. Rahman
    Prescription Date: 2026-10-20

    Tab. Napa 500 mg
    1+0+1 for 5 days

    Tab. Medicine B 20 mg
    0+0+3 for 7 days
    TEXT;

    $result = app(GroqPrescriptionService::class)
        ->refine($ocrText, '2026-10-20');

    $this->assertCount(2, $result['medicines']);

    $this->assertSame(
        '1+0+1',
        $result['medicines'][0]['dosage']
    );

    $this->assertSame(
        '0+0+3',
        $result['medicines'][1]['dosage']
    );

    $this->assertEmpty(
        $result['medicines'][0]['uncertainty_notes']
    );

    $this->assertEmpty(
        $result['medicines'][1]['uncertainty_notes']
    );
}

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyResponseRequest;
use App\Models\ClientType;
use App\Models\Office;
use App\Models\ServiceOption;
use App\Models\SurveyResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SurveyController extends Controller
{
    /**
     * Show the Citizen's Charter Client Satisfaction Survey form.
     */
    public function create(): View
    {
        $ageGroups = [
            '19 or below',
            '20-34',
            '35-49',
            '50-64',
            '65 and above',
        ];

        $regions = [
            'NCR - National Capital Region',
            'CAR - Cordillera Administrative Region',
            'Region I - Ilocos Region',
            'Region II - Cagayan Valley',
            'Region III - Central Luzon',
            'Region IV-A - CALABARZON',
            'MIMAROPA Region',
            'Region V - Bicol Region',
            'Region VI - Western Visayas',
            'Region VII - Central Visayas',
            'Region VIII - Eastern Visayas',
            'Region IX - Zamboanga Peninsula',
            'Region X - Northern Mindanao',
            'Region XI - Davao Region',
            'Region XII - SOCCSKSARGEN',
            'Region XIII - Caraga',
            'BARMM - Bangsamoro Autonomous Region',
            'Outside the Philippines / Overseas',
        ];

        return view('survey.form', [
            'clientTypes' => ClientType::query()->orderBy('name')->pluck('description', 'name'),
            'ageGroups' => $ageGroups,
            'offices' => Office::query()->orderBy('name')->pluck('name'),
            'services' => ServiceOption::query()->orderBy('name')->pluck('name'),
            'regions' => $regions,
            'cc1Options' => SurveyResponse::CC1_DESCRIPTIONS,
            'cc2Options' => SurveyResponse::CC2_DESCRIPTIONS,
            'cc3Options' => SurveyResponse::CC3_DESCRIPTIONS,
            'sqdQuestions' => SurveyResponse::SQD_QUESTIONS,
            'ratingLabels' => SurveyResponse::RATING_LABELS,
        ]);
    }

    /**
     * Store a newly submitted survey response.
     */
    public function store(StoreSurveyResponseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['reference_no'] = SurveyResponse::generateReferenceNo();
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = substr((string) $request->userAgent(), 0, 500);

        // If CC1 is option 4 (unaware of CC), enforce CC2 and CC3 as 5/4 (N/A)
        if ($validated['cc1'] === 4) {
            $validated['cc2'] = 5; // N/A
            $validated['cc3'] = 4; // N/A
        }

        $response = SurveyResponse::create($validated);

        return redirect()->route('survey.success', ['reference' => $response->reference_no])
            ->with('status', 'Your survey has been submitted successfully! Thank you for helping us improve our public services.');
    }

    /**
     * Display survey submission confirmation.
     */
    public function success(string $reference): View
    {
        $response = SurveyResponse::where('reference_no', $reference)->firstOrFail();

        return view('survey.success', [
            'response' => $response,
            'cc1Descriptions' => SurveyResponse::CC1_DESCRIPTIONS,
            'cc2Descriptions' => SurveyResponse::CC2_DESCRIPTIONS,
            'cc3Descriptions' => SurveyResponse::CC3_DESCRIPTIONS,
            'sqdQuestions' => SurveyResponse::SQD_QUESTIONS,
            'ratingLabels' => SurveyResponse::RATING_LABELS,
        ]);
    }

    /**
     * Show clean printable / PDF view of a submitted survey response.
     */
    public function print(string $reference): View
    {
        $response = SurveyResponse::where('reference_no', $reference)->firstOrFail();

        return view('survey.print', [
            'response' => $response,
            'cc1Descriptions' => SurveyResponse::CC1_DESCRIPTIONS,
            'cc2Descriptions' => SurveyResponse::CC2_DESCRIPTIONS,
            'cc3Descriptions' => SurveyResponse::CC3_DESCRIPTIONS,
            'sqdQuestions' => SurveyResponse::SQD_QUESTIONS,
            'ratingLabels' => SurveyResponse::RATING_LABELS,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\SurveyResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SurveyAdminController extends Controller
{
    /**
     * Apply the shared admin filter set to a query builder.
     */
    private function applyFilters(Request $request, Builder $query): Builder
    {
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhere('service_availed', 'like', "%{$search}%")
                    ->orWhere('office_transacted', 'like', "%{$search}%");
            });
        }

        if ($clientType = $request->query('client_type')) {
            $query->where('client_type', $clientType);
        }

        if ($office = $request->query('office')) {
            $query->where('office_transacted', $office);
        }

        if ($dateFrom = $request->query('date_from')) {
            $query->whereDate('transaction_date', '>=', $dateFrom);
        }

        if ($dateTo = $request->query('date_to')) {
            $query->whereDate('transaction_date', '<=', $dateTo);
        }

        return $query;
    }

    /**
     * Display a summary dashboard for administrators.
     */
    public function dashboard(): View
    {
        $totalResponses = SurveyResponse::count();
        $awareCount = SurveyResponse::whereIn('cc1', [1, 2, 3])->count();
        $awarenessRate = $totalResponses > 0 ? round(($awareCount / $totalResponses) * 100, 1) : 0.0;

        $overallSatisfiedCount = SurveyResponse::whereIn('sqd0', [4, 5])->count();
        $overallSatisfactionRate = $totalResponses > 0 ? round(($overallSatisfiedCount / $totalResponses) * 100, 1) : 0.0;
        $averageOverallScore = round((float) SurveyResponse::whereNotNull('sqd0')->avg('sqd0'), 2);

        $recentResponses = SurveyResponse::latest('transaction_date')->latest('id')->take(5)->get();

        $clientTypeBreakdown = $this->clientTypeBreakdown(SurveyResponse::query());

        return view('admin.dashboard', [
            'totalResponses' => $totalResponses,
            'awarenessRate' => $awarenessRate,
            'overallSatisfactionRate' => $overallSatisfactionRate,
            'averageOverallScore' => $averageOverallScore,
            'awareCount' => $awareCount,
            'recentResponses' => $recentResponses,
            'clientTypeBreakdown' => $clientTypeBreakdown,
        ]);
    }

    /**
     * Display survey dashboard with metrics and response listings.
     */
    public function index(Request $request): View
    {
        $query = $this->applyFilters($request, SurveyResponse::query());

        $filteredQuery = clone $query;

        $totalResponses = $filteredQuery->count();
        $awareCount = $filteredQuery->clone()->whereIn('cc1', [1, 2, 3])->count();
        $awarenessRate = $totalResponses > 0 ? round(($awareCount / $totalResponses) * 100, 1) : 0.0;

        $overallSatisfiedCount = $filteredQuery->clone()->whereIn('sqd0', [4, 5])->count();
        $overallSatisfactionRate = $totalResponses > 0 ? round(($overallSatisfiedCount / $totalResponses) * 100, 1) : 0.0;
        $averageOverallScore = round((float) $filteredQuery->clone()->whereNotNull('sqd0')->avg('sqd0'), 2);

        // Calculate averages for all SQD dimensions
        $dimensionStats = [];
        foreach (SurveyResponse::SQD_QUESTIONS as $key => $meta) {
            $dimensionQuery = $filteredQuery->clone();
            $avg = $dimensionQuery->whereNotNull($key)->avg($key);
            $satisfiedCount = $dimensionQuery->clone()->whereIn($key, [4, 5])->count();
            $totalDimensionRated = $dimensionQuery->clone()->whereNotNull($key)->count();
            $percentage = $totalDimensionRated > 0 ? round(($satisfiedCount / $totalDimensionRated) * 100, 1) : 0;

            $dimensionStats[$key] = [
                'title' => $meta['title'],
                'statement' => $meta['statement'],
                'avg' => round((float) $avg, 2),
                'percent_satisfied' => $percentage,
            ];
        }

        // Breakdown by client type
        $clientTypeBreakdown = $this->clientTypeBreakdown($filteredQuery);

        // Paginated list
        $responses = $query->latest('transaction_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $officesList = SurveyResponse::distinct()->whereNotNull('office_transacted')->pluck('office_transacted');
        $clientTypes = ClientType::query()
            ->orderBy('name')
            ->pluck('name')
            ->merge(SurveyResponse::query()->distinct()->whereNotNull('client_type')->pluck('client_type'))
            ->unique()
            ->sort()
            ->values();

        return view('admin.index', [
            'responses' => $responses,
            'totalResponses' => $totalResponses,
            'awarenessRate' => $awarenessRate,
            'awareCount' => $awareCount,
            'overallSatisfactionRate' => $overallSatisfactionRate,
            'averageOverallScore' => $averageOverallScore,
            'dimensionStats' => $dimensionStats,
            'clientTypeBreakdown' => $clientTypeBreakdown,
            'officesList' => $officesList,
            'clientTypes' => $clientTypes,
            'filters' => $request->only(['search', 'client_type', 'office', 'date_from', 'date_to']),
            'cc1Descriptions' => SurveyResponse::CC1_DESCRIPTIONS,
            'cc2Descriptions' => SurveyResponse::CC2_DESCRIPTIONS,
            'cc3Descriptions' => SurveyResponse::CC3_DESCRIPTIONS,
            'sqdQuestions' => SurveyResponse::SQD_QUESTIONS,
            'ratingLabels' => SurveyResponse::RATING_LABELS,
        ]);
    }

    /**
     * Show full details of a specific survey response.
     */
    public function show(SurveyResponse $response): View
    {
        return view('admin.show', [
            'response' => $response,
            'cc1Descriptions' => SurveyResponse::CC1_DESCRIPTIONS,
            'cc2Descriptions' => SurveyResponse::CC2_DESCRIPTIONS,
            'cc3Descriptions' => SurveyResponse::CC3_DESCRIPTIONS,
            'sqdQuestions' => SurveyResponse::SQD_QUESTIONS,
            'ratingLabels' => SurveyResponse::RATING_LABELS,
        ]);
    }

    /**
     * Delete a survey response.
     */
    public function destroy(SurveyResponse $response): RedirectResponse
    {
        $response->delete();

        return redirect()->route('admin.dashboard')
            ->with('status', 'Survey response deleted successfully.');
    }

    /**
     * Export survey responses to CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $fileName = 'Citizen_Charter_Surveys_'.now()->format('Y-m-d_His').'.csv';

        $query = $this->applyFilters($request, SurveyResponse::query());

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($query) {
            $output = fopen('php://output', 'w');

            // Add UTF-8 BOM for Microsoft Excel compatibility
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header Row
            fputcsv($output, [
                'Reference No',
                'Date of Transaction',
                'Client Type',
                'Sex',
                'Age Group',
                'Region',
                'Office Transacted',
                'Service Availed',
                'CC1 Awareness',
                'CC2 Visibility',
                'CC3 Helpfulness',
                'SQD0 (Overall)',
                'SQD1 (Responsiveness)',
                'SQD2 (Reliability)',
                'SQD3 (Access & Facilities)',
                'SQD4 (Communication)',
                'SQD5 (Costs)',
                'SQD6 (Integrity)',
                'SQD7 (Assurance)',
                'SQD8 (Outcome)',
                'Average Score',
                'Suggestions / Comments',
                'Email',
                'Submitted At',
            ]);

            $query->orderBy('id', 'asc')->chunk(200, function ($records) use ($output) {
                foreach ($records as $item) {
                    fputcsv($output, [
                        $item->reference_no,
                        $item->transaction_date?->format('Y-m-d'),
                        $item->client_type,
                        $item->sex,
                        $item->age_group,
                        $item->region,
                        $item->office_transacted,
                        $item->service_availed.($item->service_availed_other ? " ({$item->service_availed_other})" : ''),
                        SurveyResponse::CC1_DESCRIPTIONS[$item->cc1] ?? $item->cc1,
                        SurveyResponse::CC2_DESCRIPTIONS[$item->cc2] ?? ($item->cc2 ?: 'N/A'),
                        SurveyResponse::CC3_DESCRIPTIONS[$item->cc3] ?? ($item->cc3 ?: 'N/A'),
                        $item->sqd0 ?? 'N/A',
                        $item->sqd1 ?? 'N/A',
                        $item->sqd2 ?? 'N/A',
                        $item->sqd3 ?? 'N/A',
                        $item->sqd4 ?? 'N/A',
                        $item->sqd5 ?? 'N/A',
                        $item->sqd6 ?? 'N/A',
                        $item->sqd7 ?? 'N/A',
                        $item->sqd8 ?? 'N/A',
                        $item->average_sqd_score ?? 'N/A',
                        $item->suggestions,
                        $item->email,
                        $item->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Display printable / PDF-ready executive summary report of Admin Results.
     */
    public function printReport(Request $request): View
    {
        $query = $this->applyFilters($request, SurveyResponse::query());

        $filteredQuery = clone $query;

        $totalResponses = $filteredQuery->count();
        $awareCount = $filteredQuery->clone()->whereIn('cc1', [1, 2, 3])->count();
        $awarenessRate = $totalResponses > 0 ? round(($awareCount / $totalResponses) * 100, 1) : 0.0;

        $overallSatisfiedCount = $filteredQuery->clone()->whereIn('sqd0', [4, 5])->count();
        $overallSatisfactionRate = $totalResponses > 0 ? round(($overallSatisfiedCount / $totalResponses) * 100, 1) : 0.0;
        $averageOverallScore = round((float) $filteredQuery->clone()->whereNotNull('sqd0')->avg('sqd0'), 2);

        // Calculate averages and counts for all SQD dimensions
        $dimensionStats = [];
        foreach (SurveyResponse::SQD_QUESTIONS as $key => $meta) {
            $dimensionQuery = $filteredQuery->clone();
            $avg = $dimensionQuery->whereNotNull($key)->avg($key);
            $satisfiedCount = $dimensionQuery->clone()->whereIn($key, [4, 5])->count();
            $totalDimensionRated = $dimensionQuery->clone()->whereNotNull($key)->count();
            $percentage = $totalDimensionRated > 0 ? round(($satisfiedCount / $totalDimensionRated) * 100, 1) : 0;

            $dimensionStats[$key] = [
                'title' => $meta['title'],
                'statement' => $meta['statement'],
                'avg' => round((float) $avg, 2),
                'percent_satisfied' => $percentage,
                'rated_count' => $totalDimensionRated,
            ];
        }

        $clientTypeBreakdown = $this->clientTypeBreakdown($filteredQuery);

        // Office performance breakdown
        $officePerformance = $filteredQuery->clone()
            ->selectRaw('office_transacted, COUNT(*) as total, AVG(sqd0) as avg_score')
            ->groupBy('office_transacted')
            ->orderByDesc('total')
            ->get();

        // Recent high-impact suggestions / feedback
        $recentFeedback = $filteredQuery->clone()
            ->whereNotNull('suggestions')
            ->where('suggestions', '!=', '')
            ->latest('transaction_date')
            ->take(10)
            ->get();

        return view('admin.report-print', [
            'totalResponses' => $totalResponses,
            'awareCount' => $awareCount,
            'awarenessRate' => $awarenessRate,
            'overallSatisfiedCount' => $overallSatisfiedCount,
            'overallSatisfactionRate' => $overallSatisfactionRate,
            'averageOverallScore' => $averageOverallScore,
            'dimensionStats' => $dimensionStats,
            'clientTypeBreakdown' => $clientTypeBreakdown,
            'officePerformance' => $officePerformance,
            'recentFeedback' => $recentFeedback,
            'generatedAt' => now(),
        ]);
    }

    /**
     * Count configured client types while keeping deleted types visible for historical responses.
     *
     * @return array<string, int>
     */
    private function clientTypeBreakdown(Builder $query): array
    {
        $configuredTypes = ClientType::query()->orderBy('name')->pluck('name');
        $responseCounts = (clone $query)
            ->select('client_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('client_type')
            ->pluck('total', 'client_type');

        return $configuredTypes
            ->merge($responseCounts->keys()->diff($configuredTypes))
            ->mapWithKeys(fn (string $type): array => [$type => (int) $responseCounts->get($type, 0)])
            ->all();
    }
}

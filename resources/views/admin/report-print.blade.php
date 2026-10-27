<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citizen's Charter Client Satisfaction Measurement (CSM) - Admin Executive Report</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                color: black !important;
                padding: 0 !important;
            }
            .page-break {
                page-break-before: always;
            }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
    </style>
</head>
<body class="bg-slate-100 py-8 px-4 text-slate-900 antialiased">

    <!-- Top Action Bar (hidden when printing) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.surveys.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-3 py-2 rounded-xl border border-slate-200 shadow-2xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print / Save PDF Report
            </button>
        </div>
    </div>

    <!-- Official Report Document Body -->
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-8 sm:p-12 print:shadow-none print:border-none print:p-0 space-y-6">

        <!-- Official Header -->
        <div class="text-center pb-6 border-b-2 border-slate-900 space-y-1">
            <div class="text-[11px] font-extrabold uppercase tracking-widest text-slate-500">
                Republic of the Philippines &bull; Anti-Red Tape Authority (ARTA)
            </div>
            <h1 class="text-xl sm:text-2xl font-black uppercase text-slate-900 tracking-tight">
                Citizen's Charter Client Satisfaction Measurement (CSM)
            </h1>
            <div class="text-xs font-bold text-blue-800 uppercase tracking-wider">
                Official Agency Consolidated Performance & Analytics Report
            </div>
            <div class="text-[11px] text-slate-400 pt-1">
                Generated from {{ strtoupper(config('database.default')) }} database on {{ $generatedAt->format('F d, Y \a\t h:i A') }}
            </div>
        </div>

        <!-- 1. Executive Summary KPIs -->
        <div class="space-y-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 bg-slate-100 px-3 py-1.5 rounded">
                I. Executive Summary Key Performance Indicators
            </h2>

            <div class="grid grid-cols-4 gap-4 text-center">
                <div class="border border-slate-200 rounded-xl p-3 bg-slate-50/50">
                    <span class="text-[10px] font-extrabold uppercase text-slate-500 block">Total Respondents</span>
                    <span class="text-2xl font-black font-mono text-slate-900">{{ number_format($totalResponses) }}</span>
                    <span class="text-[10px] text-slate-400 block">Valid entries</span>
                </div>
                <div class="border border-slate-200 rounded-xl p-3 bg-slate-50/50">
                    <span class="text-[10px] font-extrabold uppercase text-slate-500 block">CC Awareness Rate</span>
                    <span class="text-2xl font-black font-mono text-blue-700">{{ $awarenessRate }}%</span>
                    <span class="text-[10px] text-slate-400 block">{{ $awareCount }} Aware</span>
                </div>
                <div class="border border-slate-200 rounded-xl p-3 bg-slate-50/50">
                    <span class="text-[10px] font-extrabold uppercase text-slate-500 block">Satisfaction Rate</span>
                    <span class="text-2xl font-black font-mono text-emerald-600">{{ $overallSatisfactionRate }}%</span>
                    <span class="text-[10px] text-slate-400 block">Rated Agree/Strongly Agree</span>
                </div>
                <div class="border border-slate-200 rounded-xl p-3 bg-slate-50/50">
                    <span class="text-[10px] font-extrabold uppercase text-slate-500 block">Mean Overall (SQD0)</span>
                    <span class="text-2xl font-black font-mono text-amber-600">{{ $averageOverallScore }}</span>
                    <span class="text-[10px] text-slate-400 block">Out of 5.0</span>
                </div>
            </div>
        </div>

        <!-- 2. Service Quality Dimensions (SQD) Breakdown -->
        <div class="space-y-3">
            <div class="flex items-center justify-between bg-slate-100 px-3 py-1.5 rounded">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-800">
                    II. Service Quality Dimensions (SQD) Performance
                </h2>
                <span class="text-[11px] font-bold text-slate-600">ARTA Compliance Benchmark: ≥ 80%</span>
            </div>

            <table class="w-full text-left text-xs border border-slate-200 rounded">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                    <tr>
                        <th class="p-2 w-16">Dimension</th>
                        <th class="p-2">Service Dimension Title & Statement</th>
                        <th class="p-2 text-center w-20">Sample (N)</th>
                        <th class="p-2 text-center w-20">Mean Score</th>
                        <th class="p-2 text-right w-24">% Satisfied</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($dimensionStats as $dimKey => $stat)
                        <tr>
                            <td class="p-2 font-mono font-bold uppercase text-blue-900">{{ $dimKey }}</td>
                            <td class="p-2">
                                <span class="font-bold text-slate-900">{{ $stat['title'] }}:</span>
                                <span class="text-slate-600 italic">"{{ $stat['statement'] }}"</span>
                            </td>
                            <td class="p-2 text-center font-mono">{{ $stat['rated_count'] }}</td>
                            <td class="p-2 text-center font-bold font-mono text-slate-900">{{ $stat['avg'] }} / 5.0</td>
                            <td class="p-2 text-right font-extrabold font-mono {{ $stat['percent_satisfied'] >= 80 ? 'text-emerald-700' : 'text-amber-700' }}">
                                {{ $stat['percent_satisfied'] }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 3. Office & Division Performance Summary -->
        <div class="space-y-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 bg-slate-100 px-3 py-1.5 rounded">
                III. Frontline Office & Counter Performance
            </h2>

            <table class="w-full text-left text-xs border border-slate-200 rounded">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                    <tr>
                        <th class="p-2">Office / Division</th>
                        <th class="p-2 text-center w-24">Total Transacted</th>
                        <th class="p-2 text-center w-28">Share of Transactions</th>
                        <th class="p-2 text-right w-28">Average SQD0 Rating</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($officePerformance as $office)
                        @php
                            $share = $totalResponses > 0 ? round(($office->total / $totalResponses) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td class="p-2 font-semibold text-slate-900">{{ $office->office_transacted }}</td>
                            <td class="p-2 text-center font-mono">{{ $office->total }}</td>
                            <td class="p-2 text-center font-mono">{{ $share }}%</td>
                            <td class="p-2 text-right font-bold font-mono text-blue-900">{{ round($office->avg_score, 2) }} / 5.0</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 4. Client Classification Distribution -->
        <div class="space-y-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 bg-slate-100 px-3 py-1.5 rounded">
                IV. Client Demographics Distribution
            </h2>

            <div class="grid grid-cols-3 gap-4 text-xs">
                @foreach ($clientTypeBreakdown as $type => $count)
                    @php
                        $percent = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0;
                    @endphp
                    <div class="p-3 border border-slate-200 rounded-xl bg-slate-50">
                        <div class="text-slate-500 font-bold uppercase text-[10px]">{{ $type }}</div>
                        <div class="text-lg font-black text-slate-900 font-mono mt-0.5">{{ $count }}</div>
                        <div class="text-[10px] text-slate-400">{{ $percent }}% of total respondents</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 5. Client Remarks & Action Items Sample -->
        <div class="space-y-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 bg-slate-100 px-3 py-1.5 rounded">
                V. Recent Client Suggestions & Feedback
            </h2>

            <div class="space-y-2 text-xs">
                @forelse ($recentFeedback as $fb)
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded text-slate-700 italic flex items-start gap-2">
                        <span class="text-blue-700 font-bold shrink-0">&bull;</span>
                        <div class="flex-grow">
                            <span>"{{ $fb->suggestions }}"</span>
                            <span class="text-[10px] text-slate-400 not-italic block mt-0.5">
                                {{ $fb->office_transacted }} &bull; {{ $fb->client_type }} &bull; {{ $fb->transaction_date->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 italic">No feedback entries recorded.</p>
                @endforelse
            </div>
        </div>

        <!-- Signatory Blocks -->
        <div class="pt-8 grid grid-cols-2 gap-12 text-xs text-center page-break">
            <div>
                <div class="border-b border-slate-400 pb-1 mb-1">
                    <span class="font-bold uppercase text-slate-900">Quality Management Officer / Focal Person</span>
                </div>
                <div class="text-[10px] text-slate-500 uppercase">Prepared & Certified by</div>
            </div>
            <div>
                <div class="border-b border-slate-400 pb-1 mb-1">
                    <span class="font-bold uppercase text-slate-900">Head of Agency / Regional Director</span>
                </div>
                <div class="text-[10px] text-slate-500 uppercase">Approved for ARTA Submission</div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="pt-6 text-center text-[10px] text-slate-400 border-t border-slate-200 mt-6">
            Official Citizen's Charter Client Satisfaction Measurement (CSM) Report generated under Republic Act No. 11032.
            Database driver: {{ strtoupper(config('database.default')) }} &bull; Confidential and for official use only.
        </div>
    </div>

</body>
</html>

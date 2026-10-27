<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Citizen's Charter Survey - {{ $response->reference_no }}</title>

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
                size: A4;
                margin: 15mm;
            }
        }
    </style>
</head>
<body class="bg-slate-100 py-8 px-4 text-slate-900 antialiased">

    <!-- Top Action Bar (hidden on print) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ url()->previous() ?: route('admin.surveys.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-3 py-2 rounded-xl border border-slate-200 shadow-2xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print / Save as PDF
            </button>
        </div>
    </div>

    <!-- Official Printable Survey Document -->
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-8 sm:p-12 print:shadow-none print:border-none print:p-0">

        <!-- Header -->
        <div class="text-center pb-6 border-b-2 border-slate-900 space-y-1">
            <div class="text-[11px] font-extrabold uppercase tracking-widest text-slate-500">
                Republic of the Philippines &bull; Republic Act No. 11032
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold uppercase text-slate-900 tracking-tight">
                Client Satisfaction Measurement (CSM) Form
            </h1>
            <div class="text-xs font-semibold text-blue-900">
                Official Citizen's Charter Survey Record
            </div>
        </div>

        <!-- Reference & Status Metadata -->
        <div class="grid grid-cols-2 gap-4 py-4 border-b border-slate-200 text-xs">
            <div>
                <span class="text-slate-500 block uppercase font-bold text-[10px]">Reference Number:</span>
                <span class="font-mono font-black text-sm text-blue-800">{{ $response->reference_no }}</span>
            </div>
            <div class="text-right">
                <span class="text-slate-500 block uppercase font-bold text-[10px]">Date Recorded:</span>
                <span class="font-bold text-slate-900">{{ $response->created_at?->format('F d, Y h:i A') }}</span>
            </div>
        </div>

        <!-- Section 1: Client Information -->
        <div class="py-4 border-b border-slate-200 space-y-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 bg-slate-100 px-3 py-1.5 rounded">
                1. Client & Transaction Information
            </h2>

            <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-xs">
                <div>
                    <span class="text-slate-500 font-medium">Name of Office:</span>
                    <span class="font-bold text-slate-900 block">{{ $response->office_transacted }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Client Classification:</span>
                    <span class="font-bold text-slate-900 block">{{ $response->client_type }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Gender / Sex:</span>
                    <span class="font-bold text-slate-900 block">{{ $response->sex }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Age Group:</span>
                    <span class="font-bold text-slate-900 block">{{ $response->age_group }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Transaction Date:</span>
                    <span class="font-bold text-slate-900 block">{{ $response->transaction_date->format('F d, Y') }}</span>
                </div>
                <div>
                    <span class="text-slate-500 font-medium">Region:</span>
                    <span class="font-bold text-slate-900 block">{{ $response->region ?? 'N/A' }}</span>
                </div>
                <div class="col-span-2">
                    <span class="text-slate-500 font-medium">Service Availed:</span>
                    <span class="font-bold text-slate-900 block">
                        {{ $response->service_availed }}
                        @if ($response->service_availed_other)
                            ({{ $response->service_availed_other }})
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Section 2: Citizen's Charter Awareness -->
        <div class="py-4 border-b border-slate-200 space-y-3">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 bg-slate-100 px-3 py-1.5 rounded">
                2. Citizen's Charter (CC) Awareness
            </h2>

            <div class="space-y-2 text-xs">
                <div>
                    <span class="font-bold text-slate-700">CC1 (Awareness):</span>
                    <p class="font-semibold text-slate-900 pl-4">{{ $cc1Descriptions[$response->cc1] ?? $response->cc1 }}</p>
                </div>
                <div>
                    <span class="font-bold text-slate-700">CC2 (Visibility):</span>
                    <p class="font-semibold text-slate-900 pl-4">{{ $cc2Descriptions[$response->cc2] ?? ($response->cc2 ?: 'N/A') }}</p>
                </div>
                <div>
                    <span class="font-bold text-slate-700">CC3 (Helpfulness):</span>
                    <p class="font-semibold text-slate-900 pl-4">{{ $cc3Descriptions[$response->cc3] ?? ($response->cc3 ?: 'N/A') }}</p>
                </div>
            </div>
        </div>

        <!-- Section 3: Satisfaction Ratings (1–5) -->
        <div class="py-4 border-b border-slate-200 space-y-3">
            <div class="flex items-center justify-between bg-slate-100 px-3 py-1.5 rounded">
                <h2 class="text-xs font-black uppercase tracking-wider text-slate-800">
                    3. Service Quality Dimensions (SQD) Satisfaction Ratings
                </h2>
                <span class="text-[11px] font-bold text-slate-600">Scale: 1 (Strongly Disagree) to 5 (Strongly Agree)</span>
            </div>

            <table class="w-full text-left text-xs border border-slate-200 rounded">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                    <tr>
                        <th class="p-2 w-16">Dimension</th>
                        <th class="p-2">Statement</th>
                        <th class="p-2 text-center w-16">Score</th>
                        <th class="p-2 text-right w-36">Rating</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($sqdQuestions as $key => $meta)
                        @php $val = $response->{$key}; @endphp
                        <tr>
                            <td class="p-2 font-mono font-bold uppercase text-blue-900">{{ $key }}</td>
                            <td class="p-2">
                                <span class="font-semibold">{{ $meta['title'] }}:</span>
                                <span class="text-slate-600 italic">"{{ $meta['statement'] }}"</span>
                            </td>
                            <td class="p-2 text-center font-bold font-mono">
                                {{ $val ?? 'N/A' }}
                            </td>
                            <td class="p-2 text-right font-medium">
                                {{ $ratingLabels[$val] ?? 'Not Applicable' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section 4: Comments / Suggestions -->
        <div class="py-4 border-b border-slate-200 space-y-2">
            <h2 class="text-xs font-black uppercase tracking-wider text-slate-800 bg-slate-100 px-3 py-1.5 rounded">
                4. Client Comments & Suggestions
            </h2>
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-xs italic text-slate-800 min-h-[48px]">
                {{ $response->suggestions ?: 'None provided.' }}
            </div>

            @if ($response->email)
                <div class="pt-2 grid grid-cols-1 gap-2 text-xs">
                    <div>
                        <span class="text-slate-500 text-[10px] uppercase font-bold block">Email:</span>
                        <span class="font-semibold">{{ $response->email }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Official Sign-off / Verification -->
        <div class="pt-8 grid grid-cols-2 gap-8 text-xs text-center">
            <div>
                <div class="min-h-8 border-b border-slate-400 pb-1 mb-1"></div>
                <div class="text-[10px] text-slate-500 uppercase">Client Signature</div>
            </div>
            <div>
                <div class="border-b border-slate-400 pb-1 mb-1">
                    <span class="font-bold uppercase text-slate-900">Frontline / PACD Officer</span>
                </div>
                <div class="text-[10px] text-slate-500 uppercase">Receiving & Verification Officer</div>
            </div>
        </div>

        <!-- Print Footer Note -->
        <div class="pt-8 text-center text-[10px] text-slate-400 border-t border-slate-200 mt-6">
            Document generated electronically from the official Citizen's Charter Client Satisfaction Measurement (CSM) {{ strtoupper(config('database.default')) }} database.
            Compliant with R.A. 11032 and R.A. 10173.
        </div>
    </div>

</body>
</html>

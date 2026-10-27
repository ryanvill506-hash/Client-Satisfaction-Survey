@extends('layouts.admin')

@section('title', 'Survey Response: ' . $response->reference_no)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.surveys.index') }}"
           class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to All Responses
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition">
                Print Record
            </button>
        </div>
    </div>

    <!-- Response Overview Header -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-xs uppercase font-extrabold tracking-wider text-slate-500">Official Survey Submission</span>
                <span class="px-2 py-0.5 rounded text-xs font-bold {{ $response->is_charter_aware ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                    {{ $response->is_charter_aware ? 'CC Aware' : 'CC Not Aware' }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black font-mono text-blue-700">
                {{ $response->reference_no }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Submitted on {{ $response->created_at?->format('F d, Y \a\t h:i A') }} (Transaction Date: {{ $response->transaction_date->format('M d, Y') }})
            </p>
        </div>

        <div class="text-right sm:border-l sm:border-slate-100 sm:pl-6">
            <div class="text-xs text-slate-400 font-bold uppercase">Overall Rating (SQD0)</div>
            <div class="text-3xl font-extrabold text-slate-900">
                {{ $response->sqd0 ?? 'N/A' }} <span class="text-sm font-normal text-slate-400">/ 5</span>
            </div>
            <div class="text-xs text-slate-500 font-medium">
                {{ $ratingLabels[$response->sqd0] ?? 'Not Rated' }}
            </div>
        </div>
    </div>

    <!-- Client & Transaction Information -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-slate-900 px-6 py-3.5 text-white font-bold text-sm flex items-center justify-between">
            <span>Part I: Client & Transaction Profile</span>
            <span class="text-xs text-slate-400">Client Demographics</span>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-xs sm:text-sm">
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase mb-1">Client Classification</span>
                <span class="font-bold text-slate-900">{{ $response->client_type }}</span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase mb-1">Sex & Age Group</span>
                <span class="font-bold text-slate-900">{{ $response->sex }} &bull; {{ $response->age_group }}</span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase mb-1">Region</span>
                <span class="font-bold text-slate-900">{{ $response->region ?? 'Not Specified' }}</span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase mb-1">Office / Division</span>
                <span class="font-bold text-slate-900">{{ $response->office_transacted }}</span>
            </div>
            <div class="sm:col-span-2">
                <span class="block text-slate-400 text-xs font-bold uppercase mb-1">Service Availed</span>
                <span class="font-bold text-slate-900">
                    {{ $response->service_availed }}
                    @if ($response->service_availed_other)
                        <span class="text-slate-600 font-normal">({{ $response->service_availed_other }})</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Citizen's Charter (CC) Awareness Responses -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-blue-900 px-6 py-3.5 text-white font-bold text-sm flex items-center justify-between">
            <span>Part II: Citizen's Charter (CC) Awareness</span>
            <span class="text-xs text-blue-200">ARTA Core Standards</span>
        </div>
        <div class="p-6 space-y-4 text-xs sm:text-sm">
            <!-- CC1 -->
            <div class="border-b border-slate-100 pb-3 space-y-1">
                <div class="font-bold text-slate-700 flex items-center gap-1.5">
                    <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-bold">CC1</span>
                    Citizen's Charter Awareness
                </div>
                <div class="text-slate-900 font-medium pl-6">
                    {{ $cc1Descriptions[$response->cc1] ?? $response->cc1 }}
                </div>
            </div>

            <!-- CC2 -->
            <div class="border-b border-slate-100 pb-3 space-y-1">
                <div class="font-bold text-slate-700 flex items-center gap-1.5">
                    <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-bold">CC2</span>
                    Charter Visibility
                </div>
                <div class="text-slate-900 font-medium pl-6">
                    {{ $cc2Descriptions[$response->cc2] ?? ($response->cc2 ?: 'N/A') }}
                </div>
            </div>

            <!-- CC3 -->
            <div class="space-y-1">
                <div class="font-bold text-slate-700 flex items-center gap-1.5">
                    <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-bold">CC3</span>
                    Charter Helpfulness in Transaction
                </div>
                <div class="text-slate-900 font-medium pl-6">
                    {{ $cc3Descriptions[$response->cc3] ?? ($response->cc3 ?: 'N/A') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Service Quality Dimensions Rating Matrix -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-slate-900 px-6 py-3.5 text-white font-bold text-sm flex items-center justify-between">
            <span>Part III: Service Quality Dimensions (SQD) Ratings</span>
            <span class="text-xs text-slate-400">Scores (1-5)</span>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach ($sqdQuestions as $key => $meta)
                @php
                    $val = $response->{$key};
                @endphp
                <div class="p-4 sm:p-5 flex items-center justify-between gap-4 text-xs sm:text-sm">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="font-black text-blue-700 uppercase">{{ strtoupper($key) }}:</span>
                            <span class="font-bold text-slate-900">{{ $meta['title'] }}</span>
                        </div>
                        <p class="text-xs text-slate-500 italic">"{{ $meta['statement'] }}"</p>
                    </div>

                    <div class="shrink-0 text-right">
                        @if ($val)
                            @php
                                $badgeColor = match($val) {
                                    5 => 'bg-emerald-100 text-emerald-800',
                                    4 => 'bg-blue-100 text-blue-800',
                                    3 => 'bg-amber-100 text-amber-800',
                                    default => 'bg-rose-100 text-rose-800',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg font-black text-xs {{ $badgeColor }}">
                                {{ $val }} - {{ $ratingLabels[$val] ?? 'Rated' }}
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-500 font-semibold text-xs">
                                N/A
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Feedback & Email -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-slate-900 px-6 py-3.5 text-white font-bold text-sm">
            Part IV: Suggestions & Email Address
        </div>
        <div class="p-6 space-y-5 text-xs sm:text-sm">
            <div>
                <span class="block text-slate-400 text-xs font-bold uppercase mb-1">Suggestions / Comments</span>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-800 italic">
                    {{ $response->suggestions ?: 'No written suggestions or comments provided.' }}
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <div>
                    <span class="block text-slate-400 text-xs font-bold uppercase mb-1">Email Address</span>
                    <span class="font-bold text-slate-900">{{ $response->email ?: 'Not Provided' }}</span>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-100 text-[11px] text-slate-400 flex flex-wrap items-center gap-x-6 gap-y-1">
                <span>IP Address: {{ $response->masked_ip_address }}</span>
                <span>User Agent: {{ Str::limit($response->user_agent, 60) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

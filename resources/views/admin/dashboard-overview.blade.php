@extends('layouts.app')

@section('title', 'Admin Overview Dashboard - Citizen\'s Charter Client Satisfaction')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-800 text-xs font-bold uppercase tracking-wider mb-1">
                Administrative Overview
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Admin Dashboard Overview
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Quick snapshot of the latest client satisfaction statistics and response activity.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm shadow-xs transition">
                Main Dashboard
            </a>
            <a href="{{ route('admin.surveys.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs sm:text-sm shadow-xs transition">
                View Responses
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Responses</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ number_format($totalResponses) }}</div>
            <div class="mt-2 text-xs text-slate-500">Submitted surveys</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Awareness Rate</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ $awarenessRate }}%</div>
            <div class="mt-2 text-xs text-slate-500">{{ $awareCount }} respondents are aware</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Satisfaction</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ $overallSatisfactionRate }}%</div>
            <div class="mt-2 text-xs text-slate-500">Overall satisfaction score</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Average Score</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ $averageOverallScore }}</div>
            <div class="mt-2 text-xs text-slate-500">Based on the overall rating</div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-base text-slate-900">Recent Submissions</h2>
                    <p class="text-xs text-slate-500">Latest entries received in the system</p>
                </div>
                <a href="{{ route('admin.surveys.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Open list</a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse ($recentResponses as $response)
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-slate-100 bg-slate-50 p-3">
                        <div>
                            <div class="font-bold text-slate-900">{{ $response->reference_no }}</div>
                            <div class="text-xs text-slate-500">{{ $response->transaction_date?->format('M d, Y') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-semibold text-slate-500">{{ $response->client_type }}</div>
                            <a href="{{ route('admin.surveys.show', $response) }}" class="text-xs font-bold text-blue-700 hover:text-blue-800">View</a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500">
                        There are no survey responses yet.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="font-bold text-base text-slate-900">Client Type Breakdown</h2>
            </div>

            <div class="mt-4 space-y-4">
                @foreach ($clientTypeBreakdown as $type => $count)
                    @php $percent = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0; @endphp
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-700">
                            <span>{{ $type }}</span>
                            <span>{{ $count }}</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full bg-blue-600" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

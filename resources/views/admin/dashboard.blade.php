@extends('layouts.admin')

@section('title', 'Admin Dashboard - Citizen\'s Charter Client Satisfaction')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-800 text-xs font-bold uppercase tracking-wider mb-1">
                ARTA & Citizen's Charter Compliance
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Admin Dashboard
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Overview of response volume, awareness, satisfaction performance, and recent submissions.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-3 py-2 text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                Admin Tools
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Responses</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ number_format($totalResponses) }}</div>
            <div class="mt-2 text-xs text-slate-500">Submissions received</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">CC Awareness</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ $awarenessRate }}%</div>
            <div class="mt-2 text-xs text-slate-500">{{ $awareCount }} aware respondents</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Satisfaction Rate</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ $overallSatisfactionRate }}%</div>
            <div class="mt-2 text-xs text-slate-500">Agreed or strongly agreed</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Average Score</div>
            <div class="mt-3 text-3xl font-extrabold text-slate-900">{{ $averageOverallScore }}</div>
            <div class="mt-2 text-xs text-slate-500">Out of 5.0</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-base text-slate-900">Recent Responses</h2>
                    <p class="text-xs text-slate-500">Latest survey submissions</p>
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
                        <div class="flex flex-col items-end gap-1">
                            <div class="text-xs font-semibold text-slate-500">{{ $response->client_type }}</div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.surveys.show', $response) }}" class="rounded-lg bg-blue-50 px-3 py-1.5 text-[11px] font-bold text-blue-700 transition hover:bg-blue-100">View</a>
                                <form method="POST" action="{{ route('admin.surveys.destroy', $response) }}" onsubmit="return confirm('Delete this survey response? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-rose-50 px-3 py-1.5 text-[11px] font-bold text-rose-700 transition hover:bg-rose-100">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500">
                        No survey responses have been submitted yet.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
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

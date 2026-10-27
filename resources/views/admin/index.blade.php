@extends('layouts.admin')

@section('title', 'Admin Dashboard - Citizen\'s Charter Client Satisfaction')

@section('content')
<div class="space-y-8">

    <!-- Top Bar with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-800 text-xs font-bold uppercase tracking-wider mb-1">
                ARTA & Citizen's Charter Compliance
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Survey Analytics & Responses
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Real-time citizen satisfaction measurements, charter awareness benchmarks, and service ratings.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('survey.create') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 hover:bg-slate-100 text-slate-700 font-semibold text-xs sm:text-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Open Survey Form
            </a>
        </div>
    </div>

    <!-- SUMMARY KPI STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Responses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider">
                <span>Total Responses</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900">{{ number_format($totalResponses) }}</div>
            <div class="text-xs text-slate-500 flex items-center gap-1">
                <span class="text-emerald-600 font-bold">Active</span> submissions in database
            </div>
        </div>

        <!-- Citizen Charter Awareness -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider">
                <span>CC Awareness Rate</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900">{{ $awarenessRate }}%</div>
            <div class="text-xs text-slate-500 flex items-center gap-1">
                <span>{{ $awareCount }} of {{ $totalResponses }} aware of Citizen's Charter</span>
            </div>
        </div>

        <!-- Overall Satisfaction Rate -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider">
                <span>Satisfaction Rate</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900">{{ $overallSatisfactionRate }}%</div>
            <div class="text-xs text-slate-500">
                Percentage rated <strong>Agree</strong> or <strong>Strongly Agree</strong>
            </div>
        </div>

        <!-- Average Overall Score -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider">
                <span>Mean SQD0 Score</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900">
                {{ $averageOverallScore }} <span class="text-sm font-semibold text-slate-400">/ 5.0</span>
            </div>
            <div class="text-xs text-slate-500">
                Overall service satisfaction index
            </div>
        </div>
    </div>

    <!-- DETAILED ANALYTICS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Service Quality Dimensions Breakdown -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-base text-slate-900">Service Quality Dimensions (SQD) Performance</h2>
                    <p class="text-xs text-slate-500">Mean score and positive rating percentage for each standard dimension.</p>
                </div>
                <span class="text-xs font-semibold text-slate-500">Scale 1-5</span>
            </div>

            <div class="space-y-4 pt-1">
                @foreach ($dimensionStats as $dimKey => $stat)
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800">
                                <span class="text-blue-700 font-extrabold uppercase mr-1">{{ $dimKey }}:</span>
                                {{ $stat['title'] }}
                            </span>
                            <div class="flex items-center gap-3">
                                <span class="text-slate-500 font-medium">{{ $stat['percent_satisfied'] }}% Satisfied</span>
                                <span class="font-extrabold text-slate-900 bg-slate-100 px-2 py-0.5 rounded">{{ $stat['avg'] }} / 5</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden flex">
                            @php
                                $barPercent = min(100, max(0, ($stat['avg'] / 5) * 100));
                                $barColor = match(true) {
                                    $stat['avg'] >= 4.5 => 'bg-emerald-500',
                                    $stat['avg'] >= 4.0 => 'bg-blue-600',
                                    $stat['avg'] >= 3.0 => 'bg-amber-500',
                                    default => 'bg-rose-500',
                                };
                            @endphp
                            <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $barPercent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Client Type & Quick Demographics -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h2 class="font-bold text-base text-slate-900">Client Demographics</h2>
                <p class="text-xs text-slate-500">Respondent classification distribution.</p>
            </div>

            <div class="space-y-4">
                @foreach ($clientTypeBreakdown as $type => $count)
                    @php
                        $percent = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 1) : 0;
                    @endphp
                    <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-800">{{ $type }}</span>
                            <span class="font-extrabold text-slate-900">{{ $count }} ({{ $percent }}%)</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-100 text-xs text-blue-900 space-y-1">
                <div class="font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    ARTA Standard Reminder
                </div>
                <p class="text-blue-800 leading-relaxed">
                    Under ARTA guidelines, agencies must achieve at least 80% satisfaction and high Citizen's Charter visibility across all frontline service desks.
                </p>
            </div>
        </div>
    </div>

    <!-- FILTER BAR & RESPONSES TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden space-y-4">
        <!-- Filter Form -->
        <div class="p-5 border-b border-slate-200 bg-slate-50/60">
            <form action="{{ route('admin.surveys.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Search Keyword -->
                <div>
                    <label for="filter-search" class="block text-xs font-bold text-slate-600 mb-1">Search</label>
                    <input type="text" id="filter-search" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Ref No, Name, Service..."
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-500 outline-none">
                </div>

                <!-- Client Type -->
                <div>
                    <label for="filter-type" class="block text-xs font-bold text-slate-600 mb-1">Client Type</label>
                    <select id="filter-type" name="client_type"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-500 outline-none">
                        <option value="">All Types</option>
                        @foreach ($clientTypes as $clientType)
                            <option value="{{ $clientType }}" {{ ($filters['client_type'] ?? '') === $clientType ? 'selected' : '' }}>{{ $clientType }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Office Transacted -->
                <div>
                    <label for="filter-office" class="block text-xs font-bold text-slate-600 mb-1">Office / Division</label>
                    <select id="filter-office" name="office"
                            class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-500 outline-none">
                        <option value="">All Offices</option>
                        @foreach ($officesList as $off)
                            <option value="{{ $off }}" {{ ($filters['office'] ?? '') === $off ? 'selected' : '' }}>{{ $off }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range From -->
                <div>
                    <label for="filter-date-from" class="block text-xs font-bold text-slate-600 mb-1">Date From</label>
                    <input type="date" id="filter-date-from" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                           class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-500 outline-none">
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-2 px-3 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs shadow-xs transition">
                        Filter
                    </button>
                    <a href="{{ route('admin.surveys.index') }}" class="py-2 px-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 font-semibold text-xs text-center transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-100/80 text-slate-800 font-extrabold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5">Reference No</th>
                        <th class="px-4 py-3.5">Transaction Date</th>
                        <th class="px-4 py-3.5">Client Type</th>
                        <th class="px-4 py-3.5">Office & Service</th>
                        <th class="px-4 py-3.5 text-center">CC Awareness</th>
                        <th class="px-4 py-3.5 text-center">Overall (SQD0)</th>
                        <th class="px-4 py-3.5 text-center">Mean Score</th>
                        <th class="px-5 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($responses as $row)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-bold font-mono text-blue-700">
                                {{ $row->reference_no }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap text-slate-600">
                                {{ $row->transaction_date?->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full font-semibold text-[10px]
                                    {{ $row->client_type === 'Citizen' ? 'bg-blue-100 text-blue-800' : ($row->client_type === 'Business' ? 'bg-emerald-100 text-emerald-800' : ($row->client_type === 'Student' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800')) }}">
                                    {{ $row->client_type }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 max-w-xs truncate">
                                <div class="font-bold text-slate-900 truncate">{{ $row->office_transacted }}</div>
                                <div class="text-[11px] text-slate-500 truncate">{{ $row->service_availed }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                @if ($row->is_charter_aware)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        Aware (CC{{ $row->cc1 }})
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600">
                                        Not Aware
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                @if ($row->sqd0)
                                    @php
                                        $badgeColor = match($row->sqd0) {
                                            5 => 'bg-emerald-100 text-emerald-800',
                                            4 => 'bg-blue-100 text-blue-800',
                                            3 => 'bg-amber-100 text-amber-800',
                                            default => 'bg-rose-100 text-rose-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded font-black {{ $badgeColor }}">
                                        {{ $row->sqd0 }} / 5
                                    </span>
                                @else
                                    <span class="text-slate-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-center font-bold whitespace-nowrap">
                                {{ $row->average_sqd_score ? $row->average_sqd_score . ' / 5' : 'N/A' }}
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.surveys.show', $row->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[11px] transition">
                                        <span>Details</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.surveys.destroy', $row) }}" onsubmit="return confirm('Delete this survey response? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-[11px] transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-slate-400">
                                No survey responses found matching your filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($responses->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $responses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Survey Submitted Successfully - Citizen\'s Charter')

@section('content')
<div class="max-w-2xl mx-auto py-6 sm:py-10">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden text-center p-8 sm:p-10 space-y-6">

        <!-- Checkmark Graphic -->
        <div class="mx-auto w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center ring-8 ring-emerald-50">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <!-- Success Heading -->
        <div class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Maraming Salamat!
            </h1>
            <p class="text-slate-600 text-sm sm:text-base max-w-md mx-auto">
                Your feedback has been recorded in our official Citizen's Charter Client Satisfaction database.
            </p>
        </div>

        <!-- Reference Code Card -->
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-2 max-w-md mx-auto">
            <div class="text-xs uppercase font-extrabold tracking-wider text-slate-500">
                Official Reference Number
            </div>
            <div class="flex items-center justify-center gap-3">
                <span class="text-2xl font-black font-mono tracking-wider text-blue-700 select-all" id="ref-code">
                    {{ $response->reference_no }}
                </span>
                <button type="button" onclick="navigator.clipboard.writeText('{{ $response->reference_no }}'); alert('Reference number copied to clipboard!');"
                        title="Copy to clipboard"
                        class="p-2 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 transition shadow-2xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>
            <div class="text-[11px] text-slate-400">
                Please save this reference code for your records or transaction verification.
            </div>
        </div>

        <!-- Submission Summary -->
        <div class="text-left border border-slate-200 rounded-2xl p-5 bg-slate-50/50 space-y-3 text-xs sm:text-sm">
            <div class="font-bold text-slate-800 border-b border-slate-200 pb-2">
                Transaction Summary
            </div>
            <div class="grid grid-cols-2 gap-y-2 text-slate-600">
                <div>Client Type:</div>
                <div class="font-semibold text-slate-900 text-right">{{ $response->client_type }}</div>

                <div>Transaction Date:</div>
                <div class="font-semibold text-slate-900 text-right">{{ $response->transaction_date->format('F d, Y') }}</div>

                <div>Office Visited:</div>
                <div class="font-semibold text-slate-900 text-right">{{ $response->office_transacted }}</div>

                <div>Service Availed:</div>
                <div class="font-semibold text-slate-900 text-right">
                    {{ $response->service_availed }}
                    @if ($response->service_availed_other)
                        ({{ $response->service_availed_other }})
                    @endif
                </div>

                <div>Charter Awareness:</div>
                <div class="font-semibold text-slate-900 text-right">
                    <span class="px-2 py-0.5 rounded text-xs {{ $response->is_charter_aware ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                        {{ $response->is_charter_aware ? 'Aware' : 'Not Aware' }}
                    </span>
                </div>

                <div>Overall Rating:</div>
                <div class="font-semibold text-slate-900 text-right">
                    @if ($response->sqd0)
                        <span class="px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800">
                            {{ $response->sqd0 }} / 5 ({{ $ratingLabels[$response->sqd0] ?? 'Rated' }})
                        </span>
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-4">
            <a href="{{ route('survey.create') }}"
               class="w-full sm:w-auto px-6 py-3 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm shadow-md shadow-blue-600/20 transition">
                Submit Another Survey
            </a>
        </div>
    </div>
</div>
@endsection


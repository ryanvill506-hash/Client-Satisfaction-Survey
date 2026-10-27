@extends('layouts.app')

@section('title', 'Citizen\'s Charter Client Satisfaction Survey')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Hero Header -->
    <div class="text-center space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold tracking-wide uppercase">
            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
        
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
         Client Satisfaction Survey
        </h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto">
            Help us serve you better! Your candid feedback will assist our agency in improving government frontline service delivery, transparency, and efficiency under Republic Act No. 11032.
        </p>
    </div>

    <!-- INSTRUCTIONS ACCORDION / CARD (Prominent & Clear) -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50/40 border border-blue-200/80 rounded-2xl p-6 sm:p-7 shadow-xs relative overflow-hidden" id="instructions-container">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-28 h-28 bg-blue-200/30 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-start justify-between gap-4 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Survey Instructions & Guidelines</h2>
                    <p class="text-xs text-slate-600">Please take 3-5 minutes to read this brief guide before answering.</p>
                </div>
            </div>
            <button type="button" id="toggle-instructions-btn" class="text-xs font-semibold text-blue-700 hover:text-blue-900 bg-white/80 px-3 py-1.5 rounded-lg border border-blue-200 shadow-2xs hover:bg-white transition">
                Hide Instructions
            </button>
        </div>

        <div id="instructions-content" class="space-y-4 text-xs sm:text-sm text-slate-700 transition-all duration-300">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <!-- What is Citizen's Charter -->
                <div class="bg-white/90 p-4 rounded-xl border border-blue-100/80 space-y-1.5">
                    <div class="font-bold text-blue-900 flex items-center gap-1.5 text-xs sm:text-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        1. What is the Citizen's Charter?
                    </div>
                    <p class="text-slate-600 leading-relaxed text-xs">
                        The <strong>Citizen's Charter</strong> is an official document, poster, or electronic billboard displayed in every government office that outlines the step-by-step procedure, required documents, processing fees, standard processing time, and the officer responsible for each frontline service.
                    </p>
                </div>

                <!-- How to Answer Rating Scale -->
                <div class="bg-white/90 p-4 rounded-xl border border-blue-100/80 space-y-1.5">
                    <div class="font-bold text-blue-900 flex items-center gap-1.5 text-xs sm:text-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        2. How to Rate the Questions (SQD)
                    </div>
                    <p class="text-slate-600 leading-relaxed text-xs">
                        For each service quality statement, select the rating that corresponds to your actual experience:
                    </p>
                    <div class="flex flex-wrap gap-1.5 text-[11px] font-medium pt-1 text-slate-700">
                        <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">5 = Strongly Agree</span>
                        <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800">4 = Agree</span>
                        <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800">3 = Neutral</span>
                        <span class="px-2 py-0.5 rounded bg-orange-100 text-orange-800">2 = Disagree</span>
                        <span class="px-2 py-0.5 rounded bg-rose-100 text-rose-800">1 = Strongly Disagree</span>
                        <span class="px-2 py-0.5 rounded bg-slate-200 text-slate-700">N/A = Not Applicable</span>
                    </div>
                </div>
            </div>

            <!-- Data Privacy Notice -->
            <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-xl p-3.5 flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <div class="text-xs text-emerald-900 leading-relaxed">
                    <span class="font-bold">Data Privacy Assurance:</span> In accordance with Republic Act No. 10173 (Data Privacy Act of 2012), all personal data and responses provided in this survey will be handled with utmost confidentiality and used solely for public service assessment and continuous quality enhancement.
                </div>
            </div>
        </div>
    </div>

   
    <!-- MAIN SURVEY FORM -->
    <form action="{{ route('survey.store') }}" method="POST" class="space-y-8" id="survey-form">
        @csrf

        <!-- PART I: CLIENT & TRANSACTION PROFILE (Matches Flowchart Order) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-slate-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-500 text-white text-xs font-extrabold flex items-center justify-center">1</span>
                    <h2 class="font-bold text-base sm:text-lg">Part I: Client Information</h2>
                </div>
                <span class="text-xs text-slate-400">Demographic & Transaction Details</span>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                <!-- 1. Name of Office -->
                <div>
                    <label for="office_transacted" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Name of the Office <span class="text-rose-500">*</span>
                    </label>
                    <select id="office_transacted" name="office_transacted" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        <option value="" disabled {{ old('office_transacted') ? '' : 'selected' }}>Select an office</option>
                        @foreach ($offices as $office)
                            <option value="{{ $office }}" {{ old('office_transacted') === $office ? 'selected' : '' }}>{{ $office }}</option>
                        @endforeach
                    </select>
                    @error('office_transacted')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. Client Type -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">
                        Client Type <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500">Please choose the classification that best represents you.</p>
                    <div class="space-y-2 pt-1">
                        @foreach ($clientTypes as $value => $label)
                            <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-3 text-left transition hover:border-blue-400 hover:bg-slate-50 focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-500/20 {{ old('client_type') === $value ? 'border-blue-600 bg-blue-50/60' : '' }}">
                                <input type="radio" name="client_type" value="{{ $value }}" {{ old('client_type') === $value ? 'checked' : '' }} required class="mt-0.5 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                <span>
                                    <span class="block font-bold text-sm text-slate-900">{{ $value }}</span>
                                    <span class="block text-xs text-slate-500">{{ $label }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('client_type')
                        <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- 3. Gender / Sex -->
                    <div>
                        <label for="sex" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Gender <span class="text-rose-500">*</span>
                        </label>
                        <select id="sex" name="sex" required
                                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                            <option value="" disabled {{ old('sex') ? '' : 'selected' }}>Select Gender</option>
                            <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Prefer not to say" {{ old('sex') === 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                        </select>
                        @error('sex')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 4. Age -->
                    <div>
                        <label for="age_group" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Age <span class="text-rose-500">*</span>
                        </label>
                        <select id="age_group" name="age_group" required
                                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                            <option value="" disabled {{ old('age_group') ? '' : 'selected' }}>Select Age</option>
                            @foreach ($ageGroups as $age)
                                <option value="{{ $age }}" {{ old('age_group') === $age ? 'selected' : '' }}>{{ $age }}</option>
                            @endforeach
                        </select>
                        @error('age_group')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 5. Transaction Date -->
                    <div>
                        <label for="transaction_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Transaction Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="transaction_date" name="transaction_date"
                               value="{{ old('transaction_date', now()->format('Y-m-d')) }}"
                               max="{{ now()->format('Y-m-d') }}"
                               required
                               class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        @error('transaction_date')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 6. Service Availed -->
                <div>
                    <label for="service_availed" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Service Availed <span class="text-rose-500">*</span>
                    </label>
                    <select id="service_availed" name="service_availed" required
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        <option value="" disabled {{ old('service_availed') ? '' : 'selected' }}>Select Service Availed</option>
                        @foreach ($services as $service)
                            <option value="{{ $service }}" {{ old('service_availed') === $service ? 'selected' : '' }}>{{ $service }}</option>
                        @endforeach
                    </select>
                    @error('service_availed')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror

                    <!-- Service other input -->
                    <div id="service-other-box" class="mt-3 {{ old('service_availed') === 'Other' ? '' : 'hidden' }}">
                        <label for="service_availed_other" class="block text-xs font-semibold text-slate-600 mb-1">
                            Please specify other service availed: <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="service_availed_other" name="service_availed_other"
                               value="{{ old('service_availed_other') }}"
                               @if (old('service_availed') === 'Other') required @endif
                               placeholder="e.g. Special accreditation request, archive retrieval..."
                               class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        @error('service_availed_other')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- PART II: CITIZEN'S CHARTER QUESTIONS (CC1, CC2, CC3) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-blue-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-500 text-white text-xs font-extrabold flex items-center justify-center">2</span>
                    <h2 class="font-bold text-base sm:text-lg">Part II: Citizen's Charter (CC) Awareness & Visibility</h2>
                </div>
                <span class="text-xs text-blue-200">Standard CC Questions</span>
            </div>

            <div class="p-6 sm:p-8 space-y-8">
                <!-- CC1 Question -->
                <div class="space-y-3">
                    <div class="flex items-start gap-2">
                        <span class="inline-flex items-center justify-center px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-extrabold shrink-0">CC1</span>
                        <div>
                            <label class="block text-sm font-bold text-slate-900">
                                Which of the following best describes your awareness of the Citizen's Charter? <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-xs text-slate-500">Select one option that applies to your knowledge and observation.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-2.5 pt-1">
                        @foreach ($cc1Options as $optValue => $optLabel)
                            <label class="relative flex items-center gap-3 p-3.5 border rounded-xl cursor-pointer transition hover:bg-slate-50 {{ old('cc1') == $optValue ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200' }}">
                                <input type="radio" name="cc1" value="{{ $optValue }}" {{ old('cc1') == $optValue ? 'checked' : '' }} required class="cc1-radio text-blue-600 focus:ring-blue-500 h-4 w-4">
                                <span class="text-xs sm:text-sm text-slate-800 font-medium">
                                    <strong>{{ $optValue }}.</strong> {{ $optLabel }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('cc1')
                        <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CC Notice Box when CC1 is option 4 -->
                <div id="cc-unaware-note" class="hidden p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <strong>Notice:</strong> Because you indicated that you do not know what a Citizen's Charter is, questions <strong>CC2</strong> and <strong>CC3</strong> will be automatically marked as <strong>N/A (Not Applicable)</strong>. You may proceed directly to Part III.
                    </div>
                </div>

                <!-- CC2 & CC3 Container -->
                <div id="cc-dependent-questions" class="space-y-8 pt-4 border-t border-slate-100">
                    <!-- CC2 Question -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-2">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-extrabold shrink-0">CC2</span>
                            <div>
                                <label class="block text-sm font-bold text-slate-900">
                                    If aware of the Citizen's Charter (answered 1-3 in CC1), would you say that the Citizen's Charter of this office was...?
                                </label>
                                <p class="text-xs text-slate-500">Rate the visibility and ease of finding the charter in the office or online.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-1">
                            @foreach ($cc2Options as $optValue => $optLabel)
                                <label class="relative flex items-center gap-2.5 p-3 border rounded-xl cursor-pointer transition hover:bg-slate-50 {{ old('cc2') == $optValue ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200' }}">
                                    <input type="radio" name="cc2" value="{{ $optValue }}" {{ old('cc2') == $optValue ? 'checked' : '' }} required class="cc2-radio text-blue-600 focus:ring-blue-500 h-4 w-4">
                                    <span class="text-xs sm:text-sm text-slate-800 font-medium">{{ $optLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('cc2')
                            <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CC3 Question -->
                    <div class="space-y-3">
                        <div class="flex items-start gap-2">
                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs font-extrabold shrink-0">CC3</span>
                            <div>
                                <label class="block text-sm font-bold text-slate-900">
                                    If aware of the Citizen's Charter, how much did the Citizen's Charter help you in your transaction?
                                </label>
                                <p class="text-xs text-slate-500">Rate how helpful the charter was in guiding your requirements, steps, and fees.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 pt-1">
                            @foreach ($cc3Options as $optValue => $optLabel)
                                <label class="relative flex items-center gap-2.5 p-3 border rounded-xl cursor-pointer transition hover:bg-slate-50 {{ old('cc3') == $optValue ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200' }}">
                                    <input type="radio" name="cc3" value="{{ $optValue }}" {{ old('cc3') == $optValue ? 'checked' : '' }} required class="cc3-radio text-blue-600 focus:ring-blue-500 h-4 w-4">
                                    <span class="text-xs sm:text-sm text-slate-800 font-medium">{{ $optLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('cc3')
                            <p class="text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- PART III: SERVICE QUALITY DIMENSIONS (SQD0 to SQD8) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-slate-900 px-4 py-3 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-500 text-white text-xs font-extrabold flex items-center justify-center">3</span>
                    <h2 class="font-bold text-base sm:text-lg">Part III: Service Quality Dimensions (SQD)</h2>
                </div>
                <span class="text-xs text-slate-400">Rate 1 (Strongly Disagree) to 5 (Strongly Agree)</span>
            </div>

            <!-- Rating Legend Sticky/Top Bar -->
            <div class="bg-slate-50 border-b border-slate-200 px-4 py-2 text-xs text-slate-600 flex flex-wrap items-center justify-between gap-1.5">
                <div class="font-bold text-slate-700">Rating Guide:</div>
                <div class="flex flex-wrap items-center gap-1 font-medium">
                    <span class="inline-flex items-center gap-1 text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200"> 5 - Strongly Agree</span>
                    <span class="inline-flex items-center gap-1 text-blue-800 bg-blue-50 px-1.5 py-0.5 rounded border border-blue-200"> 4 - Agree</span>
                    <span class="inline-flex items-center gap-1 text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200"> 3 - Neutral</span>
                    <span class="inline-flex items-center gap-1 text-orange-800 bg-orange-50 px-1.5 py-0.5 rounded border border-orange-200"> 2 - Disagree</span>
                    <span class="inline-flex items-center gap-1 text-rose-800 bg-rose-50 px-1.5 py-0.5 rounded border border-rose-200"> 1 - Strongly Disagree</span>
                    <span class="inline-flex items-center gap-1 text-slate-600 bg-slate-200/70 px-1.5 py-0.5 rounded">N/A - Not Applicable</span>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach ($sqdQuestions as $key => $q)
                    <div class="p-3 sm:p-4 hover:bg-slate-50/50 transition {{ $key === 'sqd0' ? 'bg-blue-50/20' : '' }}">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2.5">
                            <div class="space-y-0.5 max-w-xl">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-xs font-black uppercase {{ $key === 'sqd0' ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-800' }}">
                                        {{ strtoupper($key) }}
                                    </span>
                                    <span class="font-bold text-slate-900 text-sm sm:text-base">{{ $q['title'] }}</span>
                                    @if ($key === 'sqd0')
                                        <span class="text-slate-500 text-xs font-medium">(Optional)</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-600 leading-snug italic">
                                    "{{ $q['statement'] }}"
                                </p>
                            </div>

                            <!-- Rating options selector -->
                            <div class="flex items-center gap-1 shrink-0">
                                @foreach ([1, 2, 3, 4, 5] as $rating)
                                    @php
                                        $emoji = match($rating) {
                                            1 => '',
                                            2 => '',
                                            3 => '',
                                            4 => '',
                                            5 => '',
                                        };
                                        $colorHover = match($rating) {
                                            1 => 'hover:border-rose-400 hover:bg-rose-50',
                                            2 => 'hover:border-orange-400 hover:bg-orange-50',
                                            3 => 'hover:border-amber-400 hover:bg-amber-50',
                                            4 => 'hover:border-blue-400 hover:bg-blue-50',
                                            5 => 'hover:border-emerald-400 hover:bg-emerald-50',
                                        };
                                        $activeColor = match($rating) {
                                            1 => 'peer-checked:bg-rose-600 peer-checked:text-white peer-checked:border-rose-600',
                                            2 => 'peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-orange-500',
                                            3 => 'peer-checked:bg-amber-500 peer-checked:text-white peer-checked:border-amber-500',
                                            4 => 'peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600',
                                            5 => 'peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600',
                                        };
                                    @endphp
                                    <label class="cursor-pointer">
                                        <input type="radio" name="{{ $key }}" value="{{ $rating }}"
                                               {{ old($key) == $rating ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="w-9 h-10 sm:w-10 sm:h-11 rounded-lg border border-slate-200 bg-white flex flex-col items-center justify-center gap-0.5 text-xs font-bold text-slate-700 transition shadow-2xs {{ $colorHover }} {{ $activeColor }}">
                                            <span class="text-sm leading-none">{{ $emoji }}</span>
                                            <span class="text-[10px]">{{ $rating }}</span>
                                        </div>
                                    </label>
                                @endforeach

                                <label class="cursor-pointer">
                                    <input type="radio" name="{{ $key }}" value=""
                                           {{ old($key) === '' ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="h-10 sm:h-11 px-2 rounded-lg border border-slate-200 bg-white flex flex-col items-center justify-center text-[10px] sm:text-xs font-semibold text-slate-500 transition hover:bg-slate-100 peer-checked:bg-slate-700 peer-checked:text-white peer-checked:border-slate-700 shadow-2xs">
                                        <span>N/A</span>
                                    </div>
                                </label>

                            </div>
                        </div>
                        @error($key)
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        </div>

        <!-- PART IV: CLIENT SUGGESTIONS & CONTACT DETAILS -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="bg-slate-900 px-6 py-4 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-500 text-white text-xs font-extrabold flex items-center justify-center">4</span>
                    <h2 class="font-bold text-base sm:text-lg">Part IV: Suggestions & Contact Information</h2>
                </div>
                <span class="text-xs text-slate-400">Continuous Improvement</span>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                <!-- Suggestions -->
                <div>
                    <label for="suggestions" class="block text-sm font-bold text-slate-800 mb-1">
                        Suggestions / Recommendations / Commendations
                    </label>
                    <p class="text-xs text-slate-500 mb-2">
                        How can we improve our frontline services, facilities, processing times, or Citizen's Charter information?
                    </p>
                    <textarea id="suggestions" name="suggestions" rows="4"
                              placeholder="Please write your suggestions, commendations, or specific areas for improvement here..."
                              class="w-full rounded-xl border border-slate-300 p-3.5 text-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">{{ old('suggestions') }}</textarea>
                    @error('suggestions')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Optional Email Address -->
                <div class="border border-slate-200 rounded-xl p-5 bg-slate-50/60 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-bold text-sm text-slate-800">Email Address (Optional)</div>
                            <div class="text-xs text-slate-500">Provide your email address if you wish to receive feedback or follow-up regarding your transaction.</div>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded bg-slate-200 text-slate-700 font-semibold">Optional</span>
                    </div>

                    <div class="pt-2">
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   placeholder="juan@example.com"
                                   class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                        </div>
                    </div>
                </div>

                <!-- Data Privacy Consent -->
                <div class="pt-2">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="data_privacy_consent" value="1" {{ old('data_privacy_consent') ? 'checked' : '' }} required
                               class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                            <strong class="text-slate-900">Data Privacy Consent:</strong> I voluntarily consent to the collection and processing of my answers for the purpose of the Citizen's Charter Client Satisfaction Measurement (CSM) pursuant to R.A. 11032 and R.A. 10173. <span class="text-rose-500">*</span>
                        </span>
                    </label>
                    @error('data_privacy_consent')
                        <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button Footer -->
            <div class="bg-slate-50 px-6 sm:px-8 py-5 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500 flex items-center gap-1.5">
                    <span class="text-rose-500 font-bold">*</span> Indicates mandatory fields
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="reset" class="w-1/2 sm:w-auto px-5 py-3 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                        Reset Form
                    </button>
                    <button type="submit" id="submit-btn" class="w-1/2 sm:w-auto px-8 py-3 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold shadow-md shadow-blue-600/20 transition flex items-center justify-center gap-2">
                        <span>Submit Survey</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle Instructions
        const toggleBtn = document.getElementById('toggle-instructions-btn');
        const instructionsContent = document.getElementById('instructions-content');
        if (toggleBtn && instructionsContent) {
            toggleBtn.addEventListener('click', function () {
                if (instructionsContent.classList.contains('hidden')) {
                    instructionsContent.classList.remove('hidden');
                    toggleBtn.textContent = 'Hide Instructions';
                } else {
                    instructionsContent.classList.add('hidden');
                    toggleBtn.textContent = 'Show Instructions';
                }
            });
        }

        // Service Availed Other handler
        const serviceSelect = document.getElementById('service_availed');
        const serviceOtherBox = document.getElementById('service-other-box');
        const serviceOtherInput = document.getElementById('service_availed_other');

        function syncServiceOtherField() {
            if (!serviceSelect || !serviceOtherBox || !serviceOtherInput) {
                return;
            }

            const isOtherSelected = serviceSelect.value === 'Other';
            serviceOtherBox.classList.toggle('hidden', !isOtherSelected);

            if (isOtherSelected) {
                serviceOtherInput.setAttribute('required', 'required');
                if (document.activeElement !== serviceOtherInput) {
                    serviceOtherInput.focus({ preventScroll: true });
                }
            } else {
                serviceOtherInput.removeAttribute('required');
            }
        }

        if (serviceSelect && serviceOtherBox) {
            serviceSelect.addEventListener('change', syncServiceOtherField);
            syncServiceOtherField();
        }

        // CC1 selection logic
        const cc1Radios = document.querySelectorAll('.cc1-radio');
        const ccUnawareNote = document.getElementById('cc-unaware-note');
        const ccDependentContainer = document.getElementById('cc-dependent-questions');
        const cc2Radios = document.querySelectorAll('.cc2-radio');
        const cc3Radios = document.querySelectorAll('.cc3-radio');

        function updateCcLogic(selectedVal) {
            const isUnaware = selectedVal === '4';

            if (isUnaware) {
                // Option 4: Do not know CC and did not see one
                ccUnawareNote.classList.remove('hidden');
                ccDependentContainer.classList.add('opacity-50', 'pointer-events-none');

                cc2Radios.forEach(radio => {
                    radio.checked = radio.value === '5';
                });
                cc3Radios.forEach(radio => {
                    radio.checked = radio.value === '4';
                });
            } else {
                ccUnawareNote.classList.add('hidden');
                ccDependentContainer.classList.remove('opacity-50', 'pointer-events-none');
            }

            [...cc2Radios, ...cc3Radios].forEach(radio => {
                radio.disabled = isUnaware;
                radio.required = !isUnaware;
            });
        }

        cc1Radios.forEach(radio => {
            radio.addEventListener('change', function () {
                updateCcLogic(this.value);
            });
            if (radio.checked) {
                updateCcLogic(radio.value);
            }
        });
    });
</script>
@endpush

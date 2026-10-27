<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Citizen\'s Charter Client Satisfaction Survey')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN for instant rendering -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#5cf069',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        gov: {
                            blue: '#0038A8',
                            red: '#CE1126',
                            gold: '#FCD116',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Top Gov Accent Bar -->
    <div class="h-1.5 w-full bg-gradient-to-r from-gov-blue via-gov-gold to-gov-red"></div>

    <!-- Main Navigation Header -->
    <header class="bg-green-50 border-b border-green-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Branding -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('survey.create') }}" class="flex items-center gap-3 group">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden flex items-center justify-center group-hover:shadow-md transition">
                                <img src="{{ asset('images/cpsu-logo.jpg') }}" alt="CPSU logo" class="w-10 h-10 object-contain">
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden flex items-center justify-center group-hover:shadow-md transition">
                                <img src="{{ asset('images/bagong pilipinas.jpg') }}" alt="Bagong Pilipinas logo" class="w-10 h-10 object-cover rounded-lg">
                            </div>
                        </div>
                        <div>
                            <div class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.16em] text-blue-800 leading-tight">Republic of the Philippines</div>
                            <div class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight leading-tight">
                                CENTRAL PHILIPPINES STATE UNIVERSITY
                            </div>
                            <div class="text-[10px] sm:text-xs font-medium text-slate-600 tracking-wide">
                                Kabankalan City, Negros Occidental
                            </div>
                        </div>
                    </a>
                </div>


            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="font-medium text-sm">{{ session('status') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                <div class="flex items-center gap-2 font-bold text-sm mb-1 text-rose-900">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Please correct the following errors before submitting:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700 ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span>Citizen's Charter Client Satisfaction Measurement (CSM) System</span>
                <span class="hidden sm:inline">&bull;</span>
                <span class="hidden sm:inline">Republic Act No. 11032 (Ease of Doing Business Act)</span>
            </div>
            <div class="text-slate-400 text-center sm:text-right">
                Compliant with the Data Privacy Act of 2012 (R.A. 10173)
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

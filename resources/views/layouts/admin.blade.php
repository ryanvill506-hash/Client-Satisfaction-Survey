<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard')</title>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="min-h-full flex flex-col font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">
    <div class="h-1.5 w-full bg-gradient-to-r from-gov-blue via-gov-gold to-gov-red"></div>

    <header class="bg-slate-950 border-b border-slate-800 sticky top-0 z-30 shadow-lg shadow-slate-950/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/cpsu-logo.jpg') }}" alt="CPSU logo" class="w-8 h-8 object-contain">
                    </div>
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/bagong pilipinas.jpg') }}" alt="bagong pilipinas" class="w-8 h-8 object-contain">
                    </div>
                    <div class="min-w-0">
                        <div class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Republic of the Philippines</div>
                        <div class="text-sm sm:text-base font-extrabold text-white tracking-tight leading-tight">
                            CENTRAL PHILIPPINES STATE UNIVERSITY
                        </div>
                        <div class="text-[10px] sm:text-xs font-medium text-slate-400 tracking-wide">
                            Kabankalan City, Negros Occidental
                        </div>
                    </div>
                </div>

                <div class="relative">
                    @unless(request()->routeIs('admin.login'))
                        <button
                            type="button"
                            id="admin-menu-toggle"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-200 transition hover:bg-slate-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                            aria-label="Open admin navigation"
                            aria-controls="admin-navigation"
                            aria-expanded="false"
                        >
                            <svg id="admin-menu-open-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg id="admin-menu-close-icon" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />
                            </svg>
                        </button>
                        <nav
                            id="admin-navigation"
                            class="absolute right-0 top-full z-40 mt-2 hidden w-56 flex-col gap-1 rounded-xl border border-slate-700 bg-slate-950 p-2 shadow-xl"
                            aria-hidden="true"
                        >
                            <a href="{{ route('admin.dashboard') }}"
                               class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-900 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.surveys.index') }}"
                               class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.surveys.*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                Responses
                            </a>
                            <a href="{{ route('admin.offices.index') }}"
                               class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.offices.*') ? 'bg-blue-600 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                Offices
                            </a>
                            <div class="mt-1 border-t border-slate-800 pt-2 space-y-1">
                                <a href="{{ route('admin.surveys.export', request()->query()) }}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-emerald-300 transition hover:bg-slate-800 hover:text-emerald-200">
                                    Export CSV
                                </a>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center rounded-lg px-3 py-2 text-left text-sm font-medium text-rose-300 transition hover:bg-slate-800 hover:text-rose-200">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </nav>
                    @endunless
                </div>
            </div>
        </div>
    </header>

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

    <footer class="bg-white border-t border-slate-200 mt-auto text-slate-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span>Citizen's Charter Client Satisfaction Measurement (CSM) System</span>
            </div>
            <div class="text-slate-400 text-center sm:text-right">
                Admin Dashboard • Data Privacy Compliance
            </div>
        </div>
    </footer>

    @stack('scripts')
    @unless(request()->routeIs('admin.login'))
        <script>
            const adminMenuToggle = document.getElementById('admin-menu-toggle');
            const adminNavigation = document.getElementById('admin-navigation');
            const adminMenuOpenIcon = document.getElementById('admin-menu-open-icon');
            const adminMenuCloseIcon = document.getElementById('admin-menu-close-icon');

            adminMenuToggle.addEventListener('click', () => {
                const isExpanded = adminMenuToggle.getAttribute('aria-expanded') === 'true';

                adminMenuToggle.setAttribute('aria-expanded', String(!isExpanded));
                adminMenuToggle.setAttribute('aria-label', isExpanded ? 'Open admin navigation' : 'Close admin navigation');
                adminNavigation.classList.toggle('hidden', isExpanded);
                adminNavigation.classList.toggle('flex', !isExpanded);
                adminNavigation.setAttribute('aria-hidden', String(isExpanded));
                adminMenuOpenIcon.classList.toggle('hidden', !isExpanded);
                adminMenuCloseIcon.classList.toggle('hidden', isExpanded);
            });
        </script>
    @endunless
</body>
</html>

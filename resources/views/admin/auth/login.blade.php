@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="bg-slate-900 px-6 py-4 text-white">
            <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Secure Access</div>
            <h1 class="mt-2 text-2xl font-extrabold text-white">Admin Sign In</h1>
        </div>

        <div class="p-6 sm:p-8">
            @if (session('error'))
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                </div>

                <button type="submit" class="w-full rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-sm px-4 py-3 transition">
                    Sign In
                </button>
            </form>

        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Manage Offices')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Manage Offices</h1>
            <p class="mt-1 text-sm text-slate-600">Add offices or edit a name; changes save when you leave the field. They apply to new survey responses.</p>
        </div>
        <span class="text-xs font-semibold text-slate-500">{{ $offices->count() }} offices</span>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xs">
        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
            <h2 class="text-base font-bold text-slate-900">Survey office options</h2>
            <p class="mt-1 text-xs text-slate-500">Saved survey responses keep the office name that was submitted at the time.</p>
        </div>

        <form method="POST" action="{{ route('admin.offices.store') }}" class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:px-6">
            @csrf
            <label for="new-office-name" class="sr-only">Office name</label>
            <input
                id="new-office-name"
                type="text"
                name="name"
                value="{{ old('_form') || old('_office_id') ? '' : old('name') }}"
                maxlength="150"
                required
                placeholder="Enter office name"
                class="min-w-0 flex-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20"
            >
            <button type="submit" class="rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-blue-800">
                Add Office
            </button>
        </form>

        @if ($offices->isEmpty())
            <p class="px-5 py-8 text-center text-sm text-slate-500">No offices have been added yet.</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach ($offices as $office)
                    <li class="px-5 py-4 sm:px-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <form method="POST" action="{{ route('admin.offices.update', $office) }}" class="office-name-form flex min-w-0 flex-1 flex-col gap-3 sm:flex-row sm:items-center">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="_office_id" value="{{ $office->id }}">
                                <label for="office-name-{{ $office->id }}" class="sr-only">Office name</label>
                                <input
                                    id="office-name-{{ $office->id }}"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') && old('_office_id') == $office->id ? old('name') : $office->name }}"
                                    maxlength="150"
                                    required
                                    class="min-w-0 flex-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20"
                                >
                            </form>
                            <form method="POST" action="{{ route('admin.offices.destroy', $office) }}" onsubmit="return confirm('Delete this office? It will no longer be available for new survey responses. Existing responses will be preserved.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50 sm:w-auto">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white shadow-xs">
        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
            <h2 class="text-base font-bold text-slate-900">Manage Client Types</h2>
            <p class="mt-1 text-xs text-slate-500">Add or remove choices from the public survey. Existing responses are preserved.</p>
        </div>

        <form method="POST" action="{{ route('admin.client-types.store') }}" class="flex flex-col gap-3 p-5 sm:flex-row sm:px-6">
            @csrf
            <label for="new-client-type-name" class="sr-only">Client type name</label>
            <input
                id="new-client-type-name"
                type="text"
                name="name"
                value="{{ old('_form') === 'client_type' ? old('name') : '' }}"
                maxlength="150"
                required
                placeholder="Enter client type"
                class="min-w-0 flex-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20"
            >
            <input type="hidden" name="_form" value="client_type">
            <button type="submit" class="rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-blue-800">
                Add Client Type
            </button>
        </form>

        @if ($clientTypes->isEmpty())
            <p class="border-t border-slate-100 px-5 py-6 text-center text-sm text-slate-500">No client types have been added yet.</p>
        @else
            <ul class="divide-y divide-slate-100 border-t border-slate-100">
                @foreach ($clientTypes as $clientType)
                    <li class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <span class="text-sm font-medium text-slate-800">{{ $clientType->name }}</span>
                        <form method="POST" action="{{ route('admin.client-types.destroy', $clientType) }}" onsubmit="return confirm('Remove this client type from future survey choices? Existing responses will be preserved.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50 sm:w-auto">
                                Delete
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white shadow-xs">
        <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
            <h2 class="text-base font-bold text-slate-900">Manage Services Availed</h2>
            <p class="mt-1 text-xs text-slate-500">Add or remove services available on the public survey. Existing responses are preserved.</p>
        </div>

        <form method="POST" action="{{ route('admin.service-options.store') }}" class="flex flex-col gap-3 p-5 sm:flex-row sm:px-6">
            @csrf
            <label for="new-service-name" class="sr-only">Service name</label>
            <input
                id="new-service-name"
                type="text"
                name="name"
                value="{{ old('_form') === 'service' ? old('name') : '' }}"
                maxlength="150"
                required
                placeholder="Enter service name"
                class="min-w-0 flex-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20"
            >
            <input type="hidden" name="_form" value="service">
            <button type="submit" class="rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-blue-800">
                Add Service
            </button>
        </form>

        @if ($serviceOptions->isEmpty())
            <p class="border-t border-slate-100 px-5 py-6 text-center text-sm text-slate-500">No services have been added yet.</p>
        @else
            <ul class="divide-y divide-slate-100 border-t border-slate-100">
                @foreach ($serviceOptions as $serviceOption)
                    <li class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <span class="text-sm font-medium text-slate-800">{{ $serviceOption->name }}</span>
                        <form method="POST" action="{{ route('admin.service-options.destroy', $serviceOption) }}" onsubmit="return confirm('Remove this service from future survey choices? Existing responses will be preserved.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50 sm:w-auto">
                                Delete
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.office-name-form input[name="name"]').forEach((input) => {
        input.addEventListener('change', () => {
            if (input.form.reportValidity()) {
                input.form.requestSubmit();
            }
        });
    });
</script>
@endpush

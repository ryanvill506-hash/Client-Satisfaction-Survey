<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\Office;
use App\Models\ServiceOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OfficeController extends Controller
{
    public function index(): View
    {
        return view('admin.offices.index', [
            'offices' => Office::query()->orderBy('name')->get(),
            'clientTypes' => ClientType::query()->orderBy('name')->get(),
            'serviceOptions' => ServiceOption::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('offices', 'name')],
        ]);

        Office::create($validated);

        return redirect()->route('admin.offices.index')
            ->with('status', 'Office added successfully.');
    }

    public function update(Request $request, Office $office): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('offices', 'name')->ignore($office)],
        ]);

        $office->update($validated);

        return redirect()->route('admin.offices.index')
            ->with('status', 'Office updated successfully.');
    }

    public function destroy(Office $office): RedirectResponse
    {
        $office->delete();

        return redirect()->route('admin.offices.index')
            ->with('status', 'Office deleted successfully.');
    }
}

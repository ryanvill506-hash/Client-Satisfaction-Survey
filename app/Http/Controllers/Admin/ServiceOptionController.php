<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceOptionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('service_options', 'name')],
        ]);

        ServiceOption::create($validated);

        return redirect()->route('admin.offices.index')
            ->with('status', 'Service added successfully.');
    }

    public function destroy(ServiceOption $serviceOption): RedirectResponse
    {
        $serviceOption->delete();

        return redirect()->route('admin.offices.index')
            ->with('status', 'Service deleted successfully.');
    }
}

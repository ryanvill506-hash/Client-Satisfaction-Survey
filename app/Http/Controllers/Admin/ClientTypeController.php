<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientTypeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('client_types', 'name')],
        ]);

        ClientType::create([
            'name' => $validated['name'],
            'description' => $validated['name'],
        ]);

        return redirect()->route('admin.offices.index')
            ->with('status', 'Client type added successfully.');
    }

    public function destroy(ClientType $clientType): RedirectResponse
    {
        $clientType->delete();

        return redirect()->route('admin.offices.index')
            ->with('status', 'Client type deleted successfully.');
    }
}

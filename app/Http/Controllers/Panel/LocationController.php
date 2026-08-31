<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Location;

class LocationController extends Controller
{
    public function index(Company $company)
    {
        $locations = Location::where('company_id', $company->id)
            ->withCount('equipment')
            ->latest()
            ->paginate(15);

        return view('panel.locations.index', compact('company', 'locations'));
    }

    public function create(Company $company)
    {
        return view('panel.locations.create', compact('company'));
    }

    public function store(Company $company, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'contact_name' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:50',
        ]);

        $validated['company_id'] = $company->id;

        Location::create($validated);

        return redirect()->route('panel.locations.index', ['company' => $company->slug])
            ->with('success', 'Lokasyon başarıyla eklendi.');
    }

    public function edit(Company $company, Location $location)
    {
        return view('panel.locations.edit', compact('company', 'location'));
    }

    public function update(Company $company, Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'contact_name' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:50',
        ]);

        $location->update($validated);

        return redirect()->route('panel.locations.index', ['company' => $company->slug])
            ->with('success', 'Lokasyon güncellendi.');
    }

    public function destroy(Company $company, Location $location)
    {
        $location->delete();

        return redirect()->route('panel.locations.index', ['company' => $company->slug])
            ->with('success', 'Lokasyon silindi.');
    }
}

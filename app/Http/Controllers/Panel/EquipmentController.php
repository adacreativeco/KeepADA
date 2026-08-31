<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Equipment;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\MeterReading;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public function index(Company $company, Request $request)
    {
        $query = Equipment::where('company_id', $company->id)
            ->with(['location', 'supplier']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $equipmentList = $query->latest()->paginate(12)->withQueryString();
        $locations = Location::where('company_id', $company->id)->get();
        $categories = Equipment::where('company_id', $company->id)->whereNotNull('category')->distinct()->pluck('category');

        return view('panel.equipment.index', compact('company', 'equipmentList', 'locations', 'categories'));
    }

    public function create(Company $company)
    {
        $locations = Location::where('company_id', $company->id)->get();
        $suppliers = Supplier::where('company_id', $company->id)->get();

        return view('panel.equipment.create', compact('company', 'locations', 'suppliers'));
    }

    public function store(Company $company, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'location_id' => 'nullable|exists:locations,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'warranty_end_date' => 'nullable|date',
            'current_meter_reading' => 'nullable|numeric|min:0',
            'meter_unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,under_maintenance,inactive,scrapped',
            'notes' => 'nullable|string',
        ]);

        $validated['company_id'] = $company->id;
        $validated['qr_code'] = $validated['code'] . '-' . Str::random(6);

        $equipment = Equipment::create($validated);

        return redirect()->route('panel.equipment.show', ['company' => $company->slug, 'equipment' => $equipment->id])
            ->with('success', 'Ekipman başarıyla kaydedildi.');
    }

    public function show(Company $company, Equipment $equipment)
    {
        $equipment->load(['location', 'supplier', 'maintenancePlans.assignedUser', 'maintenanceTasks.assignedUser', 'meterReadings' => fn($q) => $q->latest()->take(10)]);

        return view('panel.equipment.show', compact('company', 'equipment'));
    }

    public function printLabel(Company $company, Equipment $equipment)
    {
        $equipment->load(['location', 'supplier']);
        $publicPassportUrl = route('equipment.public-show', $equipment->code);

        return view('panel.equipment.print-label', compact('company', 'equipment', 'publicPassportUrl'));
    }

    public function edit(Company $company, Equipment $equipment)
    {
        $locations = Location::where('company_id', $company->id)->get();
        $suppliers = Supplier::where('company_id', $company->id)->get();

        return view('panel.equipment.edit', compact('company', 'equipment', 'locations', 'suppliers'));
    }

    public function update(Company $company, Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100',
            'location_id' => 'nullable|exists:locations,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'category' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'warranty_end_date' => 'nullable|date',
            'current_meter_reading' => 'nullable|numeric|min:0',
            'meter_unit' => 'nullable|string|max:50',
            'status' => 'required|in:active,under_maintenance,inactive,scrapped',
            'notes' => 'nullable|string',
        ]);

        $equipment->update($validated);

        return redirect()->route('panel.equipment.show', ['company' => $company->slug, 'equipment' => $equipment->id])
            ->with('success', 'Ekipman bilgileri güncellendi.');
    }

    public function destroy(Company $company, Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('panel.equipment.index', ['company' => $company->slug])
            ->with('success', 'Ekipman başarıyla silindi.');
    }

    public function addMeterReading(Company $company, Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'reading_value' => 'required|numeric|min:0',
            'reading_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        MeterReading::create([
            'company_id' => $company->id,
            'equipment_id' => $equipment->id,
            'reading_value' => $validated['reading_value'],
            'reading_date' => $validated['reading_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Sayaç okuması kaydedildi ve ilgili bakım planları kontrol edildi.');
    }
}

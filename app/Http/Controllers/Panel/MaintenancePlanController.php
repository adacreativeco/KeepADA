<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\MaintenancePlan;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class MaintenancePlanController extends Controller
{
    public function index(Company $company)
    {
        $plans = MaintenancePlan::where('company_id', $company->id)
            ->with(['equipment.location', 'assignedUser', 'maintenanceTasks'])
            ->latest()
            ->paginate(15);

        return view('panel.plans.index', compact('company', 'plans'));
    }

    public function triggerPlans(Company $company)
    {
        Artisan::call('keepada:generate-maintenance-tasks', [
            '--company' => $company->id,
        ]);

        return redirect()->route('panel.plans.index', ['company' => $company->slug])
            ->with('success', 'Periyodik bakım planları kontrol edildi ve vadesi gelen iş emirleri otomatik üretildi.');
    }

    public function create(Company $company, Request $request)
    {
        $equipmentList = Equipment::where('company_id', $company->id)->get();
        $technicians = $company->users()->get();
        $selectedEquipmentId = $request->get('equipment_id');

        return view('panel.plans.create', compact('company', 'equipmentList', 'technicians', 'selectedEquipmentId'));
    }

    public function store(Company $company, Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency_type' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'frequency_value' => 'required|integer|min:1',
            'meter_interval' => 'nullable|numeric|min:0',
            'estimated_duration_minutes' => 'nullable|integer|min:0',
            'estimated_cost' => 'nullable|numeric|min:0',
            'sla_hours' => 'nullable|integer|min:1',
            'next_due_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        $validated['company_id'] = $company->id;
        $validated['is_active'] = $request->boolean('is_active', true);

        $plan = MaintenancePlan::create($validated);

        return redirect()->route('panel.plans.index', ['company' => $company->slug])
            ->with('success', 'Bakım planı oluşturuldu ve ilk iş emri otomatik planlandı.');
    }

    public function edit(Company $company, MaintenancePlan $plan)
    {
        $equipmentList = Equipment::where('company_id', $company->id)->get();
        $technicians = $company->users()->get();

        return view('panel.plans.edit', compact('company', 'plan', 'equipmentList', 'technicians'));
    }

    public function update(Company $company, Request $request, MaintenancePlan $plan)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'frequency_type' => 'required|in:daily,weekly,monthly,quarterly,yearly',
            'frequency_value' => 'required|integer|min:1',
            'meter_interval' => 'nullable|numeric|min:0',
            'estimated_duration_minutes' => 'nullable|integer|min:0',
            'estimated_cost' => 'nullable|numeric|min:0',
            'sla_hours' => 'nullable|integer|min:1',
            'next_due_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $plan->update($validated);

        return redirect()->route('panel.plans.index', ['company' => $company->slug])
            ->with('success', 'Bakım planı güncellendi.');
    }

    public function destroy(Company $company, MaintenancePlan $plan)
    {
        $plan->delete();

        return redirect()->route('panel.plans.index', ['company' => $company->slug])
            ->with('success', 'Bakım planı silindi.');
    }
}

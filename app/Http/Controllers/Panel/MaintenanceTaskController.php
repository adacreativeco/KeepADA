<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\MaintenanceTask;
use App\Models\MaintenancePlan;
use App\Models\Equipment;
use App\Models\User;
use App\Models\SparePart;

class MaintenanceTaskController extends Controller
{
    public function index(Company $company, Request $request)
    {
        $query = MaintenanceTask::where('company_id', $company->id)
            ->with(['equipment', 'assignedUser', 'plan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('equipment', fn($eq) => $eq->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $viewMode = $request->get('view', 'table'); // 'table' or 'kanban'

        if ($viewMode === 'kanban') {
            $tasks = $query->orderBy('scheduled_date', 'asc')->get();
            $kanbanTasks = [
                'pending' => $tasks->where('status', 'pending'),
                'in_progress' => $tasks->where('status', 'in_progress'),
                'done' => $tasks->where('status', 'done'),
                'cancelled' => $tasks->where('status', 'cancelled'),
            ];
            $tasksList = null;
        } else {
            $tasksList = $query->orderBy('scheduled_date', 'asc')->paginate(15)->withQueryString();
            $kanbanTasks = null;
        }

        $technicians = $company->users()->get();
        $equipmentList = Equipment::where('company_id', $company->id)->get();

        return view('panel.tasks.index', compact('company', 'tasksList', 'kanbanTasks', 'viewMode', 'technicians', 'equipmentList'));
    }

    public function create(Company $company, Request $request)
    {
        $equipmentList = Equipment::where('company_id', $company->id)->get();
        $technicians = $company->users()->get();
        $plans = MaintenancePlan::where('company_id', $company->id)->where('is_active', true)->get();
        $selectedEquipmentId = $request->get('equipment_id');

        return view('panel.tasks.create', compact('company', 'equipmentList', 'technicians', 'plans', 'selectedEquipmentId'));
    }

    public function store(Company $company, Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'plan_id' => 'nullable|exists:maintenance_plans,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:preventive,corrective,emergency',
            'status' => 'required|in:pending,in_progress,done,cancelled',
            'priority' => 'required|in:low,medium,high,critical',
            'scheduled_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['company_id'] = $company->id;

        $task = MaintenanceTask::create($validated);

        return redirect()->route('panel.tasks.show', ['company' => $company->slug, 'task' => $task->id])
            ->with('success', 'İş emri / görev başarıyla oluşturuldu.');
    }

    public function show(Company $company, MaintenanceTask $task)
    {
        $task->load(['equipment.location', 'assignedUser', 'plan', 'spareParts']);
        $spareParts = SparePart::where('company_id', $company->id)->get();
        $technicians = $company->users()->get();

        return view('panel.tasks.show', compact('company', 'task', 'spareParts', 'technicians'));
    }

    public function edit(Company $company, MaintenanceTask $task)
    {
        $equipmentList = Equipment::where('company_id', $company->id)->get();
        $technicians = $company->users()->get();
        $plans = MaintenancePlan::where('company_id', $company->id)->get();

        return view('panel.tasks.edit', compact('company', 'task', 'equipmentList', 'technicians', 'plans'));
    }

    public function update(Company $company, Request $request, MaintenanceTask $task)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'plan_id' => 'nullable|exists:maintenance_plans,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:preventive,corrective,emergency',
            'status' => 'required|in:pending,in_progress,done,cancelled',
            'priority' => 'required|in:low,medium,high,critical',
            'scheduled_date' => 'required|date',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'labor_cost' => 'nullable|numeric|min:0',
            'material_cost' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'done' && empty($validated['completed_at'])) {
            $validated['completed_at'] = now();
        }

        if ($validated['status'] === 'in_progress' && empty($validated['started_at'])) {
            $validated['started_at'] = now();
        }

        $task->update($validated);

        return redirect()->route('panel.tasks.show', ['company' => $company->slug, 'task' => $task->id])
            ->with('success', 'İş emri güncellendi.');
    }

    public function updateStatus(Company $company, Request $request, MaintenanceTask $task)
    {
        $status = $request->validate([
            'status' => 'required|in:pending,in_progress,done,cancelled',
        ])['status'];

        $updates = ['status' => $status];

        if ($status === 'in_progress' && !$task->started_at) {
            $updates['started_at'] = now();
        } elseif ($status === 'done' && !$task->completed_at) {
            $updates['completed_at'] = now();
        }

        $task->update($updates);

        return back()->with('success', 'Görev durumu güncellendi: ' . ucfirst($status));
    }

    public function addSparePart(Company $company, Request $request, MaintenanceTask $task)
    {
        $validated = $request->validate([
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $part = SparePart::findOrFail($validated['spare_part_id']);

        // Check if already attached
        $existing = $task->spareParts()->where('spare_part_id', $part->id)->first();
        if ($existing) {
            $newQty = $existing->pivot->quantity_used + $validated['quantity'];
            $task->spareParts()->updateExistingPivot($part->id, ['quantity_used' => $newQty]);
        } else {
            $task->spareParts()->attach($part->id, ['quantity_used' => $validated['quantity']]);
        }

        // Decrement stock and create audit trail
        $part->adjustStock($validated['quantity'], 'out', $task->id, "İş Emri #{$task->id} ({$task->title}) için kullanıldı");

        return back()->with('success', "{$part->name} ({$validated['quantity']} {$part->unit}) göreve eklendi ve stoktan düşüldü.");
    }

    public function removeSparePart(Company $company, MaintenanceTask $task, SparePart $sparePart)
    {
        $pivot = $task->spareParts()->where('spare_part_id', $sparePart->id)->first();
        if ($pivot) {
            $qty = $pivot->pivot->quantity_used;
            $task->spareParts()->detach($sparePart->id);
            $sparePart->adjustStock($qty, 'in', $task->id, "İş Emri #{$task->id} iptal/çıkarma nedeniyle iade");
        }

        return back()->with('success', 'Yedek parça görevden çıkarıldı ve stoğa iade edildi.');
    }

    public function destroy(Company $company, MaintenanceTask $task)
    {
        $task->delete();

        return redirect()->route('panel.tasks.index', ['company' => $company->slug])
            ->with('success', 'İş emri silindi.');
    }
}

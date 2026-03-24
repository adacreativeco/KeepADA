<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceTask;
use Illuminate\Http\Request;

class MaintenanceTaskApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $company = $user->companies()->first();

        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        $query = MaintenanceTask::where('company_id', $company->id);

        // Teknisyen ise sadece kendi görevleri
        if ($user->hasRole('technician')) {
            $query->where('assigned_to', $user->id);
        }

        // Filtreler
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return $query->with(['equipment', 'assignedUser'])->latest()->paginate(20);
    }

    public function show(Request $request, $id)
    {
        $user = $request->user();
        $company = $user->companies()->first();

        $task = MaintenanceTask::where('company_id', $company->id)
            ->with(['equipment', 'assignedUser', 'spareParts', 'plan'])
            ->findOrFail($id);

        return $task;
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,done,cancelled',
            'notes' => 'nullable|string',
        ]);

        $user = $request->user();
        $company = $user->companies()->first();

        $task = MaintenanceTask::where('company_id', $company->id)->findOrFail($id);

        $updateData = ['status' => $request->status];
        
        if ($request->has('notes')) {
            $updateData['notes'] = $request->notes;
        }

        if ($request->status === 'done') {
            $updateData['completed_at'] = now();
        }

        $task->update($updateData);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task->fresh(['equipment', 'assignedUser'])
        ]);
    }
}

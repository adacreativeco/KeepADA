<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\MaintenanceTask;

class CalendarController extends Controller
{
    public function index(Company $company)
    {
        return view('panel.calendar.index', compact('company'));
    }

    public function events(Company $company, Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $query = MaintenanceTask::where('company_id', $company->id)
            ->with(['equipment', 'assignedUser']);

        if ($start && $end) {
            $query->whereBetween('scheduled_date', [$start, $end]);
        }

        $events = $query->get()->map(function ($task) use ($company) {
            $color = match ($task->status) {
                'done' => '#10b981',       // Emerald
                'in_progress' => '#3b82f6',// Blue
                'cancelled' => '#ef4444',  // Red
                default => '#f59e0b',      // Amber for pending
            };

            if ($task->status !== 'done' && $task->scheduled_date->isPast()) {
                $color = '#ef4444'; // Red for overdue
            }

            return [
                'id' => $task->id,
                'title' => $task->title . ' (' . ($task->equipment?->name ?? 'Ekipman') . ')',
                'start' => $task->scheduled_date->toDateString(),
                'url' => route('panel.tasks.show', ['company' => $company->slug, 'task' => $task->id]),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'technician' => $task->assignedUser?->name ?? 'Atanmamış',
                ],
            ];
        });

        return response()->json($events);
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceTask;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Facades\Filament;

class CalendarWidget extends FullCalendarWidget
{
    /**
     * Return events that should be displayed on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $tenant = Filament::getTenant();

        if (!$tenant) {
            return [];
        }

        return MaintenanceTask::query()
            ->where('company_id', $tenant->id)
            ->where('scheduled_date', '>=', $fetchInfo['start'])
            ->where('scheduled_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (MaintenanceTask $task) use ($tenant) {
                return [
                    'id'    => $task->id,
                    'title' => $task->title . ' (' . $task->equipment->name . ')',
                    'start' => $task->scheduled_date->toIso8601String(),
                    'url'   => route('filament.admin.resources.maintenance-tasks.view', [
                        'tenant' => $tenant,
                        'record' => $task,
                    ]),
                    'color' => match (true) {
                        $task->status !== 'done' && $task->scheduled_date->isPast() => 'red',
                        $task->scheduled_date->isToday() && $task->status !== 'done' => 'orange',
                        $task->status === 'pending'     => 'gray',
                        $task->status === 'in_progress' => 'blue',
                        $task->status === 'done'        => 'green',
                        $task->status === 'cancelled'   => 'red',
                        default                         => 'blue',
                    },
                ];
            })
            ->toArray();
    }
}

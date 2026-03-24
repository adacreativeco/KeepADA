<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceTask;
use Filament\Widgets\ChartWidget;

class SlaPerformanceChart extends ChartWidget
{
    protected ?string $heading = 'SLA Başarı Oranı';
    protected ?string $maxHeight = '250px';

    public static function canView(): bool
    {
        return !auth()->user()->hasRole('viewer');
    }

    protected function getData(): array
    {
        $tasks = MaintenanceTask::where('status', 'done')
            ->whereNotNull('completed_at')
            ->get();

        $success = $tasks->filter(fn ($task) => $task->sla_status === 'İçinde')->count();
        $failed = $tasks->filter(fn ($task) => $task->sla_status === 'Gecikti')->count();

        return [
            'datasets' => [
                [
                    'label' => 'SLA Durumu',
                    'data' => [$success, $failed],
                    'backgroundColor' => ['#22c55e', '#ef4444'],
                ],
            ],
            'labels' => ['SLA İçinde', 'SLA Gecikti'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

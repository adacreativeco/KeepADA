<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\MaintenanceTask;
use Carbon\Carbon;

class MaintenanceTrendChart extends ApexChartWidget
{
    protected static ?string $chartId = 'maintenanceTrendChart';
    protected static ?string $heading = 'Bakım Trendi (Son 6 Ay)';

    protected function getOptions(): array
    {
        $tenant = \Filament\Facades\Filament::getTenant();
        if (!$tenant) return [];

        $labels = [];
        $plannedData = [];
        $completedData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('F');
            
            $plannedData[] = MaintenanceTask::where('company_id', $tenant->id)
                ->whereMonth('scheduled_date', $month->month)
                ->whereYear('scheduled_date', $month->year)
                ->count();
                
            $completedData[] = MaintenanceTask::where('company_id', $tenant->id)
                ->whereMonth('completed_at', $month->month)
                ->whereYear('completed_at', $month->year)
                ->where('status', 'done')
                ->count();
        }

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Planlanan',
                    'data' => $plannedData,
                ],
                [
                    'name' => 'Tamamlanan',
                    'data' => $completedData,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
            ],
            'colors' => ['#f59e0b', '#10b981'],
        ];
    }
}

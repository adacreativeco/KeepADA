<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\MaintenanceTask;

class CostAnalysisChart extends ApexChartWidget
{
    protected static ?string $chartId = 'costAnalysisChart';
    protected static ?string $heading = 'Maliyet Analizi (Son 6 Ay)';

    protected function getOptions(): array
    {
        $labels = [];
        $laborData = [];
        $materialData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->translatedFormat('F');
            
            $laborData[] = MaintenanceTask::whereMonth('completed_at', $month->month)
                ->whereYear('completed_at', $month->year)
                ->where('status', 'done')
                ->sum('labor_cost');
                
            $materialData[] = MaintenanceTask::whereMonth('completed_at', $month->month)
                ->whereYear('completed_at', $month->year)
                ->where('status', 'done')
                ->sum('actual_cost');
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
                'stacked' => true,
            ],
            'series' => [
                [
                    'name' => 'İşçilik',
                    'data' => $laborData,
                ],
                [
                    'name' => 'Malzeme',
                    'data' => $materialData,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
            ],
            'colors' => ['#6366f1', '#f43f5e'],
            'yaxis' => [
                'labels' => [
                    'formatter' => 'function (val) { return "₺" + val.toFixed(0) }',
                ],
            ],
        ];
    }
}

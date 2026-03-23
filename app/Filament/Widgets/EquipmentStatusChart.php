<?php

namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use App\Models\Equipment;

class EquipmentStatusChart extends ApexChartWidget
{
    protected static ?string $chartId = 'equipmentStatusChart';
    protected static ?string $heading = 'Ekipman Durum Dağılımı';

    protected function getOptions(): array
    {
        $active = Equipment::where('status', 'active')->count();
        $passive = Equipment::where('status', 'passive')->count();
        $scrapped = Equipment::where('status', 'scrapped')->count();

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [$active, $passive, $scrapped],
            'labels' => ['Aktif', 'Pasif', 'Hurda'],
            'colors' => ['#10b981', '#f59e0b', '#ef4444'],
            'legend' => [
                'position' => 'bottom',
            ],
        ];
    }
}

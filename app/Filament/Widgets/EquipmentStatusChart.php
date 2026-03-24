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
        $tenant = \Filament\Facades\Filament::getTenant();
        if (!$tenant) return [];

        $active = Equipment::where('company_id', $tenant->id)->where('status', 'active')->count();
        $passive = Equipment::where('company_id', $tenant->id)->where('status', 'passive')->count();
        $scrapped = Equipment::where('company_id', $tenant->id)->where('status', 'scrapped')->count();

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

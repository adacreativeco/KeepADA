<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Equipment;
use App\Models\MaintenanceTask;
use Carbon\Carbon;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $tenant = \Filament\Facades\Filament::getTenant();
        if (!$tenant) return [];

        $planName = match ($tenant->plan) {
            'basics' => 'Başlangıç',
            'professional' => 'Profesyonel',
            'enterprise' => 'Kurumsal',
            default => 'Bilinmiyor',
        };

        $slaSuccess = MaintenanceTask::where('company_id', $tenant->id)
            ->where('status', 'done')
            ->whereNotNull('completed_at')
            ->get()
            ->filter(fn ($task) => $task->sla_status === 'İçinde')
            ->count();
        
        $totalDone = MaintenanceTask::where('company_id', $tenant->id)->where('status', 'done')->count();
        $slaRate = $totalDone > 0 ? round(($slaSuccess / $totalDone) * 100) : 100;

        return [
            Stat::make('Aktif Plan', $planName)
                ->description("Limitler: {$tenant->max_locations} Lok / {$tenant->max_equipment} Ekip")
                ->color('primary'),
            Stat::make('SLA Başarı Oranı', "%{$slaRate}")
                ->description('Zamanında tamamlanan bakımlar')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($slaRate > 80 ? 'success' : 'warning'),
            Stat::make('Toplam Ekipman', Equipment::where('company_id', $tenant->id)->count())
                ->description('Sistemdeki toplam varlık')
                ->descriptionIcon('heroicon-m-cog')
                ->color('info'),
            Stat::make('Gecikmiş Bakım', MaintenanceTask::where('company_id', $tenant->id)->where('status', '!=', 'done')->where('scheduled_date', '<', now())->count())
                ->description('Zamanı geçmiş görevler')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}

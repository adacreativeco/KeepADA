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
        $planName = match ($tenant?->plan) {
            'basics' => 'Başlangıç',
            'professional' => 'Profesyonel',
            'enterprise' => 'Kurumsal',
            default => 'Bilinmiyor',
        };

        return [
            Stat::make('Aktif Plan', $planName)
                ->description("Limitler: {$tenant?->max_locations} Lok / {$tenant?->max_equipment} Ekip")
                ->color('primary'),
            Stat::make('Toplam Ekipman', Equipment::count())
                ->description('Sistemdeki toplam varlık')
                ->descriptionIcon('heroicon-m-cog')
                ->color('info'),
            Stat::make('Bu Ay Planlı Bakım', MaintenanceTask::whereMonth('scheduled_date', now()->month)->count())
                ->description('Bu ay yapılması gereken')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
            Stat::make('Gecikmiş Bakım', MaintenanceTask::where('status', '!=', 'done')->where('scheduled_date', '<', now())->count())
                ->description('Zamanı geçmiş görevler')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}

@extends('layouts.panel')

@section('title', __('cmms.dashboard') . ' · ' . config('app.name'))

@section('content')
<div class="space-y-8">

    <!-- Page Header & Quick Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-mono mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                {{ __('cmms.app_tagline') }}
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">{{ __('cmms.performance_summary') }}</h1>
            <p class="text-xs text-slate-400 mt-1">{{ __('cmms.performance_desc') }}</p>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('panel.tasks.create', ['company' => $currentCompany->slug]) }}" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>{{ __('cmms.new_task') }}</span>
            </a>
            <a href="{{ route('panel.equipment.create', ['company' => $currentCompany->slug]) }}" class="w-full sm:w-auto bg-slate-900 border border-slate-800 hover:border-slate-700 text-white font-medium px-4 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2">
                <i data-lucide="cpu" class="w-4 h-4 text-amber-400"></i>
                <span>{{ __('cmms.new_equipment') }}</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Active Equipment -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                    <i data-lucide="cpu" class="w-6 h-6"></i>
                </div>
                <span class="text-[11px] font-mono text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                    %{{ $equipmentCount > 0 ? round(($activeEquipment / $equipmentCount) * 100) : 0 }} {{ __('cmms.active') }}
                </span>
            </div>
            <div class="text-3xl font-extrabold font-mono text-white mb-1">{{ $activeEquipment }} <span class="text-sm text-slate-500 font-normal">/ {{ $equipmentCount }}</span></div>
            <div class="text-xs text-slate-400">{{ __('cmms.registered_assets') }}</div>
        </div>

        <!-- Open Work Orders -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                </div>
                <a href="{{ route('panel.tasks.index', ['company' => $currentCompany->slug]) }}" class="text-[11px] font-mono text-amber-400 hover:underline">{{ __('cmms.view_all') }} →</a>
            </div>
            <div class="text-3xl font-extrabold font-mono text-amber-400 mb-1">{{ $openTasksCount }}</div>
            <div class="text-xs text-slate-400">{{ __('cmms.open_tasks') }}</div>
        </div>

        <!-- Overdue Tasks -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
                @if($overdueTasksCount > 0)
                    <span class="text-[11px] font-mono text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded border border-rose-500/20 animate-pulse">{{ __('cmms.critical') }}</span>
                @else
                    <span class="text-[11px] font-mono text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">{{ __('cmms.done') }}</span>
                @endif
            </div>
            <div class="text-3xl font-extrabold font-mono text-rose-400 mb-1">{{ $overdueTasksCount }}</div>
            <div class="text-xs text-slate-400">{{ __('cmms.overdue_tasks') }}</div>
        </div>

        <!-- Critical Stock -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
                <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug, 'critical_only' => 1]) }}" class="text-[11px] font-mono text-purple-400 hover:underline">{{ __('cmms.order_parts') }} →</a>
            </div>
            <div class="text-3xl font-extrabold font-mono text-purple-400 mb-1">{{ $criticalPartsCount }}</div>
            <div class="text-xs text-slate-400">{{ __('cmms.critical_stock') }}</div>
        </div>

    </div>

    <!-- Charts & Trends Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- 6-Month Maintenance Trends (Chart.js) -->
        <div class="lg:col-span-8 bg-slate-900 border border-slate-800 p-6 rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-white">{{ __('cmms.monthly_trend') }}</h3>
                    <p class="text-xs text-slate-400">Oluşturulan ve tamamlanan iş emirlerinin son 6 aylık karşılaştırması.</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-mono">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-amber-500"></span>
                        <span class="text-slate-300">{{ __('cmms.open_tasks') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded bg-emerald-500"></span>
                        <span class="text-slate-300">{{ __('cmms.done') }}</span>
                    </div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Equipment Status Donut (Chart.js) -->
        <div class="lg:col-span-4 bg-slate-900 border border-slate-800 p-6 rounded-2xl flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-white mb-1">{{ __('cmms.asset_status_dist') }}</h3>
                <p class="text-xs text-slate-400 mb-4">Sistemdeki tüm ekipmanların çalışma durumları.</p>
                <div class="h-48 relative flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-4 border-t border-slate-800 text-center">
                <div class="p-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                    <div class="text-sm font-bold font-mono text-emerald-400">{{ $statusActive }}</div>
                    <div class="text-[10px] text-slate-400">{{ __('cmms.active') }}</div>
                </div>
                <div class="p-2 rounded-xl bg-amber-500/10 border border-amber-500/20">
                    <div class="text-sm font-bold font-mono text-amber-400">{{ $statusMaintenance }}</div>
                    <div class="text-[10px] text-slate-400">{{ __('cmms.under_maintenance') }}</div>
                </div>
                <div class="p-2 rounded-xl bg-rose-500/10 border border-rose-500/20">
                    <div class="text-sm font-bold font-mono text-rose-400">{{ $statusInactive }}</div>
                    <div class="text-[10px] text-slate-400">{{ __('cmms.inactive') }}</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Urgent Tasks & Critical Parts Dual Column -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Urgent / Upcoming Work Orders Table -->
        <div class="lg:col-span-8 bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-white">{{ __('cmms.urgent_tasks') }}</h3>
                    <p class="text-xs text-slate-400">En yakın tarihte yapılması gereken bakım görevleri.</p>
                </div>
                <a href="{{ route('panel.tasks.index', ['company' => $currentCompany->slug]) }}" class="text-xs font-semibold text-amber-400 hover:underline">{{ __('cmms.view_all') }} →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-950/60 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">Görev / Başlık</th>
                            <th class="py-3 px-4">Ekipman</th>
                            <th class="py-3 px-4">Teknisyen</th>
                            <th class="py-3 px-4">Planlanan Tarih</th>
                            <th class="py-3 px-4">{{ __('cmms.priority') }}</th>
                            <th class="py-3 px-4 text-right">İşlem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse($urgentTasks as $task)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 font-semibold text-white">
                                    <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="hover:text-amber-400 transition">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 text-slate-300">
                                    <span class="font-mono text-slate-400">[{{ $task->equipment->code }}]</span> {{ $task->equipment->name }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-300">
                                    {{ $task->assignedUser?->name ?? '—' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-300">
                                    {{ $task->scheduled_date->format('d.m.Y') }}
                                    @if($task->scheduled_date->isPast())
                                        <span class="text-rose-400 font-bold ml-1">(! {{ __('cmms.overdue_tasks') }})</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($task->priority === 'critical')
                                        <span class="px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 font-mono text-[10px] border border-rose-500/20">{{ __('cmms.critical') }}</span>
                                    @elseif($task->priority === 'high')
                                        <span class="px-2 py-0.5 rounded bg-orange-500/10 text-orange-400 font-mono text-[10px] border border-orange-500/20">{{ __('cmms.high') }}</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300 font-mono text-[10px]">{{ __('cmms.medium') }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="text-amber-400 hover:text-amber-300 font-semibold text-xs">
                                        {{ __('cmms.details') }} →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-500 text-xs">
                                    Harika! Bekleyen veya acil bakım görevi bulunmuyor.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Critical Stock Card -->
        <div class="lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-white">{{ __('cmms.critical_stock_warning') }}</h3>
                    <i data-lucide="alert-octagon" class="w-5 h-5 text-purple-400"></i>
                </div>
                <p class="text-xs text-slate-400 mb-4">Minimum seviyenin altına inen yedek parçalar.</p>

                <div class="space-y-3">
                    @forelse($criticalParts as $part)
                        <div class="p-3 rounded-xl bg-slate-950/60 border border-slate-800 flex items-center justify-between">
                            <div>
                                <div class="text-xs font-semibold text-white">{{ $part->name }}</div>
                                <div class="text-[10px] font-mono text-slate-400">Kod: {{ $part->code }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-mono font-bold text-rose-400">{{ $part->stock_quantity }} {{ $part->unit }}</div>
                                <div class="text-[10px] text-slate-500">Min: {{ $part->min_stock }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-500 text-xs">
                            Kritik seviyede yedek parça yok.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 mt-4">
                <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="w-full block text-center py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition">
                    {{ __('cmms.spare_parts') }}
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    // 1. Monthly Trends Bar Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [
                {
                    label: '{{ __("cmms.open_tasks") }}',
                    data: {!! json_encode($createdTrends) !!},
                    backgroundColor: '#f59e0b',
                    borderRadius: 6,
                },
                {
                    label: '{{ __("cmms.done") }}',
                    data: {!! json_encode($completedTrends) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 11 }, precision: 0 }
                }
            }
        }
    });

    // 2. Equipment Status Donut Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['{{ __("cmms.active") }}', '{{ __("cmms.under_maintenance") }}', '{{ __("cmms.inactive") }}'],
            datasets: [{
                data: [{{ $statusActive }}, {{ $statusMaintenance }}, {{ $statusInactive }}],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush

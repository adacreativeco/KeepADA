@extends('layouts.panel')

@section('title', 'Gelişmiş Analitik & Bakım Raporları')

@section('content')
<div class="space-y-8">

    <!-- Page Header & Exports -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-mono mb-2">
                <i data-lucide="bar-chart-3" class="w-3.5 h-3.5"></i>
                <span>Tesis Güvenilirlik &amp; Maliyet Raporları</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Performans &amp; Arıza Analitiği</h1>
            <p class="text-xs text-slate-400 mt-1">MTTR, MTBF, bakım harcamaları ve teknisyen verimlilik dökümü.</p>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('panel.reports.export.tasks', ['company' => $currentCompany->slug]) }}" class="bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-200 font-semibold px-3.5 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                <i data-lucide="download" class="w-4 h-4 text-amber-400"></i>
                <span>İş Emirleri CSV</span>
            </a>
            <a href="{{ route('panel.reports.export.equipment', ['company' => $currentCompany->slug]) }}" class="bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-200 font-semibold px-3.5 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                <i data-lucide="download" class="w-4 h-4 text-blue-400"></i>
                <span>Ekipmanlar CSV</span>
            </a>
            <a href="{{ route('panel.reports.export.inventory', ['company' => $currentCompany->slug]) }}" class="bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-200 font-semibold px-3.5 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-1.5 shadow-sm">
                <i data-lucide="download" class="w-4 h-4 text-purple-400"></i>
                <span>Stok CSV</span>
            </a>
        </div>
    </div>

    <!-- Core Reliability Metrics (MTTR / MTBF) & Spend KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- MTTR (Mean Time to Repair) -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <i data-lucide="timer" class="w-6 h-6"></i>
                </div>
                <span class="text-[10px] font-mono text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">
                    Hedef: &lt; 2.0 Sa
                </span>
            </div>
            <div class="text-3xl font-extrabold font-mono text-white mb-1">
                {{ $mttrHours }} <span class="text-sm font-normal text-slate-400">Saat</span>
            </div>
            <div class="text-xs font-bold text-slate-300">MTTR (Ortalama Onarım Süresi)</div>
            <p class="text-[11px] text-slate-500 mt-1">Arıza başlangıcından çalışır duruma gelene kadar geçen ortalama süre.</p>
        </div>

        <!-- MTBF (Mean Time Between Failures) -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <span class="text-[10px] font-mono text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                    Yüksek Güvenilirlik
                </span>
            </div>
            <div class="text-3xl font-extrabold font-mono text-emerald-400 mb-1">
                {{ number_format($mtbfHours, 0, ',', '.') }} <span class="text-sm font-normal text-slate-400">Saat</span>
            </div>
            <div class="text-xs font-bold text-slate-300">MTBF (İki Arıza Arası Süre)</div>
            <p class="text-[11px] text-slate-500 mt-1">Makinelerin plansız arıza yapmadan kesintisiz çalıştığı ortalama süre.</p>
        </div>

        <!-- Total Corrective Breakdowns -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-3">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                    <i data-lucide="zap-off" class="w-6 h-6"></i>
                </div>
                <span class="text-[10px] font-mono text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded border border-rose-500/20">
                    Plansız Duruş
                </span>
            </div>
            <div class="text-3xl font-extrabold font-mono text-rose-400 mb-1">
                {{ $totalFailuresCount }}
            </div>
            <div class="text-xs font-bold text-slate-300">Toplam Plansız Arıza Sayısı</div>
            <p class="text-[11px] text-slate-500 mt-1">Kayıtlı tüm arızi ve acil müdahale gerektiren bakım çağrıları.</p>
        </div>

        <!-- Total Spend -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl relative overflow-hidden">
            <div class="flex justify-between items-start mb-3">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
                <span class="text-[10px] font-mono text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded border border-purple-500/20">
                    Toplam Bütçe
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold font-mono text-purple-400 mb-1">
                {{ number_format($grandTotalCost, 0, ',', '.') }} <span class="text-xs font-normal text-slate-400">TL</span>
            </div>
            <div class="text-xs font-bold text-slate-300">Kümülatif Bakım Harcaması</div>
            <p class="text-[11px] text-slate-500 mt-1">İşçilik, harici teknik servis ve yedek parça maliyeti toplamı.</p>
        </div>

    </div>

    <!-- Charts Row: Cost Breakdown & Top Failing Equipment -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Cost Breakdown Doughnut -->
        <div class="lg:col-span-5 bg-slate-900 border border-slate-800 p-6 rounded-3xl flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-white mb-1">Maliyet Dağılım Analizi</h3>
                <p class="text-xs text-slate-400 mb-4">Bakım bütçesinin kalemlere göre yüzdesel dağılımı.</p>
                <div class="h-52 relative flex items-center justify-center">
                    <canvas id="costDoughnut"></canvas>
                </div>
            </div>

            <div class="space-y-2 pt-4 border-t border-slate-800 text-xs">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded bg-amber-500"></span>
                        <span class="text-slate-300">İşçilik Giderleri:</span>
                    </div>
                    <span class="font-mono font-bold text-white">{{ number_format($totalLaborCost, 2, ',', '.') }} TL</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded bg-blue-500"></span>
                        <span class="text-slate-300">Dış Servis &amp; Malzeme:</span>
                    </div>
                    <span class="font-mono font-bold text-white">{{ number_format($totalMaterialCost, 2, ',', '.') }} TL</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded bg-purple-500"></span>
                        <span class="text-slate-300">Yedek Parça Sarfiyatı:</span>
                    </div>
                    <span class="font-mono font-bold text-white">{{ number_format($totalSparePartCost, 2, ',', '.') }} TL</span>
                </div>
            </div>
        </div>

        <!-- Top Failing Assets Table & MTTR Leaderboard -->
        <div class="lg:col-span-7 bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-bold text-white">En Çok Duruş Yaşayan Varlıklar</h3>
                        <p class="text-xs text-slate-400">En sık arıza kaydı açılan makinelerin güvenilirlik sıralaması.</p>
                    </div>
                    <i data-lucide="alert-octagon" class="w-5 h-5 text-rose-400"></i>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-950 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                            <tr>
                                <th class="py-3 px-3">Ekipman Kodu</th>
                                <th class="py-3 px-3">Ekipman Tanımı</th>
                                <th class="py-3 px-3">Lokasyon</th>
                                <th class="py-3 px-3 text-right">Arıza Adedi</th>
                                <th class="py-3 px-3 text-right">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($topFailingEquipment as $eq)
                                <tr class="hover:bg-slate-800/40 transition">
                                    <td class="py-3 px-3 font-mono font-bold text-amber-400">{{ $eq->code }}</td>
                                    <td class="py-3 px-3 font-semibold text-white">{{ $eq->name }}</td>
                                    <td class="py-3 px-3 text-slate-300">{{ $eq->location?->name ?? '—' }}</td>
                                    <td class="py-3 px-3 font-mono font-bold text-rose-400 text-right">
                                        {{ $eq->maintenance_tasks_count }} Arıza
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <a href="{{ route('panel.equipment.show', ['company' => $currentCompany->slug, 'equipment' => $eq->id]) }}" class="text-amber-400 hover:text-amber-300 text-xs font-semibold">
                                            İncele →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-500">
                                        Tebrikler! Kayıtlı arızalı ekipman bulunmuyor.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-800 text-xs text-slate-500 font-mono flex items-center justify-between">
                <span>Periyodik bakımı düzenli yapılan makinelerde arıza oranı %70 daha düşüktür.</span>
            </div>
        </div>

    </div>

    <!-- Technician Productivity Scorecard -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h3 class="text-base font-bold text-white">Teknisyen Performans Karnesi</h3>
                <p class="text-xs text-slate-400 mt-0.5">Bakım ekibinin iş tamamlama ve zamanında bitirme oranları.</p>
            </div>
            <a href="{{ route('panel.team.index', ['company' => $currentCompany->slug]) }}" class="text-xs font-semibold text-amber-400 hover:underline">
                Ekibi Yönet →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Teknisyen / Personel</th>
                        <th class="py-3.5 px-4 text-center">Toplam Görev</th>
                        <th class="py-3.5 px-4 text-center">Tamamlanan</th>
                        <th class="py-3.5 px-4 text-center">Devam Eden</th>
                        <th class="py-3.5 px-4 text-center">Bekleyen</th>
                        <th class="py-3.5 px-4">Başarı / Tamamlama Oranı</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($technicians as $tech)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-bold text-white">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($tech['user']->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div>{{ $tech['user']->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono font-normal">{{ $tech['user']->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-center text-slate-200">{{ $tech['total_tasks'] }}</td>
                            <td class="py-3.5 px-4 font-mono font-bold text-center text-emerald-400">{{ $tech['completed'] }}</td>
                            <td class="py-3.5 px-4 font-mono font-bold text-center text-blue-400">{{ $tech['in_progress'] }}</td>
                            <td class="py-3.5 px-4 font-mono font-bold text-center text-amber-400">{{ $tech['pending'] }}</td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-slate-950 rounded-full h-2 overflow-hidden border border-slate-800">
                                        <div class="bg-gradient-to-r from-amber-500 to-emerald-400 h-full rounded-full" style="width: {{ $tech['on_time_rate'] }}%"></div>
                                    </div>
                                    <span class="font-mono font-bold text-xs text-slate-200 min-w-[40px] text-right">%{{ $tech['on_time_rate'] }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Kayıtlı teknisyen bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const costCtx = document.getElementById('costDoughnut').getContext('2d');
    new Chart(costCtx, {
        type: 'doughnut',
        data: {
            labels: ['İşçilik', 'Dış Servis/Malzeme', 'Yedek Parça'],
            datasets: [{
                data: [{{ $totalLaborCost }}, {{ $totalMaterialCost }}, {{ $totalSparePartCost }}],
                backgroundColor: ['#f59e0b', '#3b82f6', '#a855f7'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush

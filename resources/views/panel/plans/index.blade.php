@extends('layouts.panel')

@section('title', 'Periyodik Bakım Planları')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Periyodik Bakım Planları</h1>
            <p class="text-xs text-slate-400 mt-1">Belirli zaman veya sayaç aralıklarında otomatik iş emri üreten kurallar.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <form action="{{ route('panel.plans.trigger', ['company' => $currentCompany->slug]) }}" method="POST">
                @csrf
                <button type="submit" class="bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-200 font-semibold px-4 py-2.5 rounded-xl text-xs transition flex items-center gap-2 shadow-sm" title="Vadesi gelen tüm planları şimdi kontrol et ve görevleri aç">
                    <i data-lucide="play-circle" class="w-4 h-4 text-amber-400"></i>
                    <span>Planları Şimdi Çalıştır</span>
                </button>
            </form>
            <a href="{{ route('panel.plans.create', ['company' => $currentCompany->slug]) }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Yeni Plan Tanımla</span>
            </a>
        </div>
    </div>

    <!-- Plans Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Plan Başlığı</th>
                        <th class="py-3.5 px-4">İlgili Ekipman</th>
                        <th class="py-3.5 px-4">Sıklık / Periyot</th>
                        <th class="py-3.5 px-4">Sorumlu Teknisyen</th>
                        <th class="py-3.5 px-4">Sonraki Bakım</th>
                        <th class="py-3.5 px-4">Hedef SLA</th>
                        <th class="py-3.5 px-4">Durum</th>
                        <th class="py-3.5 px-4 text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($plans as $plan)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-bold text-white">
                                <a href="{{ route('panel.plans.edit', ['company' => $currentCompany->slug, 'plan' => $plan->id]) }}" class="hover:text-amber-400">
                                    {{ $plan->title }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300">
                                <span class="font-mono text-amber-400/80">[{{ $plan->equipment->code }}]</span> {{ $plan->equipment->name }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-300">
                                Her {{ $plan->frequency_value }} {{ ucfirst($plan->frequency_type) }}
                                @if($plan->meter_interval)
                                    <div class="text-[10px] text-amber-400 font-normal">({{ $plan->meter_interval }} {{ $plan->equipment->meter_unit }} aralıkla)</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-300">{{ $plan->assignedUser?->name ?? '—' }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-200 font-bold">
                                {{ $plan->next_due_date?->format('d.m.Y') }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-400">
                                {{ $plan->sla_hours ? $plan->sla_hours . ' Saat' : '—' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($plan->is_active)
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-[10px] border border-emerald-500/20">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-400 font-mono text-[10px]">
                                        Devre Dışı
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('panel.plans.edit', ['company' => $currentCompany->slug, 'plan' => $plan->id]) }}" class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition inline-block">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500">
                                Tanımlı periyodik bakım planı bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($plans->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $plans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

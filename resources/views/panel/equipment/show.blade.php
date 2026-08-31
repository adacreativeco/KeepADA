@extends('layouts.panel')

@section('title', $equipment->name . ' · Detay & Bakım Karnesi')

@section('content')
<div class="space-y-8" x-data="{ meterModalOpen: false }">

    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <span class="font-mono text-sm font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-3 py-1 rounded-lg">
                    {{ $equipment->code }}
                </span>
                @if($equipment->status === 'active')
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-xs border border-emerald-500/20 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Aktif / Çalışıyor
                    </span>
                @elseif($equipment->status === 'under_maintenance')
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 font-mono text-xs border border-amber-500/20 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> Bakımda
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full bg-rose-500/10 text-rose-400 font-mono text-xs border border-rose-500/20">
                        Pasif
                    </span>
                @endif
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">{{ $equipment->name }}</h1>
            <p class="text-xs text-slate-400 mt-1">{{ $equipment->brand }} {{ $equipment->model }} &bull; Lokasyon: {{ $equipment->location?->name ?? 'Belirtilmedi' }}</p>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('panel.equipment.print-label', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" target="_blank" class="w-full sm:w-auto bg-slate-900 border border-slate-800 hover:border-slate-700 text-white font-medium px-3.5 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2" title="Makine üzerine yapıştırılacak endüstriyel QR etiketini yazdır">
                <i data-lucide="tag" class="w-4 h-4 text-amber-400"></i>
                <span>QR Etiket Bas</span>
            </a>
            <button type="button" @click="meterModalOpen = true" class="w-full sm:w-auto bg-slate-900 border border-slate-800 hover:border-slate-700 text-white font-medium px-3.5 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2">
                <i data-lucide="gauge" class="w-4 h-4 text-blue-400"></i>
                <span>Sayaç Girişi</span>
            </button>
            <a href="{{ route('panel.tasks.create', ['company' => $currentCompany->slug, 'equipment_id' => $equipment->id]) }}" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>İş Emri Aç</span>
            </a>
            <a href="{{ route('panel.equipment.edit', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" class="p-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-xl text-slate-300 hover:text-white transition">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Smart KPI & AI Predictive Banner -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Predictive AI Maintenance Forecast -->
        <div class="md:col-span-2 bg-gradient-to-br from-slate-900 via-slate-900 to-amber-950/30 border border-amber-500/30 p-6 rounded-3xl relative overflow-hidden flex flex-col justify-between">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-mono mb-3">
                    <i data-lucide="brain-circuit" class="w-3.5 h-3.5"></i>
                    <span>Akıllı Bakım Tahminleme Motoru</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Tahmini Bir Sonraki Bakım İhtiyacı</h3>
                <p class="text-xs text-slate-400 leading-relaxed max-w-xl">
                    Geçmiş bakım sıklığı ve sayaç çalışma temposu analiz edilerek hesaplanan olası arıza/periyodik bakım tarihi:
                </p>
            </div>

            <div class="flex items-end justify-between pt-6 mt-4 border-t border-slate-800/80">
                <div>
                    <div class="text-2xl font-mono font-extrabold text-amber-400">
                        {{ $equipment->predictive_next_due_date ? $equipment->predictive_next_due_date->format('d F Y') : 'Yeterli veri yok' }}
                    </div>
                    <div class="text-[11px] text-slate-500 font-mono">
                        @if($equipment->predictive_next_due_date)
                            {{ $equipment->predictive_next_due_date->diffForHumans() }}
                        @else
                            Minimum 2 tamamlanmış bakım gereklidir.
                        @endif
                    </div>
                </div>

                <a href="{{ route('equipment.public-show', $equipment->code) }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-950/80 border border-slate-800 hover:border-amber-400/50 text-xs font-semibold text-slate-200 hover:text-white transition flex items-center gap-2">
                    <i data-lucide="qr-code" class="w-4 h-4 text-amber-400"></i>
                    <span>Dijital QR Karne</span>
                </a>
            </div>
        </div>

        <!-- Meter Reading Status Card -->
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="text-xs font-mono text-slate-400 uppercase">Sayaç Bilgisi</div>
                    <i data-lucide="gauge" class="w-5 h-5 text-blue-400"></i>
                </div>
                <div class="text-3xl font-extrabold font-mono text-white mb-1">
                    {{ $equipment->current_meter_reading ? number_format($equipment->current_meter_reading, 0, ',', '.') : '0' }}
                    <span class="text-sm font-normal text-slate-400">{{ $equipment->meter_unit ?: 'saat' }}</span>
                </div>
                <p class="text-xs text-slate-500 mt-2">Sayaç eşiği aşıldığında otomatik iş emri tetiklenir.</p>
            </div>

            <div class="pt-4 border-t border-slate-800">
                <button type="button" @click="meterModalOpen = true" class="w-full text-center py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition">
                    + Sayaç Değeri Gir
                </button>
            </div>
        </div>

    </div>

    <!-- Details Specs Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Specs Info -->
        <div class="lg:col-span-1 bg-slate-900 border border-slate-800 p-6 rounded-3xl space-y-4">
            <h3 class="text-base font-bold text-white pb-3 border-b border-slate-800">Teknik Özellikler</h3>
            
            <div class="space-y-3 text-xs">
                <div class="flex justify-between">
                    <span class="text-slate-400">Kategori:</span>
                    <span class="text-white font-medium">{{ $equipment->category ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Marka / Model:</span>
                    <span class="text-white font-medium">{{ $equipment->brand ?? '—' }} {{ $equipment->model ?? '' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Seri Numarası:</span>
                    <span class="text-white font-mono">{{ $equipment->serial_number ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Lokasyon / Tesis:</span>
                    <span class="text-white font-medium">{{ $equipment->location?->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Yetkili Servis:</span>
                    <span class="text-white font-medium">{{ $equipment->supplier?->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Satın Alma Tarihi:</span>
                    <span class="text-white font-mono">{{ $equipment->purchase_date?->format('d.m.Y') ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Garanti Bitişi:</span>
                    <span class="text-white font-mono">{{ $equipment->warranty_end_date?->format('d.m.Y') ?? '—' }}</span>
                </div>
            </div>

            @if($equipment->notes)
                <div class="pt-4 border-t border-slate-800">
                    <div class="text-[11px] font-mono uppercase text-slate-400 mb-1">Notlar</div>
                    <p class="text-xs text-slate-300 leading-relaxed">{{ $equipment->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Maintenance History & Open Tasks Tabs -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Active Maintenance Plans -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-bold text-white">Tanımlı Bakım Planları</h3>
                    <a href="{{ route('panel.plans.create', ['company' => $currentCompany->slug, 'equipment_id' => $equipment->id]) }}" class="text-xs text-amber-400 hover:underline font-semibold">+ Plan Ekle</a>
                </div>

                <div class="space-y-3">
                    @forelse($equipment->maintenancePlans as $plan)
                        <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold text-white">{{ $plan->title }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    Periyot: <strong class="text-slate-300 font-mono">{{ $plan->frequency_value }} {{ $plan->frequency_type }}</strong>
                                    &bull; Atanan: {{ $plan->assignedUser?->name ?? 'Otomatik' }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-mono text-amber-400 font-bold">Sonraki: {{ $plan->next_due_date?->format('d.m.Y') }}</div>
                                <div class="text-[11px] text-slate-500">SLA: {{ $plan->sla_hours }} Saat</div>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-slate-500 text-xs">
                            Bu ekipmana ait aktif periyodik bakım planı tanımlanmamış.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Maintenance Tasks / History -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-bold text-white">İş Emirleri &amp; Servis Geçmişi</h3>
                    <a href="{{ route('panel.tasks.create', ['company' => $currentCompany->slug, 'equipment_id' => $equipment->id]) }}" class="text-xs text-amber-400 hover:underline font-semibold">+ İş Emri Aç</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-950/60 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                            <tr>
                                <th class="py-2.5 px-3">Görev</th>
                                <th class="py-2.5 px-3">Teknisyen</th>
                                <th class="py-2.5 px-3">Tarih</th>
                                <th class="py-2.5 px-3">Durum</th>
                                <th class="py-2.5 px-3 text-right">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($equipment->maintenanceTasks as $task)
                                <tr class="hover:bg-slate-800/40">
                                    <td class="py-3 px-3 font-semibold text-white">
                                        <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="hover:text-amber-400">
                                            {{ $task->title }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-3 text-slate-300">{{ $task->assignedUser?->name ?? '—' }}</td>
                                    <td class="py-3 px-3 font-mono text-slate-300">{{ $task->scheduled_date->format('d.m.Y') }}</td>
                                    <td class="py-3 px-3">
                                        @if($task->status === 'done')
                                            <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 font-mono text-[10px] border border-emerald-500/20">Tamamlandı</span>
                                        @elseif($task->status === 'in_progress')
                                            <span class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-400 font-mono text-[10px] border border-blue-500/20">Devam Ediyor</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 font-mono text-[10px] border border-amber-500/20">Bekliyor</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="text-amber-400 hover:text-amber-300 font-semibold text-xs">
                                            Detay →
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-slate-500">
                                        Henüz bu ekipmana ait bakım görevi açılmamış.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <!-- Modal: Add Meter Reading -->
    <div x-show="meterModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="meterModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-bold text-white">Yeni Sayaç Değeri Ekle</h3>
                    <button type="button" @click="meterModalOpen = false" class="text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('panel.equipment.meter', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Yeni Sayaç Değeri ({{ $equipment->meter_unit ?: 'saat' }}) *</label>
                        <input type="number" step="0.01" name="reading_value" value="{{ $equipment->current_meter_reading }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Okuma Tarihi *</label>
                        <input type="date" name="reading_date" value="{{ date('Y-m-d') }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Notlar</label>
                        <input type="text" name="notes" placeholder="Vardiya sonu okuması, arıza sonrası..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="meterModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-800 text-slate-300 text-xs font-semibold">
                            İptal
                        </button>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-5 py-2 rounded-xl text-xs">
                            Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@extends('layouts.panel')

@section('title', 'İş Emri #' . $task->id . ' · ' . $task->title)

@section('content')
<div class="space-y-8" x-data="{ partModalOpen: false }">

    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="font-mono text-xs font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-3 py-1 rounded-lg">
                    İş Emri #{{ $task->id }}
                </span>
                
                @if($task->status === 'done')
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-xs border border-emerald-500/20 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Tamamlandı
                    </span>
                @elseif($task->status === 'in_progress')
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-500/10 text-blue-400 font-mono text-xs border border-blue-500/20 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span> Devam Ediyor
                    </span>
                @elseif($task->status === 'cancelled')
                    <span class="px-2.5 py-0.5 rounded-full bg-rose-500/10 text-rose-400 font-mono text-xs border border-rose-500/20">
                        İptal Edildi
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/10 text-amber-400 font-mono text-xs border border-amber-500/20">
                        Bekliyor
                    </span>
                @endif

                @if($task->priority === 'critical')
                    <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-400 font-mono text-[11px] font-bold">Kritik Öncelik</span>
                @elseif($task->priority === 'high')
                    <span class="px-2 py-0.5 rounded bg-orange-500/20 text-orange-400 font-mono text-[11px]">Yüksek Öncelik</span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">{{ $task->title }}</h1>
            <p class="text-xs text-slate-400 mt-1">
                Ekipman: <a href="{{ route('panel.equipment.show', ['company' => $currentCompany->slug, 'equipment' => $task->equipment_id]) }}" class="text-amber-400 hover:underline font-semibold font-mono">[{{ $task->equipment->code }}] {{ $task->equipment->name }}</a>
                &bull; Planlanan Tarih: <span class="font-mono text-slate-300">{{ $task->scheduled_date->format('d F Y') }}</span>
            </p>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <button onclick="window.print()" class="p-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-xl text-slate-300 hover:text-white transition" title="Yazdır / PDF">
                <i data-lucide="printer" class="w-4 h-4"></i>
            </button>
            <a href="{{ route('panel.tasks.edit', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="p-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-xl text-slate-300 hover:text-white transition">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
            </a>
        </div>
    </div>

    <!-- Quick Status Changer Action Bar -->
    <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs text-slate-300">
            <strong>Durum Değiştir:</strong> Sahadaki operasyon durumuna göre iş emrini güncelleyin.
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            @if($task->status !== 'in_progress' && $task->status !== 'done')
                <form action="{{ route('panel.tasks.status', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" method="POST" class="flex-1 sm:flex-none">
                    @csrf
                    <input type="hidden" name="status" value="in_progress">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-lg shadow-blue-600/20">
                        <i data-lucide="play" class="w-3.5 h-3.5"></i>
                        <span>İşe Başla</span>
                    </button>
                </form>
            @endif

            @if($task->status !== 'done')
                <form action="{{ route('panel.tasks.status', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" method="POST" class="flex-1 sm:flex-none">
                    @csrf
                    <input type="hidden" name="status" value="done">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition flex items-center justify-center gap-1.5 shadow-lg shadow-emerald-600/20">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        <span>Görevi Tamamla</span>
                    </button>
                </form>
            @endif

            @if($task->status !== 'cancelled' && $task->status !== 'done')
                <form action="{{ route('panel.tasks.status', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" method="POST" class="flex-1 sm:flex-none">
                    @csrf
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="w-full sm:w-auto px-3 py-2 rounded-xl bg-slate-800 hover:bg-rose-900/40 text-slate-400 hover:text-rose-300 font-semibold text-xs transition">
                        İptal Et
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Main Dual Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Task Specs & Description -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Description & Checklist -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl">
                <h3 class="text-base font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-amber-400"></i>
                    <span>Bakım Talimatları &amp; Notlar</span>
                </h3>
                <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800/80 text-xs text-slate-300 whitespace-pre-line leading-relaxed font-sans min-h-[100px]">
                    {{ $task->notes ?: 'Özel bir talimat veya açıklama girilmemiş.' }}
                </div>
            </div>

            <!-- Spare Parts Used & Allocation -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-base font-bold text-white flex items-center gap-2">
                            <i data-lucide="package" class="w-4 h-4 text-amber-400"></i>
                            <span>Kullanılan Yedek Parçalar</span>
                        </h3>
                        <p class="text-xs text-slate-400">Bu iş emrinde harcanan parçalar otomatik stoktan düşülür.</p>
                    </div>
                    <button type="button" @click="partModalOpen = true" class="px-3 py-1.5 rounded-xl bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 text-xs font-bold transition flex items-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                        <span>Parça Ekle</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-950 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                            <tr>
                                <th class="py-2.5 px-3">Parça Kodu</th>
                                <th class="py-2.5 px-3">Parça Adı</th>
                                <th class="py-2.5 px-3">Harcanan Miktar</th>
                                <th class="py-2.5 px-3">Birim Fiyat</th>
                                <th class="py-2.5 px-3 text-right">Tutar</th>
                                <th class="py-2.5 px-3 text-right">İşlem</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @forelse($task->spareParts as $part)
                                <tr>
                                    <td class="py-3 px-3 font-mono text-amber-400">{{ $part->code }}</td>
                                    <td class="py-3 px-3 font-semibold text-white">{{ $part->name }}</td>
                                    <td class="py-3 px-3 font-mono text-slate-300">{{ $part->pivot->quantity_used }} {{ $part->unit }}</td>
                                    <td class="py-3 px-3 font-mono text-slate-300">{{ number_format($part->unit_cost, 2, ',', '.') }} TL</td>
                                    <td class="py-3 px-3 font-mono text-slate-200 font-bold text-right">
                                        {{ number_format($part->pivot->quantity_used * $part->unit_cost, 2, ',', '.') }} TL
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <form action="{{ route('panel.tasks.parts.remove', ['company' => $currentCompany->slug, 'task' => $task->id, 'sparePart' => $part->id]) }}" method="POST" onsubmit="return confirm('Bu parçayı görevden çıkarmak ve stoğa iade etmek istiyor musunuz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                                                Çıkar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-slate-500">
                                        Henüz bu görev için yedek parça harcanmadı.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column: Specs, SLA & Cost Cards -->
        <div class="space-y-6">
            
            <!-- Timing & SLA Card -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl space-y-4">
                <h3 class="text-base font-bold text-white pb-3 border-b border-slate-800">Süre &amp; SLA Durumu</h3>
                
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Planlanan Tarih:</span>
                        <span class="text-white font-mono">{{ $task->scheduled_date->format('d.m.Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Başlangıç Zamanı:</span>
                        <span class="text-white font-mono">{{ $task->started_at?->format('d.m.Y H:i') ?? 'Başlanmadı' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Tamamlanma Zamanı:</span>
                        <span class="text-white font-mono">{{ $task->completed_at?->format('d.m.Y H:i') ?? 'Devam ediyor' }}</span>
                    </div>
                    @if($task->plan && $task->plan->sla_hours)
                        <div class="flex justify-between items-center pt-2 border-t border-slate-800">
                            <span class="text-slate-400">Hedef SLA Süresi:</span>
                            <span class="text-amber-400 font-mono font-bold">{{ $task->plan->sla_hours }} Saat</span>
                        </div>
                        @if($task->sla_status)
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400">SLA Uyumu:</span>
                                @if($task->sla_status === 'İçinde')
                                    <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 font-mono text-[10px] font-bold border border-emerald-500/20">Zamanında Bitti</span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 font-mono text-[10px] font-bold border border-rose-500/20">Gecikti</span>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Cost Breakdown Card -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl space-y-4">
                <h3 class="text-base font-bold text-white pb-3 border-b border-slate-800">Maliyet Dökümü</h3>
                
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-slate-400">
                        <span>İşçilik Maliyeti:</span>
                        <span class="font-mono text-slate-200">{{ number_format($task->labor_cost ?: 0, 2, ',', '.') }} TL</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Malzeme / Dış Hizmet:</span>
                        <span class="font-mono text-slate-200">{{ number_format($task->material_cost ?: 0, 2, ',', '.') }} TL</span>
                    </div>
                    <div class="flex justify-between text-slate-400">
                        <span>Yedek Parça Toplamı:</span>
                        <span class="font-mono text-slate-200">
                            {{ number_format($task->spareParts->sum(fn($p) => $p->pivot->quantity_used * $p->unit_cost), 2, ',', '.') }} TL
                        </span>
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-slate-800 text-sm font-bold">
                        <span class="text-white">Toplam Görev Maliyeti:</span>
                        <span class="font-mono text-amber-400 text-base">{{ number_format($task->total_cost, 2, ',', '.') }} TL</span>
                    </div>
                </div>
            </div>

            <!-- Technician Profile Card -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl">
                <div class="text-xs font-mono text-slate-400 uppercase mb-3">Sorumlu Teknisyen</div>
                @if($task->assignedUser)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $task->assignedUser->name }}</div>
                            <div class="text-xs text-slate-400">{{ $task->assignedUser->email }}</div>
                        </div>
                    </div>
                @else
                    <div class="text-xs text-slate-500">Henüz teknisyen atanmamış.</div>
                @endif
            </div>

        </div>

    </div>

    <!-- Modal: Add Spare Part Allocation -->
    <div x-show="partModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="partModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-base font-bold text-white">Göreve Yedek Parça Ekle</h3>
                    <button type="button" @click="partModalOpen = false" class="text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form action="{{ route('panel.tasks.parts.add', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Yedek Parça Seçiniz *</label>
                        <select name="spare_part_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="">Seçiniz...</option>
                            @foreach($spareParts as $sp)
                                <option value="{{ $sp->id }}">
                                    [{{ $sp->code }}] {{ $sp->name }} (Mevcut Stok: {{ $sp->stock_quantity }} {{ $sp->unit }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Kullanılan Miktar *</label>
                        <input type="number" step="0.01" min="0.01" name="quantity" value="1" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="partModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-800 text-slate-300 text-xs font-semibold">
                            İptal
                        </button>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-5 py-2 rounded-xl text-xs">
                            Stoğu Düş &amp; Göreve Ekle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

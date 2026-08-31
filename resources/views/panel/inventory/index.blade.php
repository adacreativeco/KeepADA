@extends('layouts.panel')

@section('title', 'Yedek Parça & Depo Envanteri')

@section('content')
<div class="space-y-6" x-data="{ adjustModalOpen: false, activePart: null, activePartName: '', activePartUnit: '' }">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Yedek Parça &amp; Depo Yönetimi</h1>
            <p class="text-xs text-slate-400 mt-1">Stok seviyeleri, minimum güvenlik eşikleri ve parça hareket geçmişi.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('panel.inventory.transactions', ['company' => $currentCompany->slug]) }}" class="bg-slate-900 border border-slate-800 hover:border-slate-700 text-white font-medium px-4 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-amber-400"></i>
                <span>Stok Hareket Geçmişi</span>
            </a>
            <a href="{{ route('panel.inventory.create', ['company' => $currentCompany->slug]) }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Yeni Parça Tanımla</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl">
        <form method="GET" action="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            
            <div class="sm:col-span-2 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Parça adı veya parça kodu ara..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-xs text-white placeholder-slate-500 focus:border-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="flex items-center gap-2 h-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-xs text-slate-300 cursor-pointer">
                    <input type="checkbox" name="critical_only" value="1" {{ request('critical_only') ? 'checked' : '' }} onchange="this.form.submit()" class="accent-amber-400 rounded">
                    <span>Yalnızca Kritik Stoklar</span>
                </label>
            </div>

            <div>
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-2 rounded-xl text-xs transition">
                    Filtrele
                </button>
            </div>

        </form>
    </div>

    <!-- Inventory Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Parça Kodu</th>
                        <th class="py-3.5 px-4">Parça Adı</th>
                        <th class="py-3.5 px-4">Tedarikçi</th>
                        <th class="py-3.5 px-4">Mevcut Stok</th>
                        <th class="py-3.5 px-4">Min. Stok</th>
                        <th class="py-3.5 px-4">Birim Fiyat</th>
                        <th class="py-3.5 px-4">Durum</th>
                        <th class="py-3.5 px-4 text-right">İşlem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($parts as $part)
                        @php
                            $isCritical = $part->stock_quantity <= $part->min_stock;
                        @endphp
                        <tr class="hover:bg-slate-800/40 transition {{ $isCritical ? 'bg-rose-500/5' : '' }}">
                            <td class="py-3.5 px-4 font-mono font-bold text-amber-400">{{ $part->code }}</td>
                            <td class="py-3.5 px-4 font-bold text-white">
                                <a href="{{ route('panel.inventory.edit', ['company' => $currentCompany->slug, 'inventory' => $part->id]) }}" class="hover:text-amber-400">
                                    {{ $part->name }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300">{{ $part->supplier?->name ?? '—' }}</td>
                            <td class="py-3.5 px-4 font-mono font-bold {{ $isCritical ? 'text-rose-400' : 'text-emerald-400' }}">
                                {{ $part->stock_quantity }} {{ $part->unit }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-400">
                                {{ $part->min_stock }} {{ $part->unit }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-300">
                                {{ number_format($part->unit_cost, 2, ',', '.') }} TL
                            </td>
                            <td class="py-3.5 px-4">
                                @if($isCritical)
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-500/10 text-rose-400 font-mono text-[10px] border border-rose-500/20 flex items-center gap-1 w-max">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400 animate-pulse"></span> Kritik Stok
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-[10px] border border-emerald-500/20 w-max">
                                        Yeterli
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" @click="activePart = '{{ $part->id }}'; activePartName = '{{ $part->name }}'; activePartUnit = '{{ $part->unit }}'; adjustModalOpen = true" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-amber-400 text-xs font-semibold transition" title="Stok Giriş/Çıkış Yap">
                                        ± Stok
                                    </button>
                                    <a href="{{ route('panel.inventory.edit', ['company' => $currentCompany->slug, 'inventory' => $part->id]) }}" class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500">
                                Tanımlı yedek parça bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($parts->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $parts->links() }}
            </div>
        @endif
    </div>

    <!-- Modal: Stock Adjustment -->
    <div x-show="adjustModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="adjustModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-base font-bold text-white">Stok Hareketi İşle</h3>
                        <p class="text-xs text-amber-400 font-semibold" x-text="activePartName"></p>
                    </div>
                    <button type="button" @click="adjustModalOpen = false" class="text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <form :action="'{{ url('panel/' . $currentCompany->slug . '/inventory') }}/' + activePart + '/adjust'" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Hareket Türü *</label>
                        <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="in">Stok Girişi (Gelen Satın Alma / İade)</option>
                            <option value="out">Manuel Stok Çıkışı (Hurda / Fire)</option>
                            <option value="adjustment">Sayım Düzeltmesi (Adjustment)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Miktar (<span x-text="activePartUnit"></span>) *</label>
                        <input type="number" step="0.01" min="0.01" name="quantity" value="1" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Açıklama / Fatura / İrsaliye No</label>
                        <input type="text" name="notes" placeholder="İrsaliye #1234 veya Yıllık Sayım..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="adjustModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-800 text-slate-300 text-xs font-semibold">
                            İptal
                        </button>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-5 py-2 rounded-xl text-xs">
                            Hareketi Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

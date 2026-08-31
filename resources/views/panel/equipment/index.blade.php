@extends('layouts.panel')

@section('title', 'Ekipmanlar & Tesis Varlıkları')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Ekipman ve Varlık Envanteri</h1>
            <p class="text-xs text-slate-400 mt-1">Tesisinizdeki tüm makineler, hatlar, panolar ve sayaç takibi.</p>
        </div>
        <a href="{{ route('panel.equipment.create', ['company' => $currentCompany->slug]) }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Yeni Ekipman Kaydet</span>
        </a>
    </div>

    <!-- Search & Filters -->
    <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl">
        <form method="GET" action="{{ route('panel.equipment.index', ['company' => $currentCompany->slug]) }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            
            <div class="sm:col-span-2 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ekipman adı, kodu, marka, seri no ara..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-xs text-white placeholder-slate-500 focus:border-amber-400 focus:outline-none">
            </div>

            <div>
                <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none" onchange="this.form.submit()">
                    <option value="">Tüm Durumlar</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="under_maintenance" {{ request('status') === 'under_maintenance' ? 'selected' : '' }}>Bakımda</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Pasif</option>
                    <option value="scrapped" {{ request('status') === 'scrapped' ? 'selected' : '' }}>Hurda</option>
                </select>
            </div>

            <div>
                <select name="location_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none" onchange="this.form.submit()">
                    <option value="">Tüm Lokasyonlar</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                    @endforeach
                </select>
            </div>

        </form>
    </div>

    <!-- Equipment Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($equipmentList as $eq)
            <div class="bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-2xl p-6 transition flex flex-col justify-between group">
                <div>
                    
                    <!-- Status & Code Header -->
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <span class="font-mono text-xs font-bold text-amber-400 bg-amber-500/10 border border-amber-500/20 px-2.5 py-1 rounded-lg">
                            {{ $eq->code }}
                        </span>
                        @if($eq->status === 'active')
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-[10px] border border-emerald-500/20 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                            </span>
                        @elseif($eq->status === 'under_maintenance')
                            <span class="px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-400 font-mono text-[10px] border border-amber-500/20 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Bakımda
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-rose-500/10 text-rose-400 font-mono text-[10px] border border-rose-500/20">
                                Pasif
                            </span>
                        @endif
                    </div>

                    <!-- Title & Details -->
                    <h3 class="text-lg font-bold text-white mb-1 group-hover:text-amber-300 transition">
                        <a href="{{ route('panel.equipment.show', ['company' => $currentCompany->slug, 'equipment' => $eq->id]) }}">
                            {{ $eq->name }}
                        </a>
                    </h3>
                    <div class="text-xs text-slate-400 mb-4">{{ $eq->brand }} {{ $eq->model }}</div>

                    <!-- Specs list -->
                    <div class="space-y-2 text-xs border-t border-slate-800/80 pt-3 text-slate-400 font-mono">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Lokasyon:</span>
                            <span class="text-slate-300">{{ $eq->location?->name ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kategori:</span>
                            <span class="text-slate-300">{{ $eq->category ?? 'Genel' }}</span>
                        </div>
                        @if($eq->current_meter_reading)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Sayaç:</span>
                                <span class="text-amber-400 font-bold">{{ $eq->current_meter_reading }} {{ $eq->meter_unit }}</span>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-4 mt-4 border-t border-slate-800 flex items-center justify-between">
                    <a href="{{ route('equipment.public-show', $eq->code) }}" target="_blank" class="text-[11px] text-slate-400 hover:text-white flex items-center gap-1 font-mono">
                        <i data-lucide="qr-code" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>QR Pasaport</span>
                    </a>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('panel.equipment.edit', ['company' => $currentCompany->slug, 'equipment' => $eq->id]) }}" class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('panel.equipment.show', ['company' => $currentCompany->slug, 'equipment' => $eq->id]) }}" class="bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 font-bold px-3 py-1 rounded-lg text-xs transition">
                            İncele →
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-3 py-16 text-center bg-slate-900 border border-slate-800 rounded-3xl text-slate-400">
                <i data-lucide="cpu" class="w-12 h-12 text-slate-600 mx-auto mb-3"></i>
                <div class="text-base font-bold text-white">Kayıtlı Ekipman Bulunamadı</div>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">Arama kriterlerinize uyan ekipman yok veya henüz ekipman kaydetmediniz.</p>
                <a href="{{ route('panel.equipment.create', ['company' => $currentCompany->slug]) }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2 rounded-xl text-xs">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>İlk Ekipmanı Ekle</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $equipmentList->links() }}
    </div>

</div>
@endsection

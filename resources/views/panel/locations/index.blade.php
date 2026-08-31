@extends('layouts.panel')

@section('title', 'Tesis Lokasyonları & Binalar')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Tesis Lokasyonları &amp; Bölümler</h1>
            <p class="text-xs text-slate-400 mt-1">Fabrika binaları, üretim hatları, atölyeler ve sahalar.</p>
        </div>
        <a href="{{ route('panel.locations.create', ['company' => $currentCompany->slug]) }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Yeni Lokasyon Ekle</span>
        </a>
    </div>

    <!-- Locations Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($locations as $loc)
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 flex flex-col justify-between hover:border-slate-700 transition group">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 font-mono text-[10px]">
                            {{ $loc->equipment_count }} Ekipman
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-white mb-2 group-hover:text-amber-400 transition">{{ $loc->name }}</h3>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">{{ $loc->address ?: 'Adres belirtilmemiş.' }}</p>

                    @if($loc->contact_name || $loc->contact_phone)
                        <div class="space-y-1 text-xs border-t border-slate-800/80 pt-3 text-slate-400">
                            @if($loc->contact_name)
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Sorumlu:</span>
                                    <span class="text-slate-300">{{ $loc->contact_name }}</span>
                                </div>
                            @endif
                            @if($loc->contact_phone)
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Telefon:</span>
                                    <span class="text-slate-300 font-mono">{{ $loc->contact_phone }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="pt-4 mt-4 border-t border-slate-800 flex justify-between items-center">
                    <a href="{{ route('panel.equipment.index', ['company' => $currentCompany->slug, 'location_id' => $loc->id]) }}" class="text-xs font-semibold text-amber-400 hover:underline">
                        Ekipmanları Gör →
                    </a>
                    <a href="{{ route('panel.locations.edit', ['company' => $currentCompany->slug, 'location' => $loc->id]) }}" class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center bg-slate-900 border border-slate-800 rounded-3xl text-slate-400">
                <i data-lucide="map-pin" class="w-12 h-12 text-slate-600 mx-auto mb-3"></i>
                <div class="text-base font-bold text-white">Tanımlı Lokasyon Yok</div>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">Tesisinize ait bölümleri ve binaları ekleyin.</p>
                <a href="{{ route('panel.locations.create', ['company' => $currentCompany->slug]) }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2 rounded-xl text-xs">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Lokasyon Ekle</span>
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection

@extends('layouts.panel')

@section('title', 'Tedarikçiler & Yetkili Servisler')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Tedarikçi ve Servis Rehberi</h1>
            <p class="text-xs text-slate-400 mt-1">Makine üreticileri, yetkili teknik servisler ve parça tedarikçileri.</p>
        </div>
        <a href="{{ route('panel.suppliers.create', ['company' => $currentCompany->slug]) }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Yeni Tedarikçi Ekle</span>
        </a>
    </div>

    <!-- Suppliers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($suppliers as $sup)
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 flex flex-col justify-between hover:border-slate-700 transition group">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <i data-lucide="truck" class="w-5 h-5"></i>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 font-mono text-[10px]">
                            {{ $sup->category ?: 'Genel Servis' }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-white mb-1 group-hover:text-amber-400 transition">{{ $sup->name }}</h3>
                    <div class="text-xs text-slate-400 mb-4">{{ $sup->contact_person ? 'Yetkili: ' . $sup->contact_person : 'Yetkili belirtilmemiş' }}</div>

                    <div class="space-y-2 text-xs border-t border-slate-800/80 pt-3 text-slate-400 font-mono">
                        @if($sup->phone)
                            <div class="flex justify-between">
                                <span class="text-slate-500 font-sans">Telefon:</span>
                                <a href="tel:{{ $sup->phone }}" class="text-slate-300 hover:text-amber-400">{{ $sup->phone }}</a>
                            </div>
                        @endif
                        @if($sup->email)
                            <div class="flex justify-between">
                                <span class="text-slate-500 font-sans">E-posta:</span>
                                <a href="mailto:{{ $sup->email }}" class="text-slate-300 hover:text-amber-400 truncate max-w-[170px]">{{ $sup->email }}</a>
                            </div>
                        @endif
                        <div class="flex justify-between pt-1">
                            <span class="text-slate-500 font-sans">Bağlı Varlık/Parça:</span>
                            <span class="text-amber-400 font-bold">{{ $sup->equipment_count }} Ekipman / {{ $sup->spare_parts_count }} Parça</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-slate-800 flex justify-between items-center">
                    <span class="text-[11px] text-slate-500 truncate max-w-[180px]">{{ $sup->address ?: 'Adres yok' }}</span>
                    <a href="{{ route('panel.suppliers.edit', ['company' => $currentCompany->slug, 'supplier' => $sup->id]) }}" class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center bg-slate-900 border border-slate-800 rounded-3xl text-slate-400">
                <i data-lucide="truck" class="w-12 h-12 text-slate-600 mx-auto mb-3"></i>
                <div class="text-base font-bold text-white">Tanımlı Tedarikçi Yok</div>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">Makinelerinizin yetkili teknik servislerini ve yedek parça satıcılarını ekleyin.</p>
                <a href="{{ route('panel.suppliers.create', ['company' => $currentCompany->slug]) }}" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2 rounded-xl text-xs">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Tedarikçi Ekle</span>
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection

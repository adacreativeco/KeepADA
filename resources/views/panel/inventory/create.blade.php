@extends('layouts.panel')

@section('title', 'Yeni Yedek Parça Tanımla')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Yeni Yedek Parça Ekle</h1>
            <p class="text-xs text-slate-400 mt-1">Depo stoğunuza yeni sarf malzemesi veya kritik yedek parça kaydedin.</p>
        </div>
        <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Envantere Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.inventory.store', ['company' => $currentCompany->slug]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Parça Adı *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Örn: Rulman 6204-2RSH, Yağ Filtresi 400..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Parça Kodu / SKU *</label>
                    <input type="text" name="code" value="{{ old('code') }}" required placeholder="Örn: YP-RLM-01" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Tedarikçi / Satıcı</label>
                    <select name="supplier_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Tedarikçi Seçiniz</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ölçü Birimi *</label>
                    <input type="text" name="unit" value="{{ old('unit', 'adet') }}" required placeholder="adet, metre, litre, kg, paket..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Mevcut Stok Miktarı *</label>
                    <input type="number" step="0.01" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Minimum Güvenlik Stoğu *</label>
                    <input type="number" step="0.01" name="min_stock" value="{{ old('min_stock', 5) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Birim Maliyet / Alış Fiyatı (TL) *</label>
                    <input type="number" step="0.01" name="unit_cost" value="{{ old('unit_cost', 0) }}" required placeholder="0.00" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                    İptal
                </a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                    Parçayı Kaydet
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

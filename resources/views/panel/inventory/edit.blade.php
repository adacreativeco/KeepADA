@extends('layouts.panel')

@section('title', 'Yedek Parçayı Düzenle: ' . $part->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Yedek Parça Bilgilerini Düzenle</h1>
            <p class="text-xs text-slate-400 mt-1"><span class="font-mono text-amber-400 font-bold">[{{ $part->code }}]</span> {{ $part->name }}</p>
        </div>
        <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Envantere Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.inventory.update', ['company' => $currentCompany->slug, 'inventory' => $part->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Parça Adı *</label>
                    <input type="text" name="name" value="{{ old('name', $part->name) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Parça Kodu / SKU *</label>
                    <input type="text" name="code" value="{{ old('code', $part->code) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Tedarikçi / Satıcı</label>
                    <select name="supplier_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Tedarikçi Seçiniz</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id', $part->supplier_id) == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ölçü Birimi *</label>
                    <input type="text" name="unit" value="{{ old('unit', $part->unit) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Minimum Güvenlik Stoğu *</label>
                    <input type="number" step="0.01" name="min_stock" value="{{ old('min_stock', $part->min_stock) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Birim Maliyet / Alış Fiyatı (TL) *</label>
                    <input type="number" step="0.01" name="unit_cost" value="{{ old('unit_cost', $part->unit_cost) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

            </div>

            <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800 flex items-center justify-between">
                <div>
                    <div class="text-xs text-slate-400">Mevcut Stok Miktarı</div>
                    <div class="text-lg font-mono font-bold text-white">{{ $part->stock_quantity }} {{ $part->unit }}</div>
                </div>
                <div class="text-xs text-slate-500 max-w-xs text-right">
                    Stok miktarı giriş/çıkış hareketleri ile otomatik güncellenir.
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                <button type="button" onclick="if(confirm('Bu yedek parçayı silmek istediğinize emin misiniz?')) document.getElementById('delete-part-form').submit();" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                    Parçayı Sil
                </button>
                <div class="flex gap-3">
                    <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                        İptal
                    </a>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                        Güncelle
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-part-form" action="{{ route('panel.inventory.destroy', ['company' => $currentCompany->slug, 'inventory' => $part->id]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>
@endsection

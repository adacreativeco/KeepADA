@extends('layouts.panel')

@section('title', 'Ekipmanı Düzenle: ' . $equipment->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Ekipman Bilgilerini Düzenle</h1>
            <p class="text-xs text-slate-400 mt-1"><span class="font-mono text-amber-400 font-bold">[{{ $equipment->code }}]</span> {{ $equipment->name }}</p>
        </div>
        <a href="{{ route('panel.equipment.show', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Detaya Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.equipment.update', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ekipman Adı *</label>
                    <input type="text" name="name" value="{{ old('name', $equipment->name) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ekipman / Varlık Kodu *</label>
                    <input type="text" name="code" value="{{ old('code', $equipment->code) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Lokasyon</label>
                    <select name="location_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Lokasyon Seçiniz</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id', $equipment->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Yetkili Servis / Tedarikçi</label>
                    <select name="supplier_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Tedarikçi Seçiniz</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id', $equipment->supplier_id) == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $equipment->category) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Çalışma Durumu *</label>
                    <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="active" {{ old('status', $equipment->status) === 'active' ? 'selected' : '' }}>Aktif / Çalışıyor</option>
                        <option value="under_maintenance" {{ old('status', $equipment->status) === 'under_maintenance' ? 'selected' : '' }}>Bakımda</option>
                        <option value="inactive" {{ old('status', $equipment->status) === 'inactive' ? 'selected' : '' }}>Pasif</option>
                        <option value="scrapped" {{ old('status', $equipment->status) === 'scrapped' ? 'selected' : '' }}>Hurda</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Marka</label>
                    <input type="text" name="brand" value="{{ old('brand', $equipment->brand) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Model</label>
                    <input type="text" name="model" value="{{ old('model', $equipment->model) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Seri Numarası</label>
                    <input type="text" name="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Satın Alma Tarihi</label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date', $equipment->purchase_date?->format('Y-m-d')) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Garanti Bitiş Tarihi</label>
                    <input type="date" name="warranty_end_date" value="{{ old('warranty_end_date', $equipment->warranty_end_date?->format('Y-m-d')) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Güncel Sayaç</label>
                        <input type="number" step="0.01" name="current_meter_reading" value="{{ old('current_meter_reading', $equipment->current_meter_reading) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sayaç Birimi</label>
                        <input type="text" name="meter_unit" value="{{ old('meter_unit', $equipment->meter_unit) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

            </div>

            <div>
                <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ekipman Notları &amp; Teknik Özellikler</label>
                <textarea name="notes" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('notes', $equipment->notes) }}</textarea>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                <button type="button" onclick="if(confirm('Bu ekipmanı silmek istediğinize emin misiniz?')) document.getElementById('delete-form').submit();" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                    Ekipmanı Sil
                </button>
                <div class="flex gap-3">
                    <a href="{{ route('panel.equipment.show', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                        İptal
                    </a>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-form" action="{{ route('panel.equipment.destroy', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>
@endsection

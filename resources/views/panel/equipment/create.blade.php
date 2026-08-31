@extends('layouts.panel')

@section('title', 'Yeni Ekipman Ekle')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Yeni Ekipman &amp; Varlık Ekle</h1>
            <p class="text-xs text-slate-400 mt-1">Tesisinize yeni bir makine, hat veya elektrik panosu kaydedin.</p>
        </div>
        <a href="{{ route('panel.equipment.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Listeye Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.equipment.store', ['company' => $currentCompany->slug]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ekipman Adı *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Örn: Vidalı Hava Kompresörü #1" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ekipman / Varlık Kodu *</label>
                    <input type="text" name="code" value="{{ old('code') }}" required placeholder="Örn: HK-001" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Lokasyon</label>
                    <select name="location_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Lokasyon Seçiniz</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Yetkili Servis / Tedarikçi</label>
                    <select name="supplier_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Tedarikçi Seçiniz</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Kategori</label>
                    <input type="text" name="category" value="{{ old('category') }}" placeholder="Mekanik, Elektrik, HVAC, Hidrolik..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Çalışma Durumu *</label>
                    <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="active" selected>Aktif / Çalışıyor</option>
                        <option value="under_maintenance">Bakımda</option>
                        <option value="inactive">Pasif</option>
                        <option value="scrapped">Hurda</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Marka</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Örn: Atlas Copco" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Model</label>
                    <input type="text" name="model" value="{{ old('model') }}" placeholder="Örn: GA-37" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Seri Numarası</label>
                    <input type="text" name="serial_number" value="{{ old('serial_number') }}" placeholder="Örn: SN-98765432" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Satın Alma Tarihi</label>
                    <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Garanti Bitiş Tarihi</label>
                    <input type="date" name="warranty_end_date" value="{{ old('warranty_end_date') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Başlangıç Sayacı</label>
                        <input type="number" step="0.01" name="current_meter_reading" value="{{ old('current_meter_reading', 0) }}" placeholder="0" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sayaç Birimi</label>
                        <input type="text" name="meter_unit" value="{{ old('meter_unit', 'saat') }}" placeholder="saat, km, adet..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

            </div>

            <div>
                <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Ekipman Notları &amp; Teknik Özellikler</label>
                <textarea name="notes" rows="3" placeholder="Motor gücü, çalışma basıncı, özel çalışma şartları..." class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('panel.equipment.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                    İptal
                </a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                    Ekipmanı Kaydet
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

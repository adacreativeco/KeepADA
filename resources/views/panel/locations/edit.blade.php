@extends('layouts.panel')

@section('title', 'Lokasyonu Düzenle: ' . $location->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Lokasyon Bilgilerini Düzenle</h1>
            <p class="text-xs text-slate-400 mt-1">{{ $location->name }}</p>
        </div>
        <a href="{{ route('panel.locations.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Listeye Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.locations.update', ['company' => $currentCompany->slug, 'location' => $location->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                
                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Lokasyon / Bölüm Adı *</label>
                    <input type="text" name="name" value="{{ old('name', $location->name) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Açık Adres / Konum Tarifi</label>
                    <textarea name="address" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('address', $location->address) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sorumlu Kişi</label>
                        <input type="text" name="contact_name" value="{{ old('contact_name', $location->contact_name) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İletişim Telefonu</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $location->contact_phone) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Enlem (Latitude)</label>
                        <input type="number" step="0.0000001" name="lat" value="{{ old('lat', $location->lat) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Boylam (Longitude)</label>
                        <input type="number" step="0.0000001" name="lng" value="{{ old('lng', $location->lng) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

            </div>

            <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                <button type="button" onclick="if(confirm('Bu lokasyonu silmek istediğinize emin misiniz?')) document.getElementById('delete-location-form').submit();" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                    Lokasyonu Sil
                </button>
                <div class="flex gap-3">
                    <a href="{{ route('panel.locations.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                        İptal
                    </a>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                        Güncelle
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-location-form" action="{{ route('panel.locations.destroy', ['company' => $currentCompany->slug, 'location' => $location->id]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>
@endsection

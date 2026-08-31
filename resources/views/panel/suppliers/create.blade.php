@extends('layouts.panel')

@section('title', 'Yeni Tedarikçi / Yetkili Servis Ekle')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Yeni Tedarikçi / Servis Ekle</h1>
            <p class="text-xs text-slate-400 mt-1">Yetkili bakım servisi, makine distribütörü veya yedek parça satıcısı kaydedin.</p>
        </div>
        <a href="{{ route('panel.suppliers.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Listeye Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.suppliers.store', ['company' => $currentCompany->slug]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-4">
                
                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Tedarikçi / Şirket Adı *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Örn: Atlas Copco Türkiye Yetkili Servisi" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Hizmet / Parça Kategorisi</label>
                        <input type="text" name="category" value="{{ old('category') }}" placeholder="Kompresör & Hava, Rulman, Elektrik..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Yetkili / Kontak Kişi</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Müşteri Temsilcisi Adı" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Telefon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+90 216 ..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">E-posta Adresi</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="servis@tedarikci.com" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Adres</label>
                    <textarea name="address" rows="3" placeholder="Firma adresi..." class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('address') }}</textarea>
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('panel.suppliers.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                    İptal
                </a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                    Tedarikçiyi Kaydet
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

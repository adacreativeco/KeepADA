@extends('layouts.panel')

@section('title', 'Yeni İş Emri & Görev Aç')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Yeni İş Emri / Bakım Görevi</h1>
            <p class="text-xs text-slate-400 mt-1">Periyodik bakım veya arıza giderme görevi başlatın.</p>
        </div>
        <a href="{{ route('panel.tasks.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Listeye Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.tasks.store', ['company' => $currentCompany->slug]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İş Emri / Görev Başlığı *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Örn: Kompresör Yağ ve Filtre Değişimi, Pano Kontrolü..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İlgili Ekipman / Makine *</label>
                    <select name="equipment_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Ekipman Seçiniz</option>
                        @foreach($equipmentList as $eq)
                            <option value="{{ $eq->id }}" {{ old('equipment_id', $selectedEquipmentId) == $eq->id ? 'selected' : '' }}>
                                [{{ $eq->code }}] {{ $eq->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Atanan Teknisyen / Sorumlu</label>
                    <select name="assigned_to" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Teknisyen Seçiniz</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ old('assigned_to') == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Bakım Türü *</label>
                    <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="preventive" selected>Periyodik Önleyici Bakım</option>
                        <option value="corrective">Arızi Düzeltici Bakım</option>
                        <option value="emergency">Acil Müdahale</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Öncelik Derecesi *</label>
                    <select name="priority" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="low">Düşük</option>
                        <option value="medium" selected>Normal / Orta</option>
                        <option value="high">Yüksek</option>
                        <option value="critical">Kritik / Acil</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Planlanan Uygulama Tarihi *</label>
                    <input type="date" name="scheduled_date" value="{{ old('scheduled_date', date('Y-m-d')) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Başlangıç Durumu *</label>
                    <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="pending" selected>Bekliyor (Pending)</option>
                        <option value="in_progress">Devam Ediyor (In Progress)</option>
                        <option value="done">Tamamlandı (Done)</option>
                    </select>
                </div>

            </div>

            <div>
                <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Görev Açıklaması / Talimatlar &amp; Kontrol Maddeleri</label>
                <textarea name="notes" rows="4" placeholder="1. Filtreyi sökün ve temizleyin.&#10;2. Yağ seviyesini ölçün.&#10;3. Basınç valfini test edin..." class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none font-sans">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('panel.tasks.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                    İptal
                </a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                    İş Emrini Başlat
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

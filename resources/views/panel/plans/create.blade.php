@extends('layouts.panel')

@section('title', 'Yeni Bakım Planı Tanımla')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Yeni Periyodik Bakım Planı</h1>
            <p class="text-xs text-slate-400 mt-1">Zaman veya sayaç bazlı otomatik periyodik görev tetikleyicisi.</p>
        </div>
        <a href="{{ route('panel.plans.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Planlara Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.plans.store', ['company' => $currentCompany->slug]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Plan Başlığı *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Örn: 500 Saatlik Genel Revizyon veya 3 Aylık Yağ Değişimi" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İlgili Ekipman *</label>
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
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Varsayılan Teknisyen</label>
                    <select name="assigned_to" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Otomatik / Atanmamış</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ old('assigned_to') == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Periyot Birimi *</label>
                        <select name="frequency_type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="monthly" selected>Aylık (Month)</option>
                            <option value="weekly">Haftalık (Week)</option>
                            <option value="daily">Günlük (Day)</option>
                            <option value="quarterly">3 Aylık (Quarterly)</option>
                            <option value="yearly">Yıllık (Yearly)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sıklık Değeri *</label>
                        <input type="number" min="1" name="frequency_value" value="{{ old('frequency_value', 1) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sayaç Aralığı (Opsiyonel)</label>
                    <input type="number" step="0.01" name="meter_interval" value="{{ old('meter_interval') }}" placeholder="Örn: Her 500 saatte bir" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İlk / Sonraki Bakım Tarihi *</label>
                    <input type="date" name="next_due_date" value="{{ old('next_due_date', date('Y-m-d')) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Hedef SLA Süresi (Saat)</label>
                    <input type="number" name="sla_hours" value="{{ old('sla_hours', 24) }}" placeholder="24" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Tahmini Bütçe / Maliyet (TL)</label>
                    <input type="number" step="0.01" name="estimated_cost" value="{{ old('estimated_cost') }}" placeholder="0.00" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Tahmini Süre (Dakika)</label>
                    <input type="number" name="estimated_duration_minutes" value="{{ old('estimated_duration_minutes', 60) }}" placeholder="60" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

            </div>

            <div>
                <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Görev Talimat Şablonu</label>
                <textarea name="description" rows="3" placeholder="Bu plana bağlı oluşturulacak görevlerde yer alacak kontrol maddeleri..." class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none font-sans">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" checked class="accent-amber-400 rounded">
                <label class="text-xs text-slate-300 font-semibold">Bu planı aktif olarak başlat</label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-800">
                <a href="{{ route('panel.plans.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                    İptal
                </a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                    Planı Kaydet &amp; Başlat
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

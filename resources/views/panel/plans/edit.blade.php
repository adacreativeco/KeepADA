@extends('layouts.panel')

@section('title', 'Bakım Planını Düzenle: ' . $plan->title)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Bakım Planını Düzenle</h1>
            <p class="text-xs text-slate-400 mt-1">{{ $plan->title }} &bull; Ekipman: <span class="font-mono text-amber-400">[{{ $plan->equipment->code }}] {{ $plan->equipment->name }}</span></p>
        </div>
        <a href="{{ route('panel.plans.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Planlara Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.plans.update', ['company' => $currentCompany->slug, 'plan' => $plan->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Plan Başlığı *</label>
                    <input type="text" name="title" value="{{ old('title', $plan->title) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İlgili Ekipman *</label>
                    <select name="equipment_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        @foreach($equipmentList as $eq)
                            <option value="{{ $eq->id }}" {{ old('equipment_id', $plan->equipment_id) == $eq->id ? 'selected' : '' }}>
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
                            <option value="{{ $tech->id }}" {{ old('assigned_to', $plan->assigned_to) == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Periyot Birimi *</label>
                        <select name="frequency_type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                            <option value="monthly" {{ old('frequency_type', $plan->frequency_type) === 'monthly' ? 'selected' : '' }}>Aylık (Month)</option>
                            <option value="weekly" {{ old('frequency_type', $plan->frequency_type) === 'weekly' ? 'selected' : '' }}>Haftalık (Week)</option>
                            <option value="daily" {{ old('frequency_type', $plan->frequency_type) === 'daily' ? 'selected' : '' }}>Günlük (Day)</option>
                            <option value="quarterly" {{ old('frequency_type', $plan->frequency_type) === 'quarterly' ? 'selected' : '' }}>3 Aylık (Quarterly)</option>
                            <option value="yearly" {{ old('frequency_type', $plan->frequency_type) === 'yearly' ? 'selected' : '' }}>Yıllık (Yearly)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sıklık Değeri *</label>
                        <input type="number" min="1" name="frequency_value" value="{{ old('frequency_value', $plan->frequency_value) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sayaç Aralığı</label>
                    <input type="number" step="0.01" name="meter_interval" value="{{ old('meter_interval', $plan->meter_interval) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Sonraki Bakım Tarihi *</label>
                    <input type="date" name="next_due_date" value="{{ old('next_due_date', $plan->next_due_date?->format('Y-m-d')) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Hedef SLA Süresi (Saat)</label>
                    <input type="number" name="sla_hours" value="{{ old('sla_hours', $plan->sla_hours) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Tahmini Bütçe (TL)</label>
                    <input type="number" step="0.01" name="estimated_cost" value="{{ old('estimated_cost', $plan->estimated_cost) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Tahmini Süre (Dakika)</label>
                    <input type="number" name="estimated_duration_minutes" value="{{ old('estimated_duration_minutes', $plan->estimated_duration_minutes) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

            </div>

            <div>
                <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Görev Talimat Şablonu</label>
                <textarea name="description" rows="3" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none font-sans">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="accent-amber-400 rounded">
                <label class="text-xs text-slate-300 font-semibold">Bu plan aktif</label>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                <button type="button" onclick="if(confirm('Bu bakım planını silmek istediğinize emin misiniz?')) document.getElementById('delete-plan-form').submit();" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                    Planı Sil
                </button>
                <div class="flex gap-3">
                    <a href="{{ route('panel.plans.index', ['company' => $currentCompany->slug]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                        İptal
                    </a>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                        Güncelle
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-plan-form" action="{{ route('panel.plans.destroy', ['company' => $currentCompany->slug, 'plan' => $plan->id]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>
@endsection

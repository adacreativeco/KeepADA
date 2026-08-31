@extends('layouts.panel')

@section('title', 'İş Emrini Düzenle: #' . $task->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">İş Emrini Düzenle</h1>
            <p class="text-xs text-slate-400 mt-1"><span class="font-mono text-amber-400 font-bold">#{{ $task->id }}</span> {{ $task->title }}</p>
        </div>
        <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Detaya Dön</span>
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-xl">
        <form action="{{ route('panel.tasks.update', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                
                <div class="sm:col-span-2">
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İş Emri / Görev Başlığı *</label>
                    <input type="text" name="title" value="{{ old('title', $task->title) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İlgili Ekipman *</label>
                    <select name="equipment_id" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        @foreach($equipmentList as $eq)
                            <option value="{{ $eq->id }}" {{ old('equipment_id', $task->equipment_id) == $eq->id ? 'selected' : '' }}>
                                [{{ $eq->code }}] {{ $eq->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Atanan Teknisyen</label>
                    <select name="assigned_to" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="">Teknisyen Seçiniz</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ old('assigned_to', $task->assigned_to) == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Bakım Türü *</label>
                    <select name="type" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="preventive" {{ old('type', $task->type) === 'preventive' ? 'selected' : '' }}>Periyodik Önleyici Bakım</option>
                        <option value="corrective" {{ old('type', $task->type) === 'corrective' ? 'selected' : '' }}>Arızi Düzeltici Bakım</option>
                        <option value="emergency" {{ old('type', $task->type) === 'emergency' ? 'selected' : '' }}>Acil Müdahale</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Öncelik *</label>
                    <select name="priority" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Düşük</option>
                        <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Normal / Orta</option>
                        <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>Yüksek</option>
                        <option value="critical" {{ old('priority', $task->priority) === 'critical' ? 'selected' : '' }}>Kritik</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Planlanan Tarih *</label>
                    <input type="date" name="scheduled_date" value="{{ old('scheduled_date', $task->scheduled_date?->format('Y-m-d')) }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Durum *</label>
                    <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-amber-400 focus:outline-none">
                        <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                        <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                        <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Tamamlandı</option>
                        <option value="cancelled" {{ old('status', $task->status) === 'cancelled' ? 'selected' : '' }}>İptal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">İşçilik Maliyeti (TL)</label>
                    <input type="number" step="0.01" name="labor_cost" value="{{ old('labor_cost', $task->labor_cost) }}" placeholder="0.00" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Dış Hizmet / Malzeme Maliyeti (TL)</label>
                    <input type="number" step="0.01" name="material_cost" value="{{ old('material_cost', $task->material_cost) }}" placeholder="0.00" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white font-mono focus:border-amber-400 focus:outline-none">
                </div>

            </div>

            <div>
                <label class="block text-xs font-mono uppercase text-slate-400 mb-2">Açıklama &amp; Notlar</label>
                <textarea name="notes" rows="4" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-4 text-sm text-white focus:border-amber-400 focus:outline-none">{{ old('notes', $task->notes) }}</textarea>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-slate-800">
                <button type="button" onclick="if(confirm('Bu iş emrini silmek istediğinize emin misiniz?')) document.getElementById('delete-task-form').submit();" class="text-rose-400 hover:text-rose-300 text-xs font-semibold">
                    İş Emrini Sil
                </button>
                <div class="flex gap-3">
                    <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="px-5 py-2.5 rounded-xl border border-slate-800 hover:bg-slate-800 text-slate-300 text-xs font-semibold transition">
                        İptal
                    </a>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-6 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/25">
                        Güncelle
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-task-form" action="{{ route('panel.tasks.destroy', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

</div>
@endsection

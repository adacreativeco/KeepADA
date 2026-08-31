@extends('layouts.panel')

@section('title', 'İş Emirleri & Bakım Görevleri')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">İş Emirleri &amp; Bakım Görevleri</h1>
            <p class="text-xs text-slate-400 mt-1">Periyodik, arızi ve acil bakım süreçlerinin takibi.</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <!-- View Mode Switcher -->
            <div class="flex bg-slate-900 border border-slate-800 p-1 rounded-xl">
                <a href="{{ request()->fullUrlWithQuery(['view' => 'table']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition {{ $viewMode === 'table' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white' }}">
                    <i data-lucide="list" class="w-3.5 h-3.5"></i>
                    <span>Tablo</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['view' => 'kanban']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition {{ $viewMode === 'kanban' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white' }}">
                    <i data-lucide="columns" class="w-3.5 h-3.5"></i>
                    <span>Kanban</span>
                </a>
            </div>

            <a href="{{ route('panel.tasks.create', ['company' => $currentCompany->slug]) }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Yeni İş Emri Aç</span>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-slate-900 border border-slate-800 p-4 rounded-2xl">
        <form method="GET" action="{{ route('panel.tasks.index', ['company' => $currentCompany->slug]) }}" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
            <input type="hidden" name="view" value="{{ $viewMode }}">

            <div class="sm:col-span-2 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Görev veya ekipman adı ara..." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-2 text-xs text-white placeholder-slate-500 focus:border-amber-400 focus:outline-none">
            </div>

            <div>
                <select name="status" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none" onchange="this.form.submit()">
                    <option value="">Tüm Durumlar</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                    <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Tamamlandı</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>İptal</option>
                </select>
            </div>

            <div>
                <select name="priority" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none" onchange="this.form.submit()">
                    <option value="">Tüm Öncelikler</option>
                    <option value="critical" {{ request('priority') === 'critical' ? 'selected' : '' }}>Kritik</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Yüksek</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Orta</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Düşük</option>
                </select>
            </div>

            <div>
                <select name="assigned_to" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white focus:border-amber-400 focus:outline-none" onchange="this.form.submit()">
                    <option value="">Tüm Teknisyenler</option>
                    @foreach($technicians as $tech)
                        <option value="{{ $tech->id }}" {{ request('assigned_to') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                    @endforeach
                </select>
            </div>

        </form>
    </div>

    @if($viewMode === 'kanban')
        <!-- Kanban Board View -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            
            @php
                $columns = [
                    'pending' => ['title' => 'Bekleyen Görevler', 'color' => 'amber', 'badge' => 'bg-amber-500/10 text-amber-400 border-amber-500/20'],
                    'in_progress' => ['title' => 'Devam Edenler', 'color' => 'blue', 'badge' => 'bg-blue-500/10 text-blue-400 border-blue-500/20'],
                    'done' => ['title' => 'Tamamlananlar', 'color' => 'emerald', 'badge' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'],
                    'cancelled' => ['title' => 'İptal Edilenler', 'color' => 'rose', 'badge' => 'bg-rose-500/10 text-rose-400 border-rose-500/20'],
                ];
            @endphp

            @foreach($columns as $colKey => $col)
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex flex-col min-h-[500px]">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800">
                        <span class="text-xs font-bold text-white uppercase font-mono tracking-wider">{{ $col['title'] }}</span>
                        <span class="px-2 py-0.5 rounded-full font-mono text-[10px] border {{ $col['badge'] }}">
                            {{ $kanbanTasks[$colKey]->count() }}
                        </span>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @forelse($kanbanTasks[$colKey] as $task)
                            <div class="p-4 rounded-xl bg-slate-950 border border-slate-800/80 hover:border-slate-700 transition space-y-2.5 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] font-mono text-slate-500">#{{ $task->id }}</span>
                                    @if($task->priority === 'critical')
                                        <span class="px-1.5 py-0.5 rounded bg-rose-500/20 text-rose-400 font-mono text-[9px]">Kritik</span>
                                    @elseif($task->priority === 'high')
                                        <span class="px-1.5 py-0.5 rounded bg-orange-500/20 text-orange-400 font-mono text-[9px]">Yüksek</span>
                                    @endif
                                </div>

                                <h4 class="text-xs font-bold text-white leading-tight">
                                    <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="hover:text-amber-400">
                                        {{ $task->title }}
                                    </a>
                                </h4>

                                <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                    <i data-lucide="cpu" class="w-3.5 h-3.5 text-slate-500 shrink-0"></i>
                                    <span class="truncate">{{ $task->equipment->name }}</span>
                                </div>

                                <div class="flex items-center justify-between pt-2 border-t border-slate-900 text-[10px] text-slate-500 font-mono">
                                    <span>{{ $task->scheduled_date->format('d.m.Y') }}</span>
                                    <span class="text-slate-400">{{ $task->assignedUser?->name ?? 'Atanmadı' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-600 text-xs font-mono">
                                Görev yok
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach

        </div>
    @else
        <!-- Table View -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-950 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                        <tr>
                            <th class="py-3.5 px-4"># ID</th>
                            <th class="py-3.5 px-4">Görev Başlığı</th>
                            <th class="py-3.5 px-4">Ekipman</th>
                            <th class="py-3.5 px-4">Teknisyen</th>
                            <th class="py-3.5 px-4">Planlanan Tarih</th>
                            <th class="py-3.5 px-4">Tür &amp; Öncelik</th>
                            <th class="py-3.5 px-4">Durum</th>
                            <th class="py-3.5 px-4 text-right">İşlem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse($tasksList as $task)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 font-mono text-slate-500">#{{ $task->id }}</td>
                                <td class="py-3.5 px-4 font-bold text-white">
                                    <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="hover:text-amber-400 transition">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 text-slate-300">
                                    <span class="font-mono text-amber-400/80">[{{ $task->equipment->code }}]</span> {{ $task->equipment->name }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-300">
                                    {{ $task->assignedUser?->name ?? '—' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-300">
                                    {{ $task->scheduled_date->format('d.m.Y') }}
                                    @if($task->status !== 'done' && $task->scheduled_date->isPast())
                                        <span class="text-rose-400 font-bold ml-1">(! Gecikti)</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-1.5 font-mono text-[10px]">
                                        <span class="text-slate-400">{{ ucfirst($task->type) }}</span>
                                        @if($task->priority === 'critical')
                                            <span class="px-1.5 py-0.5 rounded bg-rose-500/10 text-rose-400 border border-rose-500/20">Kritik</span>
                                        @elseif($task->priority === 'high')
                                            <span class="px-1.5 py-0.5 rounded bg-orange-500/10 text-orange-400 border border-orange-500/20">Yüksek</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($task->status === 'done')
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-[10px] border border-emerald-500/20 flex items-center gap-1 w-max">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Tamamlandı
                                        </span>
                                    @elseif($task->status === 'in_progress')
                                        <span class="px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 font-mono text-[10px] border border-blue-500/20 flex items-center gap-1 w-max">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span> Devam Ediyor
                                        </span>
                                    @elseif($task->status === 'cancelled')
                                        <span class="px-2.5 py-1 rounded-full bg-rose-500/10 text-rose-400 font-mono text-[10px] border border-rose-500/20 w-max">
                                            İptal Edildi
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 font-mono text-[10px] border border-amber-500/20 w-max">
                                            Bekliyor
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $task->id]) }}" class="bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                        İncele &amp; Yönet →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-500">
                                    Kriterlere uygun iş emri / görev bulunamadı.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tasksList && $tasksList->hasPages())
                <div class="p-4 border-t border-slate-800">
                    {{ $tasksList->links() }}
                </div>
            @endif
        </div>
    @endif

</div>
@endsection

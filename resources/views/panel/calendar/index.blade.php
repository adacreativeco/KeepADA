@extends('layouts.panel')

@section('title', 'İnteraktif Bakım & İş Emri Takvimi')

@push('styles')
<style>
    .fc {
        --fc-border-color: #1e293b;
        --fc-button-bg-color: #1e293b;
        --fc-button-border-color: #334155;
        --fc-button-hover-bg-color: #334155;
        --fc-button-hover-border-color: #475569;
        --fc-button-active-bg-color: #f59e0b;
        --fc-button-active-border-color: #f59e0b;
        --fc-page-bg-color: transparent;
        --fc-neutral-bg-color: rgba(15, 23, 42, 0.6);
        --fc-today-bg-color: rgba(245, 158, 11, 0.06);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .fc .fc-toolbar-title {
        font-size: 1.1rem !important;
        font-weight: 800 !important;
        color: #f8fafc;
    }
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #1e293b !important;
    }
    .fc .fc-col-header-cell-cushion {
        color: #94a3b8;
        font-size: 11px;
        font-family: 'JetBrains Mono', monospace;
        text-transform: uppercase;
        padding: 8px 0 !important;
    }
    .fc .fc-daygrid-day-number {
        color: #cbd5e1;
        font-size: 11px;
        font-family: 'JetBrains Mono', monospace;
        padding: 6px !important;
    }
    .fc-event {
        border-radius: 6px !important;
        padding: 2px 4px !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        cursor: pointer;
        transition: transform 0.1s ease;
    }
    .fc-event:hover {
        transform: scale(1.02);
    }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">İnteraktif Bakım Takvimi</h1>
            <p class="text-xs text-slate-400 mt-1">Haftalık ve aylık bazda planlanan tüm periyodik kontroller ve servis randevuları.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('panel.tasks.create') }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                <span>Yeni Görev Planla</span>
            </a>
        </div>
    </div>

    <!-- Color Legend -->
    <div class="flex flex-wrap items-center gap-4 p-4 rounded-2xl bg-slate-900 border border-slate-800 text-xs">
        <span class="text-slate-400 font-mono text-[10px] uppercase font-bold">Durum Göstergeleri:</span>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded bg-[#10b981]"></span>
            <span class="text-slate-300">Tamamlandı</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded bg-[#3b82f6]"></span>
            <span class="text-slate-300">Devam Ediyor</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded bg-[#f59e0b]"></span>
            <span class="text-slate-300">Bekleyen / Planlanan</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-3 h-3 rounded bg-[#ef4444]"></span>
            <span class="text-slate-300">Gecikmiş Bakım</span>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="bg-slate-900 border border-slate-800 p-6 rounded-3xl shadow-xl">
        <div id="calendar" class="min-h-[650px]"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'tr',
            firstDay: 1, // Pazartesi
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            buttonText: {
                today: 'Bugün',
                month: 'Ay',
                week: 'Hafta',
                list: 'Liste'
            },
            events: "{{ route('panel.calendar.events') }}",
            eventClick: function(info) {
                if (info.event.url) {
                    info.jsEvent.preventDefault();
                    window.location.href = info.event.url;
                }
            }
        });
        calendar.render();
    });
</script>
@endpush

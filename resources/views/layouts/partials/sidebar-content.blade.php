<!-- Sidebar Brand / Logo -->
<div class="flex h-16 shrink-0 items-center justify-between border-b border-slate-800">
    <a href="{{ route('panel.dashboard', ['company' => $currentCompany->slug]) }}" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-600 to-amber-400 flex items-center justify-center text-slate-950 font-bold text-lg shadow-lg shadow-amber-500/20">
            <i data-lucide="wrench" class="w-5 h-5 text-slate-950"></i>
        </div>
        <div class="leading-tight">
            <div class="font-extrabold text-base tracking-tight text-white flex items-center gap-1.5">
                <span>KeepADA</span>
                <span class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">CMMS</span>
            </div>
            <div class="text-[11px] text-slate-400 font-mono tracking-wider truncate max-w-[150px]">{{ $currentCompany->name }}</div>
        </div>
    </a>
</div>

<!-- Company Switcher (If multiple companies) -->
@if(auth()->user()->companies->count() > 1)
    <div class="mt-2" x-data="{ open: false }">
        <label class="text-[10px] font-mono uppercase text-slate-400 tracking-wider block mb-1">{{ __('cmms.active_facility') }}</label>
        <div class="relative">
            <button type="button" @click="open = !open" class="w-full flex items-center justify-between p-2.5 rounded-xl bg-slate-950/60 border border-slate-800 text-xs text-slate-200 hover:border-slate-700 transition">
                <span class="truncate font-semibold text-amber-300">{{ $currentCompany->name }}</span>
                <i data-lucide="chevrons-up-down" class="w-4 h-4 text-slate-400 shrink-0"></i>
            </button>
            <div x-show="open" @click.outside="open = false" x-transition class="absolute left-0 right-0 z-50 mt-1 rounded-xl bg-slate-900 border border-slate-800 p-1 shadow-2xl" x-cloak>
                @foreach(auth()->user()->companies as $c)
                    <a href="{{ route('panel.dashboard', ['company' => $c->slug]) }}" class="block px-3 py-2 text-xs rounded-lg transition {{ $c->id === $currentCompany->id ? 'bg-amber-500/10 text-amber-400 font-bold' : 'text-slate-300 hover:bg-slate-800' }}">
                        {{ $c->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Nav Links -->
<nav class="flex flex-1 flex-col mt-2">
    <ul role="list" class="flex flex-1 flex-col gap-y-1 text-sm font-medium">
        
        <li class="text-[10px] font-mono uppercase tracking-widest text-slate-400 px-3 pt-3 pb-1">Operasyon &amp; İzleme</li>

        <li>
            <a href="{{ route('panel.dashboard', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.dashboard') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.dashboard') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.dashboard') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('panel.tasks.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.tasks.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="clipboard-list" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.tasks.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.work_orders') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('panel.calendar', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.calendar') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="calendar" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.calendar') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.maintenance_calendar') }}</span>
            </a>
        </li>

        <li class="text-[10px] font-mono uppercase tracking-widest text-slate-400 px-3 pt-5 pb-1">Varlık &amp; Planlama</li>

        <li>
            <a href="{{ route('panel.equipment.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.equipment.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="cpu" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.equipment.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.equipment_assets') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('panel.plans.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.plans.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="calendar-clock" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.plans.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.maintenance_plans') }}</span>
            </a>
        </li>

        <li class="text-[10px] font-mono uppercase tracking-widest text-slate-400 px-3 pt-5 pb-1">Envanter &amp; Lojistik</li>

        <li>
            <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.inventory.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="package" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.inventory.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.spare_parts') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('panel.locations.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.locations.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="map-pin" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.locations.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.locations') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('panel.suppliers.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.suppliers.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="truck" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.suppliers.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.suppliers') }}</span>
            </a>
        </li>

        <li class="text-[10px] font-mono uppercase tracking-widest text-slate-400 px-3 pt-5 pb-1">Analitik &amp; Yönetim</li>

        <li>
            <a href="{{ route('panel.reports.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.reports.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="bar-chart-3" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.reports.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.reports_analytics') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('panel.team.index', ['company' => $currentCompany->slug]) }}" class="group flex gap-x-3 rounded-xl p-2.5 transition {{ request()->routeIs('panel.team.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100' }}">
                <i data-lucide="users" class="w-5 h-5 shrink-0 {{ request()->routeIs('panel.team.*') ? 'text-amber-400' : 'text-slate-400 group-hover:text-slate-300' }}"></i>
                <span>{{ __('cmms.team_technicians') }}</span>
            </a>
        </li>

    </ul>
</nav>

<!-- User Footer in Sidebar -->
<div class="border-t border-slate-800 pt-3">
    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-950/50 border border-slate-800/80">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-xs shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</div>
                <div class="text-[10px] text-slate-400 font-mono">{{ auth()->user()->roles->first()?->name ?? 'Kullanıcı' }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="shrink-0">
            @csrf
            <button type="submit" title="{{ __('cmms.logout') }}" class="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition">
                <i data-lucide="log-out" class="w-4 h-4"></i>
            </button>
        </form>
    </div>
</div>

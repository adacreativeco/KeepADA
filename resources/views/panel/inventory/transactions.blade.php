@extends('layouts.panel')

@section('title', 'Stok Hareket Geçmişi & Denetim İzi')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Stok Hareket Geçmişi (Audit Trail)</h1>
            <p class="text-xs text-slate-400 mt-1">Tüm yedek parça giriş, çıkış, iş emri sarfiyatı ve sayım düzeltmelerinin değişmez kayıtları.</p>
        </div>
        <a href="{{ route('panel.inventory.index', ['company' => $currentCompany->slug]) }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-mono">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Envantere Dön</span>
        </a>
    </div>

    <!-- Audit Log Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950 text-slate-400 font-mono uppercase text-[10px] border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Tarih / Saat</th>
                        <th class="py-3.5 px-4">Parça</th>
                        <th class="py-3.5 px-4">Hareket Türü</th>
                        <th class="py-3.5 px-4">Miktar</th>
                        <th class="py-3.5 px-4">İş Emri</th>
                        <th class="py-3.5 px-4">İşlemi Yapan</th>
                        <th class="py-3.5 px-4">Açıklama</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-mono text-slate-400">
                                {{ $t->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-white">
                                <span class="font-mono text-amber-400">[{{ $t->sparePart?->code }}]</span> {{ $t->sparePart?->name }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($t->type === 'in')
                                    <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 font-mono text-[10px] border border-emerald-500/20">
                                        + Giriş
                                    </span>
                                @elseif($t->type === 'out')
                                    <span class="px-2 py-0.5 rounded bg-rose-500/10 text-rose-400 font-mono text-[10px] border border-rose-500/20">
                                        - Çıkış
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded bg-blue-500/10 text-blue-400 font-mono text-[10px] border border-blue-500/20">
                                        ± Düzeltme
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-200">
                                {{ $t->quantity }} {{ $t->sparePart?->unit }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-300">
                                @if($t->task)
                                    <a href="{{ route('panel.tasks.show', ['company' => $currentCompany->slug, 'task' => $t->task_id]) }}" class="text-amber-400 hover:underline font-mono">
                                        #{{ $t->task_id }} {{ $t->task->title }}
                                    </a>
                                @else
                                    <span class="text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-300">
                                {{ $t->user?->name ?? 'Sistem' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $t->notes ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                Kayıtlı stok hareketi bulunmuyor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

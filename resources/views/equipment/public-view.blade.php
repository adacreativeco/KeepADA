<!DOCTYPE html>
<html lang="tr" class="bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $equipment->name }} · Dijital Varlık Pasaportu | KeepADA CMMS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 min-h-screen antialiased flex flex-col justify-between">

    <!-- Header -->
    <header class="bg-slate-900/90 border-b border-slate-800 backdrop-blur sticky top-0 z-30">
        <div class="max-w-lg mx-auto px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-amber-500 rounded-xl flex items-center justify-center text-slate-950 shadow-md shadow-amber-500/20">
                    <i data-lucide="wrench" class="w-4 h-4 text-slate-950"></i>
                </div>
                <span class="font-extrabold text-sm text-white tracking-tight">KeepADA <span class="text-amber-400">CMMS</span></span>
            </div>
            <span class="text-[10px] font-mono font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                <i data-lucide="qr-code" class="w-3 h-3"></i>
                <span>Dijital Pasaport</span>
            </span>
        </div>
    </header>

    <main class="max-w-lg w-full mx-auto px-4 py-6 space-y-6">
        
        <!-- Main Equipment Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl space-y-5">
            
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-[10px] font-mono uppercase text-slate-400 block mb-1">
                        {{ $equipment->category ?: 'Genel Varlık' }}
                    </span>
                    <h1 class="text-xl font-extrabold text-white leading-snug">{{ $equipment->name }}</h1>
                    <div class="text-xs font-mono text-amber-400 font-bold mt-1">Kod: {{ $equipment->code }}</div>
                </div>
                <div>
                    @if($equipment->status === 'active')
                        <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-[10px] border border-emerald-500/20 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif
                        </span>
                    @elseif($equipment->status === 'under_maintenance')
                        <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 font-mono text-[10px] border border-amber-500/20 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Bakımda
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full bg-rose-500/10 text-rose-400 font-mono text-[10px] border border-rose-500/20">
                            Pasif
                        </span>
                    @endif
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-3 font-mono">
                <div class="bg-slate-950 p-3 rounded-2xl border border-slate-800/80">
                    <span class="text-[10px] text-slate-500 uppercase block mb-0.5">Lokasyon</span>
                    <span class="text-xs font-semibold text-slate-200 truncate block">{{ $equipment->location?->name ?? 'Belirtilmedi' }}</span>
                </div>
                <div class="bg-slate-950 p-3 rounded-2xl border border-slate-800/80">
                    <span class="text-[10px] text-slate-500 uppercase block mb-0.5">Güncel Sayaç</span>
                    <span class="text-xs font-semibold text-amber-400 truncate block">{{ $equipment->current_meter_reading ?: '0' }} {{ $equipment->meter_unit ?: 'saat' }}</span>
                </div>
            </div>

            <!-- AI Maintenance Banner -->
            <div class="bg-gradient-to-r from-amber-600/20 via-amber-500/10 to-transparent border border-amber-500/30 rounded-2xl p-4 flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400 shrink-0">
                    <i data-lucide="brain-circuit" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-mono uppercase text-amber-300 block">Tahmini Bir Sonraki Bakım</span>
                    <span class="text-sm font-bold text-white font-mono">{{ $equipment->predictive_next_due_date ? $equipment->predictive_next_due_date->format('d.m.Y') : 'Veri Analiz Ediliyor' }}</span>
                </div>
            </div>

            <!-- Specs list -->
            <div class="space-y-2 text-xs border-t border-slate-800 pt-3 text-slate-400 font-mono">
                <div class="flex justify-between">
                    <span class="text-slate-500 font-sans">Marka / Model:</span>
                    <span class="text-slate-200">{{ $equipment->brand ?? '—' }} {{ $equipment->model ?? '' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-sans">Seri No:</span>
                    <span class="text-slate-200">{{ $equipment->serial_number ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-sans">Yetkili Servis:</span>
                    <span class="text-slate-200">{{ $equipment->supplier?->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-sans">Garanti Bitişi:</span>
                    <span class="text-slate-200">{{ $equipment->warranty_end_date?->format('d.m.Y') ?? '—' }}</span>
                </div>
            </div>

        </div>

        <!-- Maintenance History -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 space-y-4">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider font-mono flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-amber-400"></i>
                <span>Tamamlanan Bakım Kayıtları</span>
            </h2>

            <div class="space-y-2.5">
                @forelse($equipment->maintenanceTasks()->where('status', 'done')->latest('completed_at')->take(4)->get() as $task)
                    <div class="bg-slate-950 p-3.5 rounded-2xl border border-slate-800/80 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center text-xs shrink-0">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-white">{{ $task->title }}</h3>
                                <p class="text-[10px] text-slate-500">{{ $task->assignedUser?->name ?? 'Teknisyen' }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono text-slate-400 bg-slate-900 px-2 py-1 rounded-lg border border-slate-800">
                            {{ $task->completed_at?->format('d.m.Y') }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 bg-slate-950 rounded-2xl border border-slate-800 text-slate-500 text-xs font-mono">
                        Henüz tamamlanmış servis kaydı bulunmuyor.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Authorized Panel Access Action -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-5 text-center space-y-3">
            <p class="text-xs text-slate-400">Saha teknisyeni veya yönetici girişi yaparak sayaç değeri veya arıza kaydı girin.</p>
            <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold py-3 rounded-xl text-xs transition shadow-lg shadow-amber-500/20">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>Yetkili Girişi Yap</span>
            </a>
        </div>

    </main>

    <footer class="text-center py-4 text-slate-600 text-[10px] font-mono uppercase tracking-widest border-t border-slate-900">
        &copy; {{ date('Y') }} KeepADA CMMS &bull; Tüm Hakları Saklıdır.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>

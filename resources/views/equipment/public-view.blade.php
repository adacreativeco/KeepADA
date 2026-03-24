<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $equipment->name }} | KeepADA CMMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen">
    <!-- Header -->
    <nav class="bg-white shadow-sm border-b sticky top-0 z-10">
        <div class="max-w-lg mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wrench text-white text-sm"></i>
                </div>
                <span class="font-bold text-slate-800 tracking-tight">KeepADA <span class="text-indigo-600">CMMS</span></span>
            </div>
            <span class="text-[10px] font-bold bg-indigo-50 text-indigo-700 px-2 py-1 rounded-full uppercase tracking-wider">Ekipman Künyesi</span>
        </div>
    </nav>

    <main class="max-w-lg mx-auto px-4 py-6 pb-20">
        <!-- Equipment Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1 block">{{ $equipment->category }}</span>
                        <h1 class="text-2xl font-bold text-slate-900 leading-tight">{{ $equipment->name }}</h1>
                        <p class="text-sm text-slate-500 mt-1 font-mono">ID: {{ $equipment->code }}</p>
                    </div>
                    <div class="px-3 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $equipment->status === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' }}">
                        {{ $equipment->status === 'active' ? 'Aktif' : 'Pasif' }}
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <span class="text-[10px] text-slate-500 uppercase block mb-1">Lokasyon</span>
                        <span class="text-sm font-semibold text-slate-800 truncate block">{{ $equipment->location->name }}</span>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <span class="text-[10px] text-slate-500 uppercase block mb-1">Tedarikçi</span>
                        <span class="text-sm font-semibold text-slate-800 truncate block">{{ $equipment->supplier->name ?? 'Belirtilmedi' }}</span>
                    </div>
                </div>

                <!-- Maintenance Info -->
                <div class="bg-indigo-600 rounded-xl p-4 text-white shadow-lg shadow-indigo-200 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-robot text-white"></i>
                        </div>
                        <div>
                            <span class="text-[10px] text-indigo-100 uppercase block">Tahmini Bir Sonraki Bakım</span>
                            <span class="text-lg font-bold">{{ $equipment->predictive_next_due_date?->format('d.m.Y') ?? 'Veri Bekleniyor' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Technical Specs -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-500">Marka / Model</span>
                        <span class="text-sm font-medium text-slate-800">{{ $equipment->brand ?? '-' }} / {{ $equipment->model ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-500">Seri No</span>
                        <span class="text-sm font-medium text-slate-800">{{ $equipment->serial_number ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-sm text-slate-500">Garanti Bitiş</span>
                        <span class="text-sm font-medium {{ $equipment->warranty_end_date && $equipment->warranty_end_date->isPast() ? 'text-rose-600' : 'text-slate-800' }}">
                            {{ $equipment->warranty_end_date?->format('d.m.Y') ?? 'Belirtilmedi' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance History -->
        <div class="mb-6">
            <h2 class="text-lg font-bold text-slate-900 mb-4 px-1 flex items-center gap-2">
                <i class="fas fa-history text-slate-400"></i>
                Bakım Geçmişi
            </h2>
            <div class="space-y-3">
                @forelse($equipment->maintenanceTasks()->where('status', 'done')->latest('completed_at')->take(5)->get() as $task)
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-xs">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">{{ $task->title }}</h3>
                            <p class="text-[11px] text-slate-500 italic">{{ $task->assignedUser->name ?? 'Teknisyen' }}</p>
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded">{{ $task->completed_at?->format('d.m.Y') }}</span>
                </div>
                @empty
                <div class="text-center py-8 bg-slate-100/50 rounded-2xl border-2 border-dashed border-slate-200">
                    <i class="fas fa-info-circle text-slate-300 text-2xl mb-2"></i>
                    <p class="text-sm text-slate-400">Henüz tamamlanmış bakım bulunmuyor.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Support Info -->
        <div class="bg-slate-800 rounded-2xl p-6 text-white text-center">
            <p class="text-sm text-slate-300 mb-4 font-medium">Bu ekipman KeepADA CMMS ile profesyonel olarak takip edilmektedir.</p>
            <a href="/admin/login" class="inline-block bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-lg font-bold text-sm transition-colors">Yönetim Paneline Git</a>
        </div>
    </main>

    <!-- Footer Meta -->
    <footer class="text-center py-6 text-slate-400 text-[10px] uppercase tracking-widest">
        &copy; {{ date('Y') }} KeepADA CMMS - Tüm Hakları Saklıdır.
    </footer>
</body>
</html>

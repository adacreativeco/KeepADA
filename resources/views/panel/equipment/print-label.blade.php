<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Etiket: {{ $equipment->code }} - {{ $equipment->name }} | KeepADA CMMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0b111e;
            color: #ffffff;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        @media print {
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                box-shadow: none !important;
                border: 2px solid #000000 !important;
                background-color: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                page-break-inside: avoid;
            }
            .print-text-black {
                color: #000000 !important;
            }
            .print-border-black {
                border-color: #000000 !important;
            }
            .print-bg-black {
                background-color: #000000 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .print-bg-gray {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-8">

    <!-- Top Action Bar (Hidden on print) -->
    <div class="no-print w-full max-w-xl mb-6 flex items-center justify-between">
        <a href="{{ route('panel.equipment.show', ['company' => $currentCompany->slug, 'equipment' => $equipment->id]) }}" class="text-xs font-mono text-slate-400 hover:text-white flex items-center gap-1.5 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Ekipman Detayına Dön</span>
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-lg shadow-amber-500/20 flex items-center gap-2 transition">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Etiketi Yazdır (Print)</span>
            </button>
        </div>
    </div>

    <!-- Industrial Asset Tag Label Container -->
    <div class="print-container w-full max-w-xl bg-slate-900 border-2 border-slate-700 rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
        
        <!-- Header Strip -->
        <div class="print-bg-black bg-slate-950 -mx-6 -mt-6 sm:-mx-8 sm:-mt-8 p-4 px-6 sm:px-8 border-b-2 border-slate-700 print-border-black flex justify-between items-center mb-6">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center text-slate-950 font-black text-sm">
                    K
                </div>
                <div>
                    <div class="font-extrabold text-sm tracking-tight text-white print-text-black">KeepADA CMMS</div>
                    <div class="text-[10px] font-mono text-slate-400 print-text-black">{{ $company->name }} &bull; Varlık Etiketi</div>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-block px-2.5 py-1 rounded bg-amber-500/20 print-bg-gray text-amber-400 print-text-black text-xs font-mono font-bold border border-amber-500/30 print-border-black">
                    ASSET TAG
                </span>
            </div>
        </div>

        <!-- Main Body: QR Code + Asset Specs -->
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-6 items-center">
            
            <!-- QR Code Box -->
            <div class="sm:col-span-5 flex flex-col items-center text-center">
                <div class="bg-white p-3 rounded-2xl shadow-md border-2 border-slate-700 print-border-black inline-block">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($publicPassportUrl) }}&margin=0" alt="QR Code" class="w-36 h-36 object-contain block mx-auto">
                </div>
                <div class="text-[10px] font-mono text-slate-400 print-text-black mt-2 font-semibold">
                    Akıllı Karne / QR Kod
                </div>
            </div>

            <!-- Asset Information Specs -->
            <div class="sm:col-span-7 space-y-3">
                <div>
                    <div class="text-[10px] font-mono uppercase tracking-wider text-slate-400 print-text-black">Ekipman / Varlık Kodu</div>
                    <div class="text-2xl sm:text-3xl font-black font-mono text-amber-400 print-text-black tracking-tight">{{ $equipment->code }}</div>
                </div>

                <div>
                    <div class="text-[10px] font-mono uppercase tracking-wider text-slate-400 print-text-black">Ekipman Tanımı</div>
                    <div class="text-base font-extrabold text-white print-text-black leading-tight">{{ $equipment->name }}</div>
                    <div class="text-xs text-slate-400 print-text-black">{{ $equipment->brand }} {{ $equipment->model }}</div>
                </div>

                <div class="pt-2 border-t border-slate-800 print-border-black space-y-1.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-400 print-text-black font-medium">Lokasyon:</span>
                        <span class="font-bold text-slate-200 print-text-black">{{ $equipment->location?->name ?? 'Belirtilmedi' }}</span>
                    </div>
                    @if($equipment->serial_number)
                        <div class="flex justify-between font-mono">
                            <span class="text-slate-400 print-text-black">Seri No:</span>
                            <span class="text-slate-300 print-text-black">{{ $equipment->serial_number }}</span>
                        </div>
                    @endif
                    @if($equipment->category)
                        <div class="flex justify-between">
                            <span class="text-slate-400 print-text-black">Kategori:</span>
                            <span class="text-slate-300 print-text-black">{{ $equipment->category }}</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Footer Instructions -->
        <div class="mt-6 pt-4 border-t-2 border-slate-800 print-border-black flex items-center justify-between text-[10px] text-slate-400 print-text-black">
            <div class="flex items-center gap-1.5">
                <i data-lucide="scan" class="w-3.5 h-3.5 text-amber-400 print-text-black"></i>
                <span>Arıza bildirimi &amp; bakım geçmişi için kameranızla QR kodu okutunuz.</span>
            </div>
            <div class="font-mono font-semibold">{{ date('Y') }} &bull; KeepADA</div>
        </div>

    </div>

    <!-- Print Tip for User (Hidden on print) -->
    <div class="no-print max-w-xl mt-4 text-center text-xs text-slate-500 font-mono">
        İpucu: Yazıcı ayarlarından "Arka Plan Grafikleri" seçeneğini işaretleyerek en iyi sonucu alabilirsiniz.
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

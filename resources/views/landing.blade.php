<!DOCTYPE html>
<html lang="tr" class="scroll-smooth bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeepADA CMMS | Akıllı Varlık, Ekipman ve Periyodik Bakım Platformu</title>
    
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
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-amber-500 selection:text-slate-950">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-slate-950/80 backdrop-blur-md border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-tr from-amber-600 to-amber-400 rounded-xl flex items-center justify-center text-slate-950 shadow-lg shadow-amber-500/20">
                        <i data-lucide="wrench" class="w-5 h-5 text-slate-950"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-white">KeepADA <span class="text-amber-400">CMMS</span></span>
                </a>
                <div class="hidden md:flex items-center gap-8 text-xs font-mono uppercase tracking-wider text-slate-400">
                    <a href="#features" class="hover:text-amber-400 transition-colors">Özellikler</a>
                    <a href="#solutions" class="hover:text-amber-400 transition-colors">Modüller</a>
                    <a href="#pricing" class="hover:text-amber-400 transition-colors">Planlar</a>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Language Switcher -->
                    <div class="flex items-center bg-slate-900 border border-slate-800 rounded-xl p-1 text-[11px] font-mono font-bold">
                        <a href="{{ route('lang.switch', 'tr') }}" class="px-2 py-1 rounded-lg transition {{ app()->getLocale() === 'tr' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white' }}">TR</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-1 rounded-lg transition {{ app()->getLocale() === 'en' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white' }}">EN</a>
                        <a href="{{ route('lang.switch', 'de') }}" class="px-2 py-1 rounded-lg transition {{ app()->getLocale() === 'de' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white' }}">DE</a>
                    </div>

                    @auth
                        <a href="{{ route('panel.dashboard', ['company' => auth()->user()->companies()->first()?->slug ?? 'keepada-demo']) }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-lg shadow-amber-500/20 flex items-center gap-2">
                            <span>Yönetim Paneli</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-slate-300 hover:text-white px-3 py-2 transition-colors">Giriş Yap</a>
                        <a href="{{ route('register') }}" class="bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold px-4 py-2.5 rounded-xl transition-all shadow-lg shadow-amber-500/20 active:scale-95 flex items-center gap-1.5">
                            <span>Tesis Başlat</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 md:pt-48 md:pb-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-amber-500/10 via-slate-950 to-slate-950 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-amber-500/10 border border-amber-500/20 text-amber-400 px-4 py-1.5 rounded-full text-xs font-mono mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                        Yapay Zeka Destekli Endüstriyel Bakım Yönetimi
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-[1.1] mb-6 tracking-tight">
                        Tesisinizi <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-200">Kesintisiz</span> Yönetin, Arızaları Önleyin.
                    </h1>
                    <p class="text-base sm:text-lg text-slate-400 mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        KeepADA CMMS ile tüm makine ve ekipmanlarınızın dijital QR pasaportunu oluşturun, periyodik bakım planlarını otomatikleştirin ve duruş sürelerini %35 azaltın.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-8 py-4 rounded-2xl transition-all shadow-xl shadow-amber-500/25 text-center flex items-center justify-center gap-2 text-sm">
                            <span>Hemen Ücretsiz Deneyin</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white font-bold px-8 py-4 rounded-2xl transition-all text-center text-sm">
                            Demo Girişi
                        </a>
                    </div>
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-6 text-slate-400 text-xs font-mono">
                        <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4 text-amber-400"></i> <span>Bulut Tabanlı</span></div>
                        <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4 text-amber-400"></i> <span>Mobil Uyumlu QR</span></div>
                        <div class="flex items-center gap-2"><i data-lucide="check-circle" class="w-4 h-4 text-amber-400"></i> <span>Sıfır Bağımlılık</span></div>
                    </div>
                </div>

                <!-- Interactive Hero Preview Card -->
                <div class="lg:col-span-5 relative">
                    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            </div>
                            <span class="text-[10px] font-mono text-slate-500">KeepADA CMMS Terminal</span>
                        </div>
                        <div class="space-y-3 font-mono text-xs">
                            <div class="p-3 rounded-xl bg-slate-950 border border-slate-800 flex justify-between items-center">
                                <div>
                                    <div class="text-white font-bold">[HK-001] Vidalı Kompresör</div>
                                    <div class="text-[10px] text-slate-500">Çalışma Saati: 4.850 saat</div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 text-[10px] border border-emerald-500/20">Aktif</span>
                            </div>
                            <div class="p-3 rounded-xl bg-slate-950 border border-slate-800 flex justify-between items-center">
                                <div>
                                    <div class="text-white font-bold">500 Saatlik Yağ Filtresi Bakımı</div>
                                    <div class="text-[10px] text-amber-400">Hedef: Yarın 09:00 (SLA: 24h)</div>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-400 text-[10px] border border-amber-500/20">Planlandı</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-900/50 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
            <h2 class="text-xs font-bold text-amber-400 uppercase tracking-[0.2em] font-mono mb-4">ÖZELLİKLER</h2>
            <p class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">İşletmenizin İhtiyacı Olan Her Şey</p>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="p-8 bg-slate-900 rounded-3xl border border-slate-800 hover:border-amber-500/30 transition-all duration-300 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-amber-500/10 text-amber-400 rounded-2xl flex items-center justify-center mb-6">
                    <i data-lucide="qr-code" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">QR Kodlu Dijital Pasaport</h3>
                <p class="text-slate-400 leading-relaxed text-sm">Her makineye yapıştırılan QR kodu telefon kamerasıyla okutan saha teknisyeni, anında bakım karnesine ve sayaç formuna erişir.</p>
            </div>
            <!-- Feature 2 -->
            <div class="p-8 bg-slate-900 rounded-3xl border border-slate-800 hover:border-amber-500/30 transition-all duration-300 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-blue-500/10 text-blue-400 rounded-2xl flex items-center justify-center mb-6">
                    <i data-lucide="brain-circuit" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Öngörülü Bakım Algoritması</h3>
                <p class="text-slate-400 leading-relaxed text-sm">Geçmiş bakım sıklıklarını ve sayaç verilerini analiz eden motor, arıza oluşmadan önce sonraki servis tarihini tahmin eder.</p>
            </div>
            <!-- Feature 3 -->
            <div class="p-8 bg-slate-900 rounded-3xl border border-slate-800 hover:border-amber-500/30 transition-all duration-300 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-2xl flex items-center justify-center mb-6">
                    <i data-lucide="package" class="w-7 h-7"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-4">Otomatik Stok ve Sarfiyat</h3>
                <p class="text-slate-400 leading-relaxed text-sm">İş emrinde kullanılan filtre, rulman ve yağlar anında stoktan düşer. Minimum kritik eşikte sistem acil uyarı verir.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800/80 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center text-slate-950">
                    <i data-lucide="wrench" class="w-4 h-4"></i>
                </div>
                <span class="text-lg font-extrabold tracking-tight">KeepADA <span class="text-amber-400">CMMS</span></span>
            </div>
            <p class="text-slate-500 text-xs font-mono">&copy; 2026 KeepADA CMMS. Tüm Hakları Saklıdır.</p>
            <div class="flex gap-4 text-xs text-slate-400">
                <a href="{{ route('login') }}" class="hover:text-amber-400">Yönetim Girişi</a>
                <a href="{{ route('register') }}" class="hover:text-amber-400">Kayıt Ol</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>

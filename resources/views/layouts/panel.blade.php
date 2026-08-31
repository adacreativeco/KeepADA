<!DOCTYPE html>
<html lang="tr" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KeepADA CMMS') · Akıllı Varlık & Bakım Platformu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        navy: {
                            800: '#111c38',
                            900: '#0b1329',
                            950: '#070b19',
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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Chart.js & FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <!-- HTML5 QR Code Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        [x-cloak] { display: none !important; }
        #qr-reader video { border-radius: 1rem; width: 100% !important; }
    </style>
    @stack('styles')
</head>
<body class="h-full antialiased bg-slate-950 text-slate-100 flex flex-col" x-data="qrScannerManager()">

    <div class="flex h-full min-h-screen">

        <!-- Off-canvas Sidebar for Mobile -->
        <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-cloak>
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" @click="sidebarOpen = false"></div>

            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
                    <div class="flex flex-col gap-y-5 overflow-y-auto bg-slate-900 border-r border-slate-800 px-6 pb-4">
                        @include('layouts.partials.sidebar-content')
                    </div>
                </div>
            </div>
        </div>

        <!-- Static Desktop Sidebar -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-72 lg:flex-col bg-slate-900 border-r border-slate-800/80">
            <div class="flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4">
                @include('layouts.partials.sidebar-content')
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:pl-72 flex flex-col flex-1 min-w-0">

            <!-- Top Navigation Bar -->
            <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-800 bg-slate-900/90 backdrop-blur px-4 sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-slate-400 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Menüyü aç</span>
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>

                <div class="h-6 w-px bg-slate-800 lg:hidden" aria-hidden="true"></div>

                <!-- Breadcrumbs & Tenant Indicator -->
                <div class="flex flex-1 items-center gap-x-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(245,158,11,0.5)]"></span>
                        <span class="text-xs font-mono uppercase tracking-widest text-amber-400 font-bold">{{ $currentCompany->name }}</span>
                    </div>
                    <span class="text-slate-600 hidden sm:inline">/</span>
                    <span class="text-sm font-medium text-slate-300 hidden sm:inline">@yield('title', 'Yönetim Paneli')</span>
                </div>

                <!-- Right Nav Items -->
                <div class="flex items-center gap-x-3 lg:gap-x-4">
                    
                    <!-- Live Camera QR Scanner Trigger Button -->
                    <button type="button" @click="openScanner()" class="text-xs font-bold text-slate-950 bg-amber-500 hover:bg-amber-400 transition flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl shadow-md shadow-amber-500/20">
                        <i data-lucide="scan-line" class="w-4 h-4"></i>
                        <span>{{ __('cmms.qr_scan') }}</span>
                    </button>

                    <!-- Language Switcher Dropdown -->
                    <div class="relative" x-data="{ langOpen: false }">
                        <button type="button" @click="langOpen = !langOpen" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-slate-950/60 border border-slate-800 hover:border-slate-700 text-xs font-mono font-bold text-slate-300 transition">
                            @if(app()->getLocale() === 'en')
                                <span>🇬🇧 EN</span>
                            @elseif(app()->getLocale() === 'de')
                                <span>🇩🇪 DE</span>
                            @else
                                <span>🇹🇷 TR</span>
                            @endif
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-500"></i>
                        </button>

                        <div x-show="langOpen" @click.outside="langOpen = false" x-transition class="absolute right-0 z-50 mt-2 w-32 rounded-xl bg-slate-900 border border-slate-800 p-1 shadow-2xl space-y-0.5" x-cloak>
                            <a href="{{ route('lang.switch', 'tr') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-mono transition {{ app()->getLocale() === 'tr' ? 'bg-amber-500/10 text-amber-400 font-bold' : 'text-slate-300 hover:bg-slate-800' }}">
                                <span>🇹🇷</span> <span>Türkçe</span>
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-mono transition {{ app()->getLocale() === 'en' ? 'bg-amber-500/10 text-amber-400 font-bold' : 'text-slate-300 hover:bg-slate-800' }}">
                                <span>🇬🇧</span> <span>English</span>
                            </a>
                            <a href="{{ route('lang.switch', 'de') }}" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-mono transition {{ app()->getLocale() === 'de' ? 'bg-amber-500/10 text-amber-400 font-bold' : 'text-slate-300 hover:bg-slate-800' }}">
                                <span>🇩🇪</span> <span>Deutsch</span>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('home') }}" target="_blank" class="text-xs text-slate-400 hover:text-slate-200 transition flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 bg-slate-950/50">
                        <i data-lucide="globe" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span class="hidden sm:inline">{{ __('cmms.website') }}</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" class="flex items-center gap-x-3 p-1.5 text-sm font-semibold leading-6 text-slate-200 hover:text-white" @click="open = !open">
                            <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center font-bold font-mono text-amber-400 text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 z-50 mt-2.5 w-52 rounded-xl bg-slate-900 border border-slate-800 p-2 shadow-2xl" x-cloak>
                            <div class="px-3 py-2 border-b border-slate-800 mb-1">
                                <div class="text-xs font-semibold text-white">{{ auth()->user()->name }}</div>
                                <div class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</div>
                            </div>
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-rose-400 hover:bg-rose-500/10 rounded-lg transition text-left">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    <span>Güvenli Çıkış Yap</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 px-4 py-3 rounded-xl flex items-center gap-3 text-sm">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-6 bg-rose-500/10 border border-rose-500/20 text-rose-300 px-4 py-3 rounded-xl flex items-center gap-3 text-sm">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-400 shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-6 bg-rose-500/10 border border-rose-500/20 text-rose-300 px-4 py-3 rounded-xl text-sm space-y-1">
                    <div class="font-bold flex items-center gap-2 mb-1">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400"></i>
                        <span>Lütfen formdaki hataları kontrol ediniz:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-200">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Body View -->
            <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="border-t border-slate-800/80 py-4 px-6 text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2">
                <div>© 2026 KeepADA CMMS. Tüm hakları saklıdır.</div>
                <div class="flex items-center gap-3 font-mono text-[11px] text-slate-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Tesis: {{ $currentCompany->name }}</span>
                    <span>•</span>
                    <span>Sürüm v2.0-custom</span>
                </div>
            </footer>

        </div>

    </div>

    <!-- Live Camera QR Scanner Modal -->
    <div x-show="scannerModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-md" @click="closeScanner()"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl space-y-4">
                
                <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center">
                            <i data-lucide="scan" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">Canlı QR Kod Tarayıcı</h3>
                            <p class="text-[11px] text-slate-400">Makine üzerindeki etiketi kameraya gösterin</p>
                        </div>
                    </div>
                    <button type="button" @click="closeScanner()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Video Viewport -->
                <div class="relative bg-slate-950 rounded-2xl overflow-hidden border border-slate-800 min-h-[250px] flex items-center justify-center">
                    <div id="qr-reader" class="w-full"></div>
                    <div x-show="scanLoading" class="absolute inset-0 bg-slate-950/80 flex flex-col items-center justify-center gap-2 text-xs text-amber-400">
                        <i data-lucide="loader-2" class="w-6 h-6 animate-spin"></i>
                        <span>Kamera başlatılıyor...</span>
                    </div>
                </div>

                <!-- Manual Code Fallback -->
                <div class="pt-2 border-t border-slate-800">
                    <form @submit.prevent="handleManualSearch()" class="flex gap-2">
                        <input type="text" x-model="manualCode" placeholder="veya kodu elle girin (örn: HK-001)" class="flex-1 bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs text-white placeholder-slate-500 focus:border-amber-400 focus:outline-none font-mono">
                        <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-amber-400 font-bold px-4 py-2 rounded-xl text-xs transition">
                            Git
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function qrScannerManager() {
            return {
                sidebarOpen: false,
                scannerModalOpen: false,
                scanLoading: false,
                manualCode: '',
                html5QrCode: null,

                openScanner() {
                    this.scannerModalOpen = true;
                    this.scanLoading = true;

                    this.$nextTick(() => {
                        try {
                            this.html5QrCode = new Html5Qrcode("qr-reader");
                            this.html5QrCode.start(
                                { facingMode: "environment" },
                                { fps: 10, qrbox: { width: 220, height: 220 } },
                                (decodedText) => {
                                    this.onScanSuccess(decodedText);
                                },
                                (error) => {}
                            ).then(() => {
                                this.scanLoading = false;
                            }).catch(err => {
                                console.warn("Camera init error:", err);
                                this.scanLoading = false;
                            });
                        } catch (e) {
                            console.error(e);
                            this.scanLoading = false;
                        }
                    });
                },

                closeScanner() {
                    if (this.html5QrCode) {
                        this.html5QrCode.stop().then(() => {
                            this.html5QrCode.clear();
                            this.html5QrCode = null;
                        }).catch(err => {});
                    }
                    this.scannerModalOpen = false;
                    this.scanLoading = false;
                },

                onScanSuccess(decodedText) {
                    this.closeScanner();
                    
                    // If it's a full URL e.g. https://.../e/HK-001
                    if (decodedText.includes('/e/')) {
                        const parts = decodedText.split('/e/');
                        const code = parts[parts.length - 1].trim();
                        window.location.href = "{{ url('panel/' . $currentCompany->slug . '/equipment') }}?search=" + encodeURIComponent(code);
                    } else {
                        // Direct equipment code
                        window.location.href = "{{ url('panel/' . $currentCompany->slug . '/equipment') }}?search=" + encodeURIComponent(decodedText.trim());
                    }
                },

                handleManualSearch() {
                    if (!this.manualCode.trim()) return;
                    this.closeScanner();
                    window.location.href = "{{ url('panel/' . $currentCompany->slug . '/equipment') }}?search=" + encodeURIComponent(this.manualCode.trim());
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>

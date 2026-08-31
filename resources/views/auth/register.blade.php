<!DOCTYPE html>
<html lang="tr" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tesis Kaydı Oluştur · KeepADA CMMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
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
<body class="h-full antialiased bg-slate-950 flex items-center justify-center p-4">

    <div class="w-full max-w-lg">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-600 to-amber-400 items-center justify-center text-slate-950 shadow-xl shadow-amber-500/20 mb-4">
                <i data-lucide="wrench" class="w-7 h-7 text-slate-950"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">KeepADA <span class="text-amber-400">CMMS</span></h1>
            <p class="text-xs text-slate-400 mt-1">Yeni Tesis ve Şirket Hesabı Başlatın</p>
        </div>

        <!-- Register Card -->
        <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-2xl">
            
            <h2 class="text-lg font-bold text-white mb-6">Tesisinizi Kaydedin</h2>

            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/20 text-rose-300 px-4 py-3 rounded-xl text-xs space-y-1">
                    @foreach($errors->all() as $err)
                        <div class="flex items-center gap-2">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400 shrink-0"></i>
                            <span>{{ $err }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-1.5">Şirket / Tesis Adı *</label>
                    <div class="relative">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" required placeholder="Örn: Anadolu İmalat A.Ş." class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-1.5">Adınız Soyadınız *</label>
                    <div class="relative">
                        <i data-lucide="user" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ad Soyad" class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase text-slate-400 mb-1.5">İş E-postası *</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="ornek@sirket.com" class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1.5">Şifre *</label>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:border-amber-400 focus:outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase text-slate-400 mb-1.5">Şifre Tekrarı *</label>
                        <div class="relative">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full bg-slate-950 border border-slate-800 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:border-amber-400 focus:outline-none transition">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold py-3.5 rounded-xl text-sm transition-all shadow-lg shadow-amber-500/25 flex items-center justify-center gap-2 mt-4">
                    <span>Tesis Hesabını Başlat</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-800 text-center">
                <p class="text-xs text-slate-400">
                    Zaten hesabınız var mı? 
                    <a href="{{ route('login') }}" class="text-amber-400 font-semibold hover:underline">Giriş Yap</a>
                </p>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>

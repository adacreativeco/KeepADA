<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeepADA CMMS | Akıllı Bakım ve Varlık Yönetim Sistemi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-effect { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
        .hero-gradient { background: radial-gradient(circle at top right, #eef2ff 0%, #ffffff 100%); }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass-effect border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <i class="fas fa-wrench text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">KeepADA <span class="text-indigo-600">CMMS</span></span>
                </div>
                <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#features" class="hover:text-indigo-600 transition-colors">Özellikler</a>
                    <a href="#solutions" class="hover:text-indigo-600 transition-colors">Çözümler</a>
                    <a href="#pricing" class="hover:text-indigo-600 transition-colors">Fiyatlandırma</a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/admin/login" class="text-sm font-bold text-slate-700 hover:text-indigo-600 px-4 py-2 transition-colors">Giriş Yap</a>
                    <a href="/admin/register" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-100 active:scale-95">Ücretsiz Başla</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 md:pt-48 md:pb-32 hero-gradient overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-xs font-bold mb-6 animate-bounce">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        Yapay Zeka Destekli Bakım Yönetimi
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 leading-[1.1] mb-6 tracking-tight">
                        Tesisinizi <span class="text-indigo-600 italic">Akıllıca</span> Yönetin, Arızaları Durdurun.
                    </h1>
                    <p class="text-lg text-slate-600 mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        KeepADA ile ekipmanlarınızın ömrünü uzatın, bakım maliyetlerini %30 azaltın ve duruş sürelerini yapay zeka ile önceden tahmin edin.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <a href="/admin/register" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-4 rounded-2xl transition-all shadow-xl shadow-indigo-200 text-center">
                            Hemen Keşfedin
                        </a>
                        <a href="#features" class="w-full sm:w-auto bg-white border border-slate-200 hover:border-indigo-200 text-slate-700 font-bold px-8 py-4 rounded-2xl transition-all text-center">
                            Özellikleri İncele
                        </a>
                    </div>
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-6 text-slate-400">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> <span class="text-xs font-medium">Bulut Tabanlı</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> <span class="text-xs font-medium">Mobil Uyumlu</span></div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> <span class="text-xs font-medium">Hızlı Kurulum</span></div>
                    </div>
                </div>
                <div class="relative lg:ml-10">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
                    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-100 rounded-full blur-3xl opacity-50"></div>
                    <img src="https://filamentphp.com/images/screenshot.png" alt="KeepADA Dashboard" class="relative rounded-3xl shadow-2xl border border-slate-200 transform hover:-translate-y-2 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
            <h2 class="text-xs font-bold text-indigo-600 uppercase tracking-[0.2em] mb-4">ÖZELLİKLER</h2>
            <p class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">İşletmenizin İhtiyacı Olan Her Şey</p>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group p-8 bg-slate-50 rounded-3xl border border-transparent hover:border-indigo-100 hover:bg-white transition-all duration-300 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-qrcode text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">QR Kod Entegrasyonu</h3>
                <p class="text-slate-600 leading-relaxed text-sm">Her ekipmana özel QR kodlar ile saha personeli saniyeler içinde tüm geçmişe ve teknik verilere ulaşır.</p>
            </div>
            <!-- Feature 2 -->
            <div class="group p-8 bg-slate-50 rounded-3xl border border-transparent hover:border-indigo-100 hover:bg-white transition-all duration-300 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-brain text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">AI Bakım Tahmini</h3>
                <p class="text-slate-600 leading-relaxed text-sm">Geçmiş verileri analiz eden algoritmalarımız, arıza çıkmadan önce sizi uyarır ve bakım takvimini optimize eder.</p>
            </div>
            <!-- Feature 3 -->
            <div class="group p-8 bg-slate-50 rounded-3xl border border-transparent hover:border-indigo-100 hover:bg-white transition-all duration-300 shadow-sm hover:shadow-xl">
                <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-box-open text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-4">Akıllı Stok Yönetimi</h3>
                <p class="text-slate-600 leading-relaxed text-sm">Yedek parça stoklarınız kritik seviyeye düştüğünde anlık uyarı alın, iş emirleriyle stokları otomatik düşürün.</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-indigo-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-8 text-center text-white">
            <div>
                <p class="text-4xl font-extrabold mb-2">%35</p>
                <p class="text-indigo-100 text-sm font-medium">Maliyet Tasarrufu</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold mb-2">10k+</p>
                <p class="text-indigo-100 text-sm font-medium">Takip Edilen Varlık</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold mb-2">%99</p>
                <p class="text-indigo-100 text-sm font-medium">SLA Başarı Oranı</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold mb-2">24/7</p>
                <p class="text-indigo-100 text-sm font-medium">Kesintisiz İzleme</p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
            <h2 class="text-xs font-bold text-indigo-600 uppercase tracking-[0.2em] mb-4">FİYATLANDIRMA</h2>
            <p class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Size Uygun Planı Seçin</p>
        </div>
        <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-8 px-4">
            <!-- Basics -->
            <div class="bg-white p-10 rounded-3xl border border-slate-100 shadow-sm flex flex-col">
                <h3 class="text-lg font-bold mb-2">Başlangıç</h3>
                <p class="text-slate-500 text-sm mb-6">Küçük tesisler için ideal.</p>
                <p class="text-4xl font-extrabold mb-8">$29<span class="text-sm text-slate-400 font-normal">/ay</span></p>
                <ul class="space-y-4 mb-10 text-sm text-slate-600 flex-1">
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> 100 Ekipmana Kadar</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> Temel Bakım Takvimi</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> QR Kod Desteği</li>
                </ul>
                <a href="/admin/register" class="block w-full py-3 rounded-xl border border-slate-200 text-center font-bold hover:bg-slate-50 transition-colors">Hemen Başla</a>
            </div>
            <!-- Professional -->
            <div class="bg-white p-10 rounded-3xl border-2 border-indigo-600 shadow-xl relative scale-105 flex flex-col">
                <span class="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-[10px] font-bold px-4 py-1 rounded-full uppercase tracking-widest">EN POPÜLER</span>
                <h3 class="text-lg font-bold mb-2">Profesyonel</h3>
                <p class="text-slate-500 text-sm mb-6">Büyüyen işletmeler için.</p>
                <p class="text-4xl font-extrabold mb-8">$79<span class="text-sm text-slate-400 font-normal">/ay</span></p>
                <ul class="space-y-4 mb-10 text-sm text-slate-600 flex-1">
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> Sınırsız Ekipman</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> Yedek Parça & Stok</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> SLA & Gecikme Takibi</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> Sayaç Bazlı Bakım</li>
                </ul>
                <a href="/admin/register" class="block w-full py-3 rounded-xl bg-indigo-600 text-white text-center font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Hemen Başla</a>
            </div>
            <!-- Enterprise -->
            <div class="bg-white p-10 rounded-3xl border border-slate-100 shadow-sm flex flex-col">
                <h3 class="text-lg font-bold mb-2">Kurumsal</h3>
                <p class="text-slate-500 text-sm mb-6">Tam otomasyon isteyenler.</p>
                <p class="text-4xl font-extrabold mb-8">$199<span class="text-sm text-slate-400 font-normal">/ay</span></p>
                <ul class="space-y-4 mb-10 text-sm text-slate-600 flex-1">
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> AI Bakım Tahmini</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> Özel Rapor Oluşturucu</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> API Erişimi</li>
                    <li><i class="fas fa-check text-indigo-500 mr-2"></i> Öncelikli Destek</li>
                </ul>
                <a href="/admin/register" class="block w-full py-3 rounded-xl border border-slate-200 text-center font-bold hover:bg-slate-50 transition-colors">Bize Ulaşın</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-4 gap-12">
            <div class="col-span-2">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wrench text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight">KeepADA <span class="text-indigo-500">CMMS</span></span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm mb-8">
                    Türkiye'nin en modern ve kullanıcı dostu bakım yönetim sistemi. Saha personeli için tasarlandı, yöneticiler için güçlendirildi.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-indigo-600 transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-indigo-600 transition-colors"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center hover:bg-indigo-600 transition-colors"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-6">Ürün</h4>
                <ul class="text-slate-400 text-sm space-y-4 font-medium">
                    <li><a href="#" class="hover:text-white transition-colors">Özellikler</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">AI Tahminleme</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Mobil Uygulama</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6">Şirket</h4>
                <ul class="text-slate-400 text-sm space-y-4 font-medium">
                    <li><a href="#" class="hover:text-white transition-colors">Hakkımızda</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Kullanım Koşulları</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Gizlilik Politikası</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">İletişim</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-slate-800 mt-16 pt-8 text-center">
            <p class="text-slate-500 text-xs font-medium uppercase tracking-widest">&copy; 2026 KeepADA CMMS. Tüm Hakları Saklıdır.</p>
        </div>
    </footer>
</body>
</html>

# KeepADA CMMS 🛠️⚡

<div align="center">

**Akıllı Varlık Yönetimi, İş Emri Planlama ve Kestirimci Bakım Platformu**

[![Dil: Türkçe](https://img.shields.io/badge/Dil-T%C3%BCrk%C3%A7e-red?style=for-the-badge)](README.tr.md)
[![Dil: English](https://img.shields.io/badge/Language-English-blue?style=for-the-badge)](README.md)
[![Dil: Deutsch](https://img.shields.io/badge/Sprache-Deutsch-yellow?style=for-the-badge)](README.de.md)

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Lisans: Apache 2.0](https://img.shields.io/badge/Lisans-Apache_2.0-blue.svg?style=for-the-badge)](LICENSE)

[ 🇹🇷 Türkçe ](README.tr.md) • [ 🇬🇧 English ](README.md) • [ 🇩🇪 Deutsch ](README.de.md)

</div>

---

![KeepADA CMMS Dashboard](docs/screenshots/dashboard.png)

## 📌 Genel Bakış

**KeepADA CMMS**, üretim tesisleri, fabrikalar, endüstriyel işletmeler ve teknik saha operasyonları için geliştirilmiş modern, yüksek performanslı ve çok kiracılı (multi-tenant) bir Bilgisayarlı Bakım Yönetim Sistemidir (CMMS). **Laravel 12** üzerinde sıfırdan inşa edilen KeepADA; ultra hızlı yanıt süreleri, özel endüstriyel koyu tema estetiği ve sıfır bağımlılık fazlalığı (zero bloat) sunar.

---

## ✨ Öne Çıkan Modüller ve Özellikler

### 1. ⚙️ Ekipman ve Varlık Yönetimi
- **Dijital Ekipman Envanteri:** Marka, model, seri numarası, kategori, garanti bitişi ve lokasyon bazlı tam yaşam döngüsü takibi.
- **🧠 Yapay Zeka Destekli Kestirimci Bakım:** Ekipmanın geçmiş arıza sıklığı ve sayaç hızına göre bir sonraki olası arıza/bakım zamanını tahmin eden AI algoritması.
- **⏱️ Çalışma Saati ve Sayaç Takibi:** Saat, kilometre veya baskı adedi bazında sayaç girişi ve eşik aşımlarında otomatik uyarılar.
- **🏷️ Yazdırılabilir Endüstriyel Varlık Etiketleri (`print-label`):** Termal rulo etiket yazıcıları için optimize edilmiş, yüksek kontrastlı ve QR kodlu fiziksel makine etiketleri.

### 2. 📋 İş Emirleri ve Bakım Görevleri
- **Kanban Panosu ve Tablo Görünümü:** Tek tıkla ve sürükle-bırak mantığıyla iş emri yaşam döngüsü yönetimi (`Bekliyor` ➔ `Devam Ediyor` ➔ `Tamamlandı` ➔ `İptal`).
- **⏱️ SLA Hedef ve İhlal Takibi:** Hedeflenen müdahale ve çözüm sürelerinin gerçek zamanlı hesaplanması ve gecikme uyarıları.
- **💰 Ayrıntılı Maliyet Analizi:** İşçilik saat ücreti, dış servis/malzeme ve kullanılan yedek parçaların ayrı ayrı maliyetlendirilmesi.
- **📦 Otomatik Stok Düşümü:** İş emrinde kullanılan yedek parçaların otomatik olarak depo stoğundan düşülmesi.

### 3. 📷 Canlı Kamera QR Tarayıcı ve Dijital Pasaport
- **Dahili Kamera ile QR Okuma:** Saha teknisyenleri mobil cihaz veya bilgisayar kamerasını kullanarak makinedeki QR kodu anında tarayabilir.
- **🌐 Halka Açık Dijital Varlık Pasaportu (`/e/{code}`):** Giriş yapma zorunluluğu olmadan sahada fiziksel etiketi okutan herkesin makine teknik özelliklerini görmesini ve tek tıkla arıza bildirimi yapmasını sağlayan genel sayfa.

### 4. 📅 Otomatik İş Emri Üretim Motoru (Cron & Schedule)
- **Zaman ve Sayaç Bazlı Planlar:** Günlük, haftalık, aylık, yıllık veya her X çalışma saatinde bir devreye giren periyodik bakım kuralları.
- **🤖 Otomatik Görev Üretici:** Arka plan komutu (`php artisan keepada:generate-maintenance-tasks`) vadesi gelen planları otomatik olarak iş emrine dönüştürür.
- **Tek Tıkla Manuel Tetikleme:** Yöneticilerin panelden diledikleri an tüm planları çalıştırabilmesi.

### 5. 📊 İleri Düzey Raporlama, MTTR / MTBF ve CSV Dışa Aktarma
- **MTTR (Mean Time to Repair):** Ortalama onarım ve duruş süresinin saat cinsinden analitiği.
- **MTBF (Mean Time Between Failures):** Makinelerin plansız arıza yapmadan kesintisiz çalışma güvenilirlik katsayısı.
- **📈 Harcama Dağılım Grafikleri:** İşçilik, dış servis ve parça harcamalarını gösteren interaktif Chart.js donut grafikleri.
- **🏆 Teknisyen Performans Karnesi:** Personel bazında atanan, tamamlanan işler ve başarı oranları (`%`).
- **📥 Excel Uyumlu CSV İndirme:** Ekipman envanteri, iş emirleri geçmişi ve yedek parça stok defteri için tek tıkla CSV çıktısı.

### 6. 🌍 Çoklu Dil Desteği (i18n)
- Panel ve genel sayfalarda **Türkçe (TR)**, **İngilizce (EN)** ve **Almanca (DE)** dilleri arasında anında geçiş.

---

## 📸 Ekran Görüntüleri

| Ekipman & Kestirimci Bakım Tahmini | Bakım Takvimi |
|:---:|:---:|
| ![Equipment](docs/screenshots/equipment_detail.png) | ![Calendar](docs/screenshots/calendar.png) |

| Halka Açık Dijital QR Pasaportu | Güvenli Giriş Ekranı |
|:---:|:---:|
| ![QR Passport](docs/screenshots/public_qr_passport.png) | ![Login](docs/screenshots/login.png) |

---

## 🛠️ Teknoloji Yığını

- **Arka Yüz (Backend):** Laravel 12, PHP 8.2+
- **Veritabanı:** SQLite / MySQL / PostgreSQL
- **Ön Yüz (Frontend):** Blade, Tailwind CSS, Alpine.js, Lucide Icons
- **Grafik ve Takvim:** Chart.js, FullCalendar v6
- **QR Kütüphanesi:** HTML5-QRCode, QR Server API
- **Yetkilendirme:** Spatie Laravel Permission & Özel Tenant Ara Katmanı

---

## 🚀 Hızlı Başlangıç ve Kurulum

### 1. Gereksinimler
- PHP `>= 8.2` (`pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl` eklentileriyle)
- Composer
- Node.js & NPM (isteğe bağlı)

### 2. Kurulum Adımları
```bash
# Projeyi klonlayın
git clone https://github.com/adacreativeco/KeepADA.git
cd KeepADA

# Bağımlılıkları yükleyin
composer install

# Ortam dosyasını hazırlayın
cp .env.example .env
php artisan key:generate

# Veritabanı tablolarını ve örnek verileri oluşturun
php artisan migrate --seed

# Geliştirme sunucusunu başlatın
php -S 127.0.0.1:8090 -t public
```

### 3. Varsayılan Demo Giriş Bilgileri
- **Giriş URL:** [http://127.0.0.1:8090/login](http://127.0.0.1:8090/login)
- **E-posta:** `admin@admin.com`
- **Şifre:** `password`
- **Demo Tesis:** `/panel/keepada-demo/dashboard`

---

## ⚙️ Zamanlanmış Görevler (Cron Setup)

Otomatik iş emri üretimi ve SLA gecikme bildirimleri için sunucunuzun crontab listesine aşağıdaki satırı ekleyin:

```bash
* * * * * cd /proje-dizini && php artisan schedule:run >> /dev/null 2>&1
```

Kullanılabilir artisan komutları:
```bash
# Vadesi gelen bakım planlarından iş emirleri üretir
php artisan keepada:generate-maintenance-tasks

# Geciken iş emirleri için e-posta bildirimleri gönderir
php artisan app:send-overdue-notifications
```

---

## 📄 Lisans

Bu proje **Apache License 2.0** ile lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasına göz atabilirsiniz.

Telif Hakkı © 2026 [ADA Creative Co.](https://adacreative.co)

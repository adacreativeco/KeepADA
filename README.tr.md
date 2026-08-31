<div align="center">

# 🛠️ KeepADA CMMS
### Yeni Nesil Endüstriyel Bakım & Varlık Yönetim Platformu

**Laravel 12 ve Tailwind CSS üzerine inşa edilmiş; çok kiracılı (multi-tenant), yapay zeka destekli kestirimci bakım ve iş emri orkestrasyon sistemi.**

---

[![Lisans: Apache 2.0](https://img.shields.io/badge/Lisans-Apache%202.0-blue.svg?style=flat-square)](LICENSE)
[![Laravel Sürümü](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Sürümü](https://img.shields.io/badge/PHP-8.2%20%7C%208.3%20%7C%208.4-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![CI Testleri](https://img.shields.io/github/actions/workflow/status/adacreativeco/KeepADA/ci.yml?branch=main&label=CI%20Derleme&style=flat-square)](https://github.com/adacreativeco/KeepADA/actions)

<br/>

[ 🇹🇷 Türkçe ](README.tr.md) &nbsp;•&nbsp; [ 🇬🇧 English ](README.md) &nbsp;•&nbsp; [ 🇩🇪 Deutsch ](README.de.md)

</div>

---

<p align="center">
  <img src="docs/screenshots/dashboard.png" alt="KeepADA CMMS Ana Dashboard" width="100%" style="border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.4);" />
</p>

---

## ⚡ Neden KeepADA CMMS?

Geleneksel CMMS platformları genellikle hantal, karışık ve sahada kullanımı zor sistemlerdir. **KeepADA CMMS**, endüstriyel tesislerin gerçek saha ihtiyaçlarına odaklanarak sıfırdan tasarlandı:

- 🚀 **%100 Özel ve Hafif Mimari:** Ağır yönetim paneli eklentileri olmadan, saf Laravel 12 + Alpine.js + Tailwind CSS ile ultra hızlı ve akıcı arayüz.
- 🏢 **Doğal Çok Kiracılı Yapı (Multi-Tenancy):** Birden fazla fabrika, şube veya üretim hattını izole URL alanlarıyla (`/panel/{company:slug}/...`) tek panelden yönetin.
- 🧠 **Yapay Zeka Destekli Kestirimci Bakım:** Sayaç hızları, çalışma saatleri ve arıza geçmişini analiz ederek bir sonraki arıza vaktini önceden tahmin eden AI motoru.
- 📷 **Uçtan Uca QR Entegrasyonu:** Panelden canlı kamera ile QR tarama + girişsiz Halka Açık Dijital Varlık Pasaportu (`/e/{code}`) + yazdırılabilir termal etiketler.
- 📊 **İleri Düzey Analitik & Finans:** Canlı **MTTR** (Ortalama Onarım Süresi), **MTBF** (İki Arıza Arası Süre), SLA başarı takibi ve harcama dökümü grafikleri.
- 🌍 **Üç Dilli Altyapı:** Türkçe 🇹🇷, İngilizce 🇬🇧 ve Almanca 🇩🇪 arasında anında geçiş.

---

## 🧭 Sistem Modülleri ve Ekran Turu

### 1. ⚙️ Ekipman ve Varlık Yaşam Döngüsü
- **Merkezi Varlık Kütüğü:** Marka, model, seri no, garanti süresi, kategori ve fabrika lokasyonu bazında detaylı takip.
- **Akıllı Çalışma Saati Sayaçları:** Çalışma saati, kilometre veya vuruş adedi takibi ve bakım eşik aşımlarında otomatik uyarılar.
- **Yazdırılabilir Endüstriyel QR Etiketleri:** Termal etiket yazıcıları için optimize edilmiş, makineye yapıştırılmaya hazır yüksek kontrastlı etiket çıktısı.

<p align="center">
  <img src="docs/screenshots/equipment_detail.png" alt="Ekipman ve Kestirimci Bakım" width="95%" />
</p>

---

### 2. 📋 İş Emirleri ve Bakım Operasyonları
- **İnteraktif Kanban Panosu & Tablo:** `Bekliyor`, `Devam Ediyor`, `Tamamlandı` ve `İptal` aşamaları arasında sürükle-bırak veya tek tıkla durum güncelleme.
- **SLA ve Gecikme Takibi:** Hedeflenen çözüm süreleri ve geciken iş emirleri için görsel ihlal uyarıları.
- **Maliyet ve Parça Sarfiyatı:** Teknisyen işçilik süresi, harici servis giderleri ve kullanılan yedek parçaların depodan otomatik düşülmesi.

<p align="center">
  <img src="docs/screenshots/tasks_kanban.png" alt="İş Emirleri Kanban Panosu" width="95%" />
</p>

---

### 3. 📊 İleri Düzey Raporlar, MTTR / MTBF & Maliyet Analizi
- **Güvenilirlik Metrikleri:** Otomatik hesaplanan **MTTR** (Ortalama Onarım Süresi - Saat) ve **MTBF** (Arızasız Çalışma Süresi).
- **Maliyet Dağılım Grafikleri:** İşçilik vs Harici Servis vs Yedek Parça harcamalarını gösteren Chart.js interaktif grafikleri.
- **Teknisyen Performans Karnesi:** Personel bazlı iş tamamlama ve zamanında bitirme başarı yüzdeleri (`%`).
- **Excel Uyumlu CSV Dışa Aktarma:** Ekipman envanteri, iş emirleri ve parça stok defteri için tek tıkla anında CSV çıktısı.

<p align="center">
  <img src="docs/screenshots/reports_analytics.png" alt="İleri Düzey Analitik ve MTTR MTBF Raporları" width="95%" />
</p>

---

### 4. 🗓️ İnteraktif Bakım Takvimi
- **FullCalendar v6 Entegrasyonu:** Yaklaşan periyodik bakımları ve planlı görevleri ay, hafta ve gün bazında renk kodlu önceliklerle izleme.

<p align="center">
  <img src="docs/screenshots/calendar.png" alt="Bakım Takvimi" width="95%" />
</p>

---

### 5. 🌐 Halka Açık Dijital QR Pasaportu (`/e/{code}`)
- Sahadaki operatörler veya teknisyenler, makine üzerindeki QR etiketi telefonlarıyla okutarak giriş yapmaya gerek kalmadan makine künyesini görebilir ve tek tıkla arıza bildirim formu doldurabilir.

<p align="center">
  <img src="docs/screenshots/public_qr_passport.png" alt="Halka Açık Dijital Varlık Pasaportu" width="95%" />
</p>

---

## 🛠️ Teknoloji Yığını

| Katman | Teknoloji |
|---|---|
| **Arka Yüz (Backend)** | PHP 8.2+ / 8.3 / 8.4, Laravel 12.x |
| **Veritabanı** | SQLite (Varsayılan Dev), MySQL 8+, PostgreSQL |
| **Ön Yüz (Frontend)** | Blade, Tailwind CSS, Alpine.js, Lucide Icons |
| **Grafik ve Takvim** | Chart.js, FullCalendar v6 |
| **QR ve Kamera** | HTML5-QRCode, QR Server API |
| **Yetkilendirme** | Spatie Laravel Permission, Çok Kiracılı Tenant Middleware |

---

## 🚀 Hızlı Başlangıç ve Kurulum Rehberi

### 1. Gereksinimler
- **PHP** `>= 8.2` (Eklentiler: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `fileinfo`)
- **Composer** `>= 2.2`
- **Node.js & NPM** (İsteğe bağlı)

### 2. Kurulum Adımları

```bash
# 1. Projeyi klonlayın
git clone https://github.com/adacreativeco/KeepADA.git
cd KeepADA

# 2. PHP bağımlılıklarını yükleyin
composer install

# 3. Ortam dosyasını hazırlayın ve anahtar üretin
cp .env.example .env
php artisan key:generate

# 4. Veritabanı tablolarını ve demo verileri oluşturun
php artisan migrate --seed

# 5. Geliştirme sunucusunu başlatın
php -S 127.0.0.1:8090 -t public
```

---

## 🔑 Varsayılan Demo Giriş Bilgileri

Sunucuyu başlattıktan sonra tarayıcınızdan **[http://127.0.0.1:8090](http://127.0.0.1:8090)** adresine gidin:

| Parametre | Değer |
|---|---|
| **Giriş URL** | [http://127.0.0.1:8090/login](http://127.0.0.1:8090/login) |
| **E-posta** | `admin@admin.com` |
| **Şifre** | `password` |
| **Örnek Tesis Paneli** | `/panel/keepada-demo/dashboard` |
| **Örnek Dijital QR Pasaportu** | `/e/HK-001` |

---

## ⚙️ Otomatik Görev Motoru ve Zamanlayıcı (Cron)

Vadesi gelen periyodik bakımların otomatik iş emrine dönüşmesi ve SLA gecikme e-postaları için sunucu cron listenize Laravel zamanlayıcısını ekleyin:

```bash
* * * * * cd /proje-dizini && php artisan schedule:run >> /dev/null 2>&1
```

### Kullanılabilir Artisan Komutları:
```bash
# Bakım planlarını tarar ve vadesi gelen iş emirlerini üretir
php artisan keepada:generate-maintenance-tasks

# Geciken iş emirleri için otomatik SLA bildirimleri gönderir
php artisan app:send-overdue-notifications
```

---

## 🤝 Katkıda Bulunma

Topluluk katkıları memnuniyetle kabul edilir! Lütfen pull request göndermeden önce [CONTRIBUTING.md](CONTRIBUTING.md) ve [SECURITY.md](SECURITY.md) belgelerini inceleyiniz.

---

## 📄 Lisans

KeepADA CMMS, **[Apache License 2.0](LICENSE)** ile lisanslanmış açık kaynaklı bir yazılımdır.

Telif Hakkı © 2026 **[ADA Creative Co.](https://adacreative.co)** - Tüm hakları saklıdır.

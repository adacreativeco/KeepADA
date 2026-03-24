# KeepADA CMMS - Teknik ve Kullanım Dokümantasyonu

KeepADA, Laravel 12 ve Filament 4.x tabanlı, çok kiracılı (multi-tenant) bir Bakım ve Periyodik Servis Yönetim Sistemi'dir.

## 📚 Detaylı Dokümantasyon

Sistemin her yönüyle ilgili detaylı kılavuzlara aşağıdan ulaşabilirsiniz:

1.  [**Kurulum Kılavuzu**](docs/Installation.md): Adım adım kurulum ve gereksinimler.
2.  [**Sistem Mimarisi**](docs/Architecture.md): Teknik yığın, veritabanı şeması ve multi-tenancy yapısı.
3.  [**Kullanım Kılavuzu**](docs/UserGuide.md): Ekipman, plan ve görev yönetimi nasıl yapılır?
4.  [**Öne Çıkan Özellikler**](docs/Features.md): AI Tahminleme, SLA ve QR Kod detayları.
5.  [**İş Modeli ve Strateji**](docs/BusinessModel.md): Fiyatlandırma ve pazara giriş planı.
6.  [**Kullanıcı Hikayeleri**](docs/UserStories.md): Yöneticiler için özellik listesi ve hikayeler.

## 🚀 Hızlı Başlangıç

### Kurulum
```bash
composer install
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

### Giriş Bilgileri
- **Panel URL:** `http://localhost:8000/admin`
- **E-posta:** `admin@admin.com`
- **Şifre:** `password`

---
*KeepADA - Güvenli ve Verimli Varlık Yönetimi*


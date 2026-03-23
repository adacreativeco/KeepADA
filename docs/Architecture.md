# Sistem Mimarisi

KeepADA CMMS, modern ve ölçeklenebilir bir mimari üzerine inşa edilmiştir.

## 🏗 Teknolojik Yığın (Tech Stack)

- **Framework:** Laravel 12 (PHP 8.2+)
- **Admin Panel:** Filament 4.x (TALL Stack - Tailwind, Alpine.js, Laravel, Livewire)
- **Veritabanı:** MySQL / PostgreSQL
- **Media:** Spatie Media Library (Fotoğraf ve dosya yönetimi)
- **Grafikler:** ApexCharts (Filament entegrasyonu)
- **Harita:** Google Maps (Lokasyon seçimi)

## 🏢 Çok Kiracılılık (Multi-tenancy)

Sistem **Tenant (Kiracı)** mimarisi üzerine kuruludur. Bu sayede:
- Birden fazla şirket aynı veritabanını kullanır ancak verileri tamamen izoledir.
- Bir kullanıcı birden fazla şirkete (Tenant) üye olabilir.
- Tüm ana modeller (`Location`, `Equipment`, `MaintenancePlan`, `MaintenanceTask`, `SparePart`, `Supplier`) bir `company_id` sütununa sahiptir.
- Veri izolasyonu Filament'in yerleşik Tenant özelliği ile global scope'lar üzerinden sağlanır.

## 🗄 Veritabanı Şeması

### Ana Tablolar:
1. **companies:** Müşteri şirketler ve abonelik limitleri.
2. **users:** Sistem kullanıcıları (Spatie Shield ile rol yönetimi).
3. **locations:** Tesisler ve şubeler.
4. **equipment:** Makineler, cihazlar ve varlıklar.
5. **maintenance_plans:** Periyodik bakım tanımları.
6. **maintenance_tasks:** Gerçekleşen veya planlanan bakım işleri.
7. **spare_parts:** Stokta tutulan yedek parçalar.
8. **suppliers:** Malzeme ve servis sağlayıcıları.

### İlişki Özeti:
- Şirket `hasMany` (Lokasyon, Ekipman, Plan, Görev, Parça, Tedarikçi).
- Ekipman `belongsTo` Lokasyon ve Tedarikçi.
- Bakım Planı `hasMany` Bakım Görevi.
- Bakım Görevi `belongsToMany` Yedek Parça (Pivot: `task_spare_parts`).

## 🔌 API Mimarisi

Sistem, harici entegrasyonlar ve mobil uygulamalar için **Laravel Sanctum** tabanlı bir REST API sunar:
- `/api/login`: Kimlik doğrulama ve Token üretimi.
- `/api/equipment`: Şirkete özel ekipman listesi ve detayları.
- `/api/user`: Aktif kullanıcı bilgileri.

API rotaları otomatik olarak aktif şirkete (Tenant) göre filtrelenir.

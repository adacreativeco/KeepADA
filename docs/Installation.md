# Kurulum Kılavuzu

KeepADA CMMS'i yerel ortamınızda veya sunucunuzda çalıştırmak için bu adımları takip edin.

## 📋 Gereksinimler

- **PHP:** 8.2 veya üzeri
- **Veritabanı:** MySQL 8.0+, PostgreSQL veya SQLite
- **Paket Yöneticisi:** Composer 2.x
- **Frontend:** Node.js (v18+) ve NPM
- **Web Sunucusu:** Apache veya Nginx

## 🚀 Adım Adım Kurulum

### 1. Projeyi Klonlayın
```bash
git clone <repo-url>
cd KeepADA
```

### 2. Bağımlılıkları Yükleyin
```bash
composer install
npm install && npm run build
```

### 3. Çevresel Değişkenleri Yapılandırın
`.env.example` dosyasını `.env` olarak kopyalayın ve düzenleyin:
```bash
cp .env.example .env
```
`.env` dosyasında şu alanları güncelleyin:
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `GOOGLE_MAPS_API_KEY` (Harita seçici için gereklidir)

### 4. Uygulama Anahtarını Oluşturun
```bash
php artisan key:generate
```

### 5. Veritabanını Hazırlayın
Tabloları oluşturun ve örnek (demo) verileri yükleyin:
```bash
php artisan migrate --seed
```

### 6. Dosya Sistemini Bağlayın
Fotoğrafların görüntülenebilmesi için:
```bash
php artisan storage:link
```

### 7. Sunucuyu Başlatın
```bash
php artisan serve
```

## 🔐 İlk Giriş Bilgileri
- **URL:** `http://localhost:8000/admin`
- **E-posta:** `admin@admin.com`
- **Şifre:** `password`

## 🛠 Bakım Komutları
Gecikmiş görev bildirimlerini otomatize etmek için sisteminize şu cron job'ı ekleyin:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
Veya manuel test için:
```bash
php artisan app:send-overdue-notifications
```

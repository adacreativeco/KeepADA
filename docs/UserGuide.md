# Kullanım Kılavuzu

KeepADA CMMS ile bakım süreçlerinizi nasıl yönetebileceğinize dair temel bilgiler.

## 📍 Lokasyon Yönetimi
İlk adım olarak tesislerinizi veya şubelerinizi tanımlayın:
- Harita üzerinden koordinat seçerek tam konumu belirleyin.
- Tesis sorumlusu ve iletişim bilgilerini ekleyin.
- Lokasyon pasife alındığında, o lokasyona bağlı yeni görevler planlanamaz.

## ⚙️ Ekipman Takibi
Makinelerinizi ve varlıklarınızı sisteme kaydedin:
- **Kategori ve Marka:** Ekipmanları türlerine göre gruplayın.
- **Garanti:** Garanti bitiş tarihini girin; sistem 30 gün kala sizi uyaracaktır.
- **QR Kod:** Her ekipman için sistem otomatik bir kod üretir. Bu kodu cihazın üzerine yapıştırarak mobil cihazlardan hızlı erişim sağlayabilirsiniz.

## 📋 Bakım Planlama
Periyodik işlerinizi otomatikleştirin:
- **Periyot:** Günlük, haftalık, aylık, yıllık veya özel aralıklar belirleyin.
- **SLA:** Her plan için maksimum müdahale süresi (saat) tanımlayın.
- **Otomasyon:** Plan kaydedildiğinde ilk görev otomatik oluşur. Bir görev tamamlandığında, periyoda göre sıradaki görev sistem tarafından planlanır.

## 🔧 Görev Yönetimi
Teknisyenlerin saha operasyonlarını yönetin:
- **Atama:** Görevleri belirli teknisyenlere atayın.
- **Kanıt:** Teknisyenler bakım öncesi ve sonrası fotoğrafları yükleyebilir.
- **Maliyet:** Kullanılan yedek parçaları seçin, işçilik maliyetini girin. Sistem toplam maliyeti otomatik hesaplar.
- **Durum:** Bekliyor -> Devam Ediyor -> Tamamlandı akışını takip edin.

## 📦 Yedek Parça ve Stok
- **Kritik Stok:** Minimum stok seviyesi belirleyin. Stok bu seviyenin altına düştüğünde sistem uyarı verir.
- **Tedarikçi:** Parçaların hangi tedarikçiden alındığını takip ederek satın alma süreçlerini yönetin.

## 📅 Takvim ve Dashboard
- **Takvim:** Tüm görevleri aylık görünümde izleyin. Renk kodları (Kırmızı: Gecikmiş, Turuncu: Bugün, Yeşil: Bitti) ile durumu saniyeler içinde analiz edin.
- **İstatistikler:** Toplam maliyet, en çok arıza yapan ekipmanlar ve ekipman durum dağılımını dashboard üzerinden grafiklerle takip edin.

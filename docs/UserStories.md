# Kullanıcı Hikayeleri ve Özellik Eşleştirmesi

KeepADA CMMS, Tesis ve Bakım Yöneticilerinin günlük operasyonel ihtiyaçlarını karşılamak üzere tasarlanmıştır. Aşağıda kullanıcı hikayeleri ve bu hikayelerin sistemdeki teknik karşılıkları yer almaktadır.

## 👤 Tesis / Bakım Yöneticisi (Admin)

### 1. Ekipman ve Plan Yönetimi
> **Hikaye:** "Sistemdeki tüm ekipmanları görmek ve bunlara periyodik bakım planı atayabilmek istiyorum. Böylece hangi makinenin ne zaman bakıma gireceğini takip edebileyim."

- **Sistem Karşılığı:** [EquipmentResource](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/Equipment/EquipmentResource.php) üzerinden tüm varlıklar listelenir. [MaintenancePlanResource](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/MaintenancePlans/MaintenancePlanResource.php) ile her ekipmana özel periyodik döngüler (Günlük, Haftalık, Aylık vb.) tanımlanır.

### 2. Görev Atama ve Sorumluluk
> **Hikaye:** "Bir bakım görevi oluşturup teknisyene atayabilmek istiyorum. Böylece kimin neyi yapacağı netleşsin ve görev kaybolmasın."

- **Sistem Karşılığı:** [MaintenanceTaskResource](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/MaintenanceTasks/MaintenanceTaskResource.php) üzerinden görevler oluşturulur ve `assigned_to` alanı ile teknisyenlere atanır. Görevler teknisyenin paneline anlık olarak düşer.

### 3. Görsel Planlama (Takvim)
> **Hikaye:** "Bakım takvimini aylık/haftalık görünümde görmek istiyorum. Böylece yaklaşan bakımları kaçırmayalım ve kaynak planlaması yapalım."

- **Sistem Karşılığı:** [CalendarPage](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Pages/CalendarPage.php) üzerinde tüm görevler renk kodlu olarak (Gecikmiş: Kırmızı, Planlı: Mavi, Tamamlandı: Yeşil) takvim üzerinde gösterilir.

### 4. Gecikme Uyarıları ve Kontrol
> **Hikaye:** "Geciken ve tamamlanmayan bakımlar için uyarı almak istiyorum. Böylece bakım gecikmelerinin önüne geçebileyim."

- **Sistem Karşılığı:** [MaintenanceTasksTable](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/MaintenanceTasks/Tables/MaintenanceTasksTable.php) üzerinde geciken görevler kırmızı ve kalın yazı tipiyle vurgulanır. Ayrıca [SendOverdueNotifications](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Console/Commands/SendOverdueNotifications.php) komutu ile sistem otomatik bildirimler gönderir.

### 5. Maliyet Analizi ve Raporlama
> **Hikaye:** "Ekipman bazında bakım maliyet raporunu Excel olarak indirebilmek istiyorum. Böylece bütçe planlamasını ve tedarikçi ödemelerini yöneteyim."

- **Sistem Karşılığı:** Görev listesinde bulunan "Excel Export" özelliği ile maliyet verileri (İşçilik + Parça) dışa aktarılır. [CostAnalysisChart](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Widgets/CostAnalysisChart.php) widget'ı ile dashboard üzerinden görsel analiz sunulur.

## 👷 Teknisyen (Field User)

### 1. Görev Takibi ve Güncelleme
> **Hikaye:** "Bana atanan bakım görevlerini görmek ve durumunu güncelleyebilmek istiyorum. Böylece tamamladığım işleri işaretleyeyim ve admin anlık görsün."

- **Sistem Karşılığı:** Teknisyenler [MaintenanceTaskResource](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/MaintenanceTasks/MaintenanceTaskResource.php) üzerinden sadece kendilerine atanan görevleri görürler. Görev durumunu "Bekliyor"dan "Devam Ediyor" veya "Tamamlandı"ya çekerek süreci anlık güncellerler.

### 2. Bulguların Kaydı (Fotoğraf ve Not)
> **Hikaye:** "Bakım sırasında fotoğraf ve not ekleyebilmek istiyorum. Böylece bulgularımı kayıt altına alayım ve ileride referans olsun."

- **Sistem Karşılığı:** [MaintenanceTaskForm](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/MaintenanceTasks/Schemas/MaintenanceTaskForm.php) içerisinde bulunan "Bakım Öncesi/Sonrası Fotoğraflar" ve "Teknisyen Notları" alanları ile tüm süreç dijital kanıtlarla kayıt altına alınır.

### 3. Otomatik Stok Yönetimi
> **Hikaye:** "Kullandığım yedek parçayı ve miktarını girip stoktan düşebilmek istiyorum. Böylece stok takibi otomatik yürüsün."

- **Sistem Karşılığı:** [SparePartsRelationManager](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/MaintenanceTasks/RelationManagers/SparePartsRelationManager.php) üzerinden göreve parça eklendiğinde, sistem otomatik olarak [SparePart](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Models/SparePart.php) stok miktarından düşer. Parça çıkarıldığında ise stok iade edilir.

## 🤝 Müşteri / Müvekkil (Read-only)

### 1. Şeffaf Bakım Geçmişi İzleme
> **Hikaye:** "Kendi lokasyonumdaki ekipmanlara ait bakım geçmişini görebilmek istiyorum. Böylece hangi bakımların yapıldığını takip edeyim ve şeffaflık sağlansın."

- **Sistem Karşılığı 1 (Panel):** `viewer` rolüne sahip müşteriler, sadece kendi şirketlerine ait [EquipmentResource](file:///c:/Users/samet.atlas/Desktop/KeepADA/app/Filament/Resources/Equipment/EquipmentResource.php) listesini görebilir ve ekipman detayındaki "Bakım Geçmişi" sekmesinden tüm eski kayıtları inceleyebilirler.
- **Sistem Karşılığı 2 (Hızlı Erişim):** Ekipman üzerindeki QR kod okutulduğunda açılan [Public View](file:///c:/Users/samet.atlas/Desktop/KeepADA/resources/views/equipment/public-view.blade.php) sayfası, herhangi bir giriş gerektirmeden cihazın son 3 bakım kaydını ve genel durumunu şeffaf bir şekilde sunar.



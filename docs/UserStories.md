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

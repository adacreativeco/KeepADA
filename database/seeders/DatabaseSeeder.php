<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Equipment;
use App\Models\MaintenancePlan;
use App\Models\SparePart;
use App\Models\Company;
use App\Models\Supplier;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $technicianRole = Role::firstOrCreate(['name' => 'technician', 'guard_name' => 'web']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);

        // 2. Create Company (Tenant)
        $company = Company::create([
            'name' => 'KeepADA Demo A.Ş.',
            'slug' => 'keepada-demo',
            'plan' => 'professional',
            'max_locations' => 5,
            'max_equipment' => 9999,
            'max_users' => 10,
        ]);

        // 3. Create Super Admin
        $admin = User::factory()->create([
            'name' => 'Sistem Yöneticisi',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($superAdminRole);
        $admin->companies()->attach($company);

        // 4. Create Users
        $manager = User::factory()->create([
            'name' => 'Bölge Müdürü',
            'email' => 'manager@test.com',
        ]);
        $manager->assignRole($managerRole);
        $manager->companies()->attach($company);

        $technician = User::factory()->create([
            'name' => 'Ahmet Teknisyen',
            'email' => 'ahmet@test.com',
        ]);
        $technician->assignRole($technicianRole);
        $technician->companies()->attach($company);

        // 5. Create Supplier
        $supplier = Supplier::create([
            'company_id' => $company->id,
            'name' => 'Atlas Teknik Servis',
            'contact_person' => 'Atlas Bey',
            'category' => 'Servis',
        ]);

        // 6. Create Locations
        $loc1 = Location::create([
            'company_id' => $company->id,
            'name' => 'İstanbul Fabrika A',
            'address' => 'Hadımköy, İstanbul',
            'lat' => 41.025,
            'lng' => 28.975,
            'contact_name' => 'Mehmet Efendi',
            'contact_phone' => '05551112233',
        ]);

        $loc2 = Location::create([
            'company_id' => $company->id,
            'name' => 'Bursa Depo',
            'address' => 'Nilüfer, Bursa',
            'lat' => 40.183,
            'lng' => 29.061,
            'contact_name' => 'Caner Bey',
            'contact_phone' => '05554445566',
        ]);

        // 7. Create Equipment
        $eq1 = Equipment::create([
            'company_id' => $company->id,
            'location_id' => $loc1->id,
            'supplier_id' => $supplier->id,
            'name' => 'Hava Kompresörü #1',
            'code' => 'HK-001',
            'qr_code' => 'HK-001-QR',
            'category' => 'Mekanik',
            'brand' => 'Atlas Copco',
            'model' => 'GA-37',
            'serial_number' => 'AC123456',
            'purchase_date' => now()->subYears(2),
            'warranty_end_date' => now()->addMonths(6),
            'status' => 'active',
        ]);

        $eq2 = Equipment::create([
            'company_id' => $company->id,
            'location_id' => $loc1->id,
            'name' => 'Ana Pano',
            'code' => 'ELK-P01',
            'category' => 'Elektrik',
            'brand' => 'Schneider',
            'status' => 'active',
        ]);

        // 8. Create Maintenance Plans (This will auto-create tasks via Model Booted Event)
        MaintenancePlan::create([
            'company_id' => $company->id,
            'equipment_id' => $eq1->id,
            'title' => 'Aylık Filtre Değişimi',
            'description' => '1. Hava filtresini kontrol et.\n2. Yağ filtresini değiştir.\n3. Kayış gerginliğini ölç.',
            'frequency_type' => 'monthly',
            'frequency_value' => 1,
            'estimated_duration_minutes' => 60,
            'estimated_cost' => 1500,
            'sla_hours' => 24,
            'assigned_to' => $technician->id,
            'next_due_date' => now()->addDays(5),
            'is_active' => true,
        ]);

        MaintenancePlan::create([
            'company_id' => $company->id,
            'equipment_id' => $eq2->id,
            'title' => 'Yıllık Termal Kamera Ölçümü',
            'description' => 'Pano içi bağlantı noktalarının termal kamera ile ölçülmesi ve raporlanması.',
            'frequency_type' => 'yearly',
            'frequency_value' => 1,
            'estimated_duration_minutes' => 120,
            'estimated_cost' => 500,
            'sla_hours' => 48,
            'assigned_to' => $technician->id,
            'next_due_date' => now()->addMonths(1),
            'is_active' => true,
        ]);

        // 9. Create Spare Parts
        SparePart::create([
            'company_id' => $company->id,
            'supplier_id' => $supplier->id,
            'name' => 'Hava Filtresi',
            'code' => 'SP-HF-01',
            'unit' => 'adet',
            'stock_quantity' => 20,
            'min_stock' => 5,
            'unit_cost' => 450,
        ]);

        SparePart::create([
            'company_id' => $company->id,
            'supplier_id' => $supplier->id,
            'name' => 'Kompresör Yağı (5L)',
            'code' => 'SP-OIL-01',
            'unit' => 'litre',
            'stock_quantity' => 100,
            'min_stock' => 10,
            'unit_cost' => 1200,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Equipment;
use App\Models\MaintenanceTask;
use App\Models\SparePart;
use App\Models\StockTransaction;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Company $company, Request $request)
    {
        // 1. MTTR (Mean Time to Repair) Hesabı: Tamamlanan arızi/acil görevlerin ortalama onarım süresi (Saat)
        $completedCorrectiveTasks = MaintenanceTask::where('company_id', $company->id)
            ->whereIn('type', ['corrective', 'emergency'])
            ->where('status', 'done')
            ->whereNotNull('started_at')
            ->whereNotNull('completed_at')
            ->get();

        $totalRepairHours = 0;
        foreach ($completedCorrectiveTasks as $task) {
            $totalRepairHours += $task->started_at->diffInMinutes($task->completed_at) / 60;
        }

        $mttrHours = $completedCorrectiveTasks->count() > 0 
            ? round($totalRepairHours / $completedCorrectiveTasks->count(), 1) 
            : 0;

        // 2. MTBF (Mean Time Between Failures) Hesabı: Toplam çalışma süresi / Arıza sayısı
        $totalEquipmentCount = Equipment::where('company_id', $company->id)->count();
        $totalFailuresCount = MaintenanceTask::where('company_id', $company->id)
            ->whereIn('type', ['corrective', 'emergency'])
            ->count();

        // 30 günlük çalışma saati bazlı tahmini MTBF (720 saat x ekipman sayısı / arıza sayısı)
        $estimatedOperatingHours = $totalEquipmentCount * 720;
        $mtbfHours = $totalFailuresCount > 0 
            ? round($estimatedOperatingHours / $totalFailuresCount, 0) 
            : ($totalEquipmentCount > 0 ? 720 : 0);

        // 3. Maliyet Dağılımı
        $tasks = MaintenanceTask::where('company_id', $company->id)->with('spareParts')->get();
        $totalLaborCost = $tasks->sum('labor_cost');
        $totalMaterialCost = $tasks->sum('material_cost');
        $totalSparePartCost = $tasks->reduce(function ($carry, $task) {
            return $carry + $task->spareParts->sum(fn($p) => $p->pivot->quantity_used * $p->unit_cost);
        }, 0);
        $grandTotalCost = $totalLaborCost + $totalMaterialCost + $totalSparePartCost;

        // 4. Teknisyen Performans Karnesi
        $technicians = $company->users()->with(['maintenanceTasks' => function($q) use ($company) {
            $q->where('company_id', $company->id);
        }])->get()->map(function ($tech) {
            $completed = $tech->maintenanceTasks->where('status', 'done')->count();
            $inProgress = $tech->maintenanceTasks->where('status', 'in_progress')->count();
            $pending = $tech->maintenanceTasks->where('status', 'pending')->count();
            $total = $tech->maintenanceTasks->count();
            $onTimeRate = $total > 0 ? round(($completed / $total) * 100) : 0;

            return [
                'user' => $tech,
                'total_tasks' => $total,
                'completed' => $completed,
                'in_progress' => $inProgress,
                'pending' => $pending,
                'on_time_rate' => $onTimeRate,
            ];
        });

        // 5. En Çok Arıza Yapan Ekipmanlar (Top 5)
        $topFailingEquipment = Equipment::where('company_id', $company->id)
            ->withCount(['maintenanceTasks' => function ($q) {
                $q->whereIn('type', ['corrective', 'emergency']);
            }])
            ->orderByDesc('maintenance_tasks_count')
            ->take(5)
            ->get();

        return view('panel.reports.index', compact(
            'company',
            'mttrHours',
            'mtbfHours',
            'completedCorrectiveTasks',
            'totalFailuresCount',
            'totalLaborCost',
            'totalMaterialCost',
            'totalSparePartCost',
            'grandTotalCost',
            'technicians',
            'topFailingEquipment'
        ));
    }

    public function exportEquipment(Company $company): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="KeepADA_Ekipman_Listesi_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($company) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($file, ['Kod', 'Ekipman Adı', 'Kategori', 'Marka', 'Model', 'Seri No', 'Lokasyon', 'Sayaç Değeri', 'Birim', 'Durum', 'Kayıt Tarihi']);

            Equipment::where('company_id', $company->id)->with('location')->chunk(100, function ($items) use ($file) {
                foreach ($items as $item) {
                    fputcsv($file, [
                        $item->code,
                        $item->name,
                        $item->category ?? '—',
                        $item->brand ?? '—',
                        $item->model ?? '—',
                        $item->serial_number ?? '—',
                        $item->location?->name ?? '—',
                        $item->current_meter_reading ?? 0,
                        $item->meter_unit ?? 'saat',
                        $item->status,
                        $item->created_at->format('d.m.Y H:i'),
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportTasks(Company $company): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="KeepADA_Is_Emirleri_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($company) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($file, ['ID', 'Başlık', 'Ekipman Kodu', 'Ekipman Adı', 'Tür', 'Öncelik', 'Durum', 'Atanan Teknisyen', 'Planlanan Tarih', 'Başlangıç', 'Bitiş', 'İşçilik (TL)', 'Malzeme (TL)', 'Toplam Maliyet (TL)']);

            MaintenanceTask::where('company_id', $company->id)->with(['equipment', 'assignedUser', 'spareParts'])->chunk(100, function ($items) use ($file) {
                foreach ($items as $item) {
                    fputcsv($file, [
                        $item->id,
                        $item->title,
                        $item->equipment->code,
                        $item->equipment->name,
                        $item->type,
                        $item->priority,
                        $item->status,
                        $item->assignedUser?->name ?? '—',
                        $item->scheduled_date->format('d.m.Y'),
                        $item->started_at?->format('d.m.Y H:i') ?? '—',
                        $item->completed_at?->format('d.m.Y H:i') ?? '—',
                        $item->labor_cost ?? 0,
                        $item->material_cost ?? 0,
                        $item->total_cost ?? 0,
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportInventory(Company $company): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="KeepADA_Yedek_Parca_Stok_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($company) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($file, ['Parça Kodu', 'Parça Adı', 'Tedarikçi', 'Mevcut Stok', 'Birim', 'Min. Stok Eşiği', 'Birim Maliyet (TL)', 'Toplam Değer (TL)', 'Kritik Durum']);

            SparePart::where('company_id', $company->id)->with('supplier')->chunk(100, function ($items) use ($file) {
                foreach ($items as $item) {
                    $isCritical = $item->stock_quantity <= $item->min_stock ? 'KRITIK' : 'NORMAL';
                    fputcsv($file, [
                        $item->code,
                        $item->name,
                        $item->supplier?->name ?? '—',
                        $item->stock_quantity,
                        $item->unit,
                        $item->min_stock,
                        $item->unit_cost,
                        $item->stock_quantity * $item->unit_cost,
                        $isCritical,
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

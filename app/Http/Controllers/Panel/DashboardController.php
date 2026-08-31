<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Equipment;
use App\Models\MaintenanceTask;
use App\Models\MaintenancePlan;
use App\Models\SparePart;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Company $company)
    {
        $equipmentCount = Equipment::where('company_id', $company->id)->count();
        $activeEquipment = Equipment::where('company_id', $company->id)->where('status', 'active')->count();

        $openTasksCount = MaintenanceTask::where('company_id', $company->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();

        $overdueTasksCount = MaintenanceTask::where('company_id', $company->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->where('scheduled_date', '<', now()->toDateString())
            ->count();

        $completedThisMonth = MaintenanceTask::where('company_id', $company->id)
            ->where('status', 'done')
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->count();

        $criticalPartsCount = SparePart::where('company_id', $company->id)
            ->whereColumn('stock_quantity', '<=', 'min_stock')
            ->count();

        $urgentTasks = MaintenanceTask::where('company_id', $company->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->with(['equipment', 'assignedUser'])
            ->orderBy('scheduled_date', 'asc')
            ->take(6)
            ->get();

        $criticalParts = SparePart::where('company_id', $company->id)
            ->whereColumn('stock_quantity', '<=', 'min_stock')
            ->take(5)
            ->get();

        // Monthly trends for last 6 months
        $months = [];
        $completedTrends = [];
        $createdTrends = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->translatedFormat('M Y');
            $months[] = $monthLabel;

            $completedTrends[] = MaintenanceTask::where('company_id', $company->id)
                ->where('status', 'done')
                ->whereMonth('completed_at', $date->month)
                ->whereYear('completed_at', $date->year)
                ->count();

            $createdTrends[] = MaintenanceTask::where('company_id', $company->id)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // Equipment status distribution
        $statusActive = Equipment::where('company_id', $company->id)->where('status', 'active')->count();
        $statusMaintenance = Equipment::where('company_id', $company->id)->where('status', 'under_maintenance')->count();
        $statusInactive = Equipment::where('company_id', $company->id)->where('status', 'inactive')->count();

        return view('panel.dashboard', compact(
            'company',
            'equipmentCount',
            'activeEquipment',
            'openTasksCount',
            'overdueTasksCount',
            'completedThisMonth',
            'criticalPartsCount',
            'urgentTasks',
            'criticalParts',
            'months',
            'completedTrends',
            'createdTrends',
            'statusActive',
            'statusMaintenance',
            'statusInactive'
        ));
    }
}

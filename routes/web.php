<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EquipmentPublicController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\EquipmentController;
use App\Http\Controllers\Panel\MaintenanceTaskController;
use App\Http\Controllers\Panel\MaintenancePlanController;
use App\Http\Controllers\Panel\SparePartController;
use App\Http\Controllers\Panel\LocationController;
use App\Http\Controllers\Panel\SupplierController;
use App\Http\Controllers\Panel\CalendarController;
use App\Http\Controllers\Panel\ReportController;
use App\Http\Controllers\Panel\TeamController;
use App\Http\Controllers\LocaleController;
use App\Http\Middleware\TenantMiddleware;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('home');

// Language Switcher
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

// Public Equipment Passport (QR Scan)
Route::get('/e/{code}', [EquipmentPublicController::class, 'show'])->name('equipment.public-show');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Protected Multi-Tenant Panel Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', TenantMiddleware::class])
    ->prefix('panel/{company:slug}')
    ->name('panel.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Equipment
        Route::get('equipment/{equipment}/print-label', [EquipmentController::class, 'printLabel'])->name('equipment.print-label');
        Route::resource('equipment', EquipmentController::class);
        Route::post('equipment/{equipment}/meter', [EquipmentController::class, 'addMeterReading'])->name('equipment.meter');

        // Maintenance Tasks / Work Orders
        Route::resource('tasks', MaintenanceTaskController::class);
        Route::post('tasks/{task}/status', [MaintenanceTaskController::class, 'updateStatus'])->name('tasks.status');
        Route::post('tasks/{task}/parts', [MaintenanceTaskController::class, 'addSparePart'])->name('tasks.parts.add');
        Route::delete('tasks/{task}/parts/{sparePart}', [MaintenanceTaskController::class, 'removeSparePart'])->name('tasks.parts.remove');

        // Maintenance Plans
        Route::post('plans/trigger', [MaintenancePlanController::class, 'triggerPlans'])->name('plans.trigger');
        Route::resource('plans', MaintenancePlanController::class);

        // Spare Parts & Inventory
        Route::resource('inventory', SparePartController::class);
        Route::post('inventory/{part}/adjust', [SparePartController::class, 'adjustStock'])->name('inventory.adjust');
        Route::get('inventory-transactions', [SparePartController::class, 'transactions'])->name('inventory.transactions');

        // Locations
        Route::resource('locations', LocationController::class);

        // Suppliers
        Route::resource('suppliers', SupplierController::class);

        // Calendar
        Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
        Route::get('calendar/events', [CalendarController::class, 'events'])->name('calendar.events');

        // Advanced Analytics & Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export/equipment', [ReportController::class, 'exportEquipment'])->name('reports.export.equipment');
        Route::get('reports/export/tasks', [ReportController::class, 'exportTasks'])->name('reports.export.tasks');
        Route::get('reports/export/inventory', [ReportController::class, 'exportInventory'])->name('reports.export.inventory');

        // Team & Technicians
        Route::get('team', [TeamController::class, 'index'])->name('team.index');
        Route::post('team', [TeamController::class, 'store'])->name('team.store');
        Route::delete('team/{user}', [TeamController::class, 'destroy'])->name('team.destroy');
    });

// Fallback for /admin to redirect cleanly to panel
Route::get('/admin', function () {
    if (auth()->check()) {
        $company = auth()->user()->companies()->first() ?? \App\Models\Company::first();
        if ($company) {
            return redirect()->route('panel.dashboard', ['company' => $company->slug]);
        }
    }
    return redirect()->route('login');
});
Route::get('/admin/{any}', function () {
    return redirect()->route('login');
})->where('any', '.*');

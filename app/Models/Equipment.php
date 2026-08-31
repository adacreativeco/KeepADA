<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'company_id',
        'location_id',
        'supplier_id',
        'name',
        'code',
        'qr_code',
        'category',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'warranty_end_date',
        'current_meter_reading',
        'meter_unit',
        'status',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_end_date' => 'date',
        'current_meter_reading' => 'decimal:2',
    ];

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function maintenancePlans()
    {
        return $this->hasMany(MaintenancePlan::class);
    }

    public function maintenanceTasks()
    {
        return $this->hasMany(MaintenanceTask::class);
    }

    public function maintenanceHistory()
    {
        return $this->hasMany(MaintenanceTask::class)->where('status', 'done');
    }

    public function getPredictiveNextDueDateAttribute()
    {
        $lastTasks = $this->maintenanceTasks()
            ->where('status', 'done')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->take(5)
            ->get();

        if ($lastTasks->count() < 2) {
            return $this->maintenancePlans()->where('is_active', true)->first()?->next_due_date;
        }

        $intervals = [];
        for ($i = 0; $i < $lastTasks->count() - 1; $i++) {
            $intervals[] = $lastTasks[$i]->completed_at->diffInDays($lastTasks[$i+1]->completed_at);
        }

        $avgInterval = array_sum($intervals) / count($intervals);
        
        return $lastTasks->first()->completed_at->addDays(round($avgInterval));
    }
}

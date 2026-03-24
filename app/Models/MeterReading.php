<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    protected $fillable = [
        'company_id',
        'equipment_id',
        'reading_value',
        'reading_date',
        'notes',
    ];

    protected $casts = [
        'reading_date' => 'datetime',
        'reading_value' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::created(function ($reading) {
            $equipment = $reading->equipment;
            $equipment->update(['current_meter_reading' => $reading->reading_value]);

            // Sayaç bazlı bakım planlarını kontrol et
            $plans = $equipment->maintenancePlans()
                ->where('is_active', true)
                ->whereNotNull('meter_interval')
                ->get();

            foreach ($plans as $plan) {
                $lastReading = $plan->last_meter_reading ?: 0;
                if (($reading->reading_value - $lastReading) >= $plan->meter_interval) {
                    $plan->createTaskFromMeter($reading->reading_value);
                }
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}

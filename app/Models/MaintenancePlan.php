<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenancePlan extends Model
{
    protected $fillable = [
        'company_id',
        'equipment_id',
        'title',
        'description',
        'frequency_type',
        'frequency_value',
        'estimated_duration_minutes',
        'estimated_cost',
        'sla_hours',
        'meter_interval',
        'last_meter_reading',
        'assigned_to',
        'is_active',
        'next_due_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'next_due_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'meter_interval' => 'decimal:2',
        'last_meter_reading' => 'decimal:2',
    ];

    public function createTaskFromMeter($currentReading)
    {
        $task = MaintenanceTask::create([
            'company_id' => $this->company_id,
            'plan_id' => $this->id,
            'equipment_id' => $this->equipment_id,
            'assigned_to' => $this->assigned_to,
            'title' => $this->title . " ({$currentReading} " . ($this->equipment->meter_unit ?: '') . ")",
            'type' => 'preventive',
            'status' => 'pending',
            'priority' => 'medium',
            'scheduled_date' => now(),
        ]);

        $this->update(['last_meter_reading' => $currentReading]);

        return $task;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function maintenanceTasks()
    {
        return $this->hasMany(MaintenanceTask::class, 'plan_id');
    }

    protected static function booted()
    {
        static::created(function ($plan) {
            $plan->createInitialTasks();
        });

        static::updated(function ($plan) {
            if ($plan->isDirty('next_due_date') && $plan->next_due_date) {
                // Logic to handle updated next_due_date if needed
            }
        });
    }

    public function createInitialTasks($count = 1)
    {
        $date = $this->next_due_date;

        for ($i = 0; $i < $count; $i++) {
            MaintenanceTask::create([
                'company_id' => $this->company_id,
                'plan_id' => $this->id,
                'equipment_id' => $this->equipment_id,
                'assigned_to' => $this->assigned_to,
                'title' => $this->title,
                'type' => 'preventive',
                'status' => 'pending',
                'priority' => 'medium',
                'scheduled_date' => $date,
            ]);

            $date = $this->calculateNextDate($date);
        }
    }

    public function createNextTaskFromCompleted($completedTask)
    {
        $nextDate = $this->calculateNextDate($completedTask->scheduled_date);

        return MaintenanceTask::create([
            'company_id' => $this->company_id,
            'plan_id' => $this->id,
            'equipment_id' => $this->equipment_id,
            'assigned_to' => $this->assigned_to,
            'title' => $this->title,
            'type' => 'preventive',
            'status' => 'pending',
            'priority' => 'medium',
            'scheduled_date' => $nextDate,
        ]);
    }

    public function calculateNextDate($date)
    {
        $newDate = clone $date;
        $value = $this->frequency_value;

        switch ($this->frequency_type) {
            case 'daily':
                return $newDate->addDays($value);
            case 'weekly':
                return $newDate->addWeeks($value);
            case 'monthly':
                return $newDate->addMonths($value);
            case 'quarterly':
                return $newDate->addMonths($value * 3);
            case 'yearly':
                return $newDate->addYears($value);
            default:
                return $newDate;
        }
    }
}

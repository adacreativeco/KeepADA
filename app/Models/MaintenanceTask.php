<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MaintenanceTask extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'company_id',
        'plan_id',
        'equipment_id',
        'assigned_to',
        'title',
        'type',
        'status',
        'priority',
        'scheduled_date',
        'started_at',
        'completed_at',
        'actual_cost',
        'labor_cost',
        'material_cost',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'actual_cost' => 'decimal:2',
        'labor_cost' => 'decimal:2',
        'material_cost' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::updated(function ($task) {
            // Eğer görev tamamlandıysa ve bir plana bağlıysa, bir sonraki görevi oluştur
            if ($task->wasChanged('status') && $task->status === 'done' && $task->plan) {
                $task->plan->createNextTaskFromCompleted($task);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getTotalCostAttribute()
    {
        return ($this->actual_cost ?: 0) + ($this->labor_cost ?: 0) + ($this->material_cost ?: 0);
    }

    public function getSlaStatusAttribute()
    {
        if (!$this->plan || !$this->plan->sla_hours || !$this->completed_at) {
            return null;
        }

        $dueBy = $this->scheduled_date->addHours($this->plan->sla_hours);
        
        return $this->completed_at->isBefore($dueBy) ? 'İçinde' : 'Gecikti';
    }

    public function getSlaColorAttribute()
    {
        return $this->sla_status === 'İçinde' ? 'success' : 'danger';
    }

    public function plan()
    {
        return $this->belongsTo(MaintenancePlan::class, 'plan_id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function spareParts()
    {
        return $this->belongsToMany(SparePart::class, 'task_spare_parts', 'task_id', 'spare_part_id')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }
}

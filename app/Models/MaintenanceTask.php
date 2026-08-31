<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceTask extends Model
{
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
        static::created(function ($task) {
            if ($task->assigned_to) {
                $task->notifyTechnician();
            }
        });

        static::updated(function ($task) {
            if ($task->wasChanged('assigned_to') && $task->assigned_to) {
                $task->notifyTechnician();
            }

            // Görev tamamlandıysa ve bir plana bağlıysa, bir sonraki görevi otomatik oluştur
            if ($task->wasChanged('status') && $task->status === 'done' && $task->plan) {
                $task->plan->createNextTaskFromCompleted($task);
            }
        });

        static::deleting(function ($task) {
            // Görev silindiğinde kullanılan yedek parçaları stoğa geri iade et
            foreach ($task->spareParts as $sparePart) {
                $sparePart->adjustStock($sparePart->pivot->quantity_used, 'in', $task->id, 'Bakım görevi silindiği için iade');
            }
        });
    }

    public function notifyTechnician()
    {
        if (!$this->assignedUser) return;

        // E-posta bildirimi
        try {
            if (class_exists(\App\Mail\TaskAssignedMail::class)) {
                \Illuminate\Support\Facades\Mail::to($this->assignedUser->email)
                    ->send(new \App\Mail\TaskAssignedMail($this));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('E-posta gönderilemedi: ' . $e->getMessage());
        }
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getTotalCostAttribute()
    {
        $sparePartsCost = $this->spareParts()->sum('task_spare_parts.quantity_used * spare_parts.unit_cost');
        return ($this->actual_cost ?: 0) + ($this->labor_cost ?: 0) + ($this->material_cost ?: 0) + $sparePartsCost;
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
        return $this->sla_status === 'İçinde' ? 'emerald' : 'rose';
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

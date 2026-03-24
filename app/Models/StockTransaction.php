<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $fillable = [
        'company_id',
        'spare_part_id',
        'task_id',
        'user_id',
        'type',
        'quantity',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }

    public function task()
    {
        return $this->belongsTo(MaintenanceTask::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = [
        'company_id',
        'supplier_id',
        'name',
        'code',
        'unit',
        'stock_quantity',
        'min_stock',
        'unit_cost',
    ];

    protected $casts = [
        'stock_quantity' => 'decimal:2',
        'min_stock' => 'decimal:2',
        'unit_cost' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function maintenanceTasks()
    {
        return $this->belongsToMany(MaintenanceTask::class, 'task_spare_parts', 'spare_part_id', 'task_id')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function adjustStock($quantity, $type, $taskId = null, $notes = null)
    {
        $this->stockTransactions()->create([
            'company_id' => $this->company_id,
            'user_id' => auth()->id(),
            'task_id' => $taskId,
            'type' => $type,
            'quantity' => $quantity,
            'notes' => $notes,
        ]);

        if ($type === 'in' || ($type === 'adjustment' && $quantity > 0)) {
            $this->increment('stock_quantity', abs($quantity));
        } else {
            $this->decrement('stock_quantity', abs($quantity));
        }
    }
}
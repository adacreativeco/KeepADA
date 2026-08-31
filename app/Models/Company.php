<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 
        'slug',
        'plan',
        'plan_expires_at',
        'max_locations',
        'max_equipment',
        'max_users',
    ];

    protected $casts = [
        'plan_expires_at' => 'date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function maintenanceTasks()
    {
        return $this->hasMany(MaintenanceTask::class);
    }

    public function maintenancePlans()
    {
        return $this->hasMany(MaintenancePlan::class);
    }

    public function spareParts()
    {
        return $this->hasMany(SparePart::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function meterReadings()
    {
        return $this->hasMany(MeterReading::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function isBasics()
    {
        return $this->plan === 'basics';
    }

    public function isProfessional()
    {
        return $this->plan === 'professional';
    }

    public function isEnterprise()
    {
        return $this->plan === 'enterprise';
    }
}

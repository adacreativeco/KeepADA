<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentApiController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->companies()->first()->equipment;
    }

    public function show(Request $request, $id)
    {
        $company = $request->user()->companies()->first();
        return $company->equipment()->with(['location', 'supplier', 'maintenanceTasks'])->findOrFail($id);
    }
}
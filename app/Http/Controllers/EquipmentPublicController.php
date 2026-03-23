<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Equipment;

class EquipmentPublicController extends Controller
{
    public function show($code)
    {
        $equipment = Equipment::where('code', $code)->orWhere('qr_code', $code)->firstOrFail();
        
        return view('equipment.public-view', compact('equipment'));
    }
}

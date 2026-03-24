<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EquipmentPublicController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/e/{code}', [EquipmentPublicController::class, 'show'])->name('equipment.public-show');

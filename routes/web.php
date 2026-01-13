<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\OperatorTracker;

//Dashboard completo
Route::get('/dashboard', function () {
    return view('dashboard-seguimiento');
})->name('dashboard');

//Reporte tradicional (Sin livewire)
Route::get('/reporte', function () {
    return view('reporte_seguimiento');
})->name('reporte');

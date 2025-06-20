<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaybillController;
use App\Http\Controllers\ChargerController;
use App\Models\Charger;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('index');
})->name('dashboard.index');



// Paybill routes
Route::get('/paybill/create', [PaybillController::class, 'create'])->name('paybill.create');
Route::post('/paybill/store', [PaybillController::class, 'store'])->name('paybill.store');
// Route::get('/paybill', [PaybillController::class, 'paybill'])->name('paybill.index');
Route::get('/paybill', function () {
    return view('paybill');
})->name('paybill.index');



// Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

// Show the report page (default)
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

// Handle filter form submission
Route::get('/reports/filter', [App\Http\Controllers\ReportController::class, 'filter'])->name('reports.filter');

// Handle download request (filtered CSV or PDF)
Route::get('/reports/download', [App\Http\Controllers\ReportController::class, 'download'])->name('reports.download');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Charger routes
// Route::get('/dashboard', [ChargerController::class, 'index'])->name('dashboard');

Route::get('/chargers', [ChargerController::class, 'index']);

Route::get('/chargers', function () {
    return view('chargers', ['chargers' => Charger::all()]);
})->name('chargers.index');

Route::post('/chargers', [ChargerController::class, 'store']);
Route::put('/chargers/{id}', [ChargerController::class, 'update']);
Route::delete('/chargers/{id}', [ChargerController::class, 'destroy']);

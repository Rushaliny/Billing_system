<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaybillController;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('index');
})->name('dashboard.index');


Route::get('/chargers', function () {
    return view('chargers');
})->name('chargers.index');

Route::get('/paybill', function () {
    return view('paybill');
})->name('paybill.index');

Route::post('/paybill', function () {
    // Handle the form submission
})->name('paybill.store');

// Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

// Show the report page (default)
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

// Handle filter form submission
Route::get('/reports/filter', [App\Http\Controllers\ReportController::class, 'filter'])->name('reports.filter');

// Handle download request (filtered CSV or PDF)
Route::get('/reports/download', [App\Http\Controllers\ReportController::class, 'download'])->name('reports.download');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



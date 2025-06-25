<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaybillController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;


use App\Models\Charger;

// Login routes

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/login', [LoginController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {

// Show the report page (default)
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');


    Route::get('/profile', action: [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', action: [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/index', action: [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/chargers', [ChargerController::class, 'index']);


    Route::get('/chargers', function () {
        return view('chargers', ['chargers' => Charger::all()]);
    })->name('chargers.index');

    Route::post('/chargers', action: [ChargerController::class, 'store']);
    Route::put('/chargers/{id}', [ChargerController::class, 'update']);
    Route::delete('/chargers/{id}', [ChargerController::class, 'destroy']);
    Route::get('/get-charge/{type}', [App\Http\Controllers\ChargerController::class, 'getCharge']);




    // Handle filter form submission
    Route::get('/reports/filter', [App\Http\Controllers\ReportController::class, 'filter'])->name('reports.filter');

    // Handle download request (filtered CSV or PDF)
    Route::get('/reports/download', [App\Http\Controllers\ReportController::class, 'download'])->name('reports.download');



    // Paybill routes
    Route::get('/paybill/create', [PaybillController::class, 'create'])->name('paybill.create');
    Route::post('/paybill/store', [PaybillController::class, 'store'])->name('paybill.store');

    Route::get('/paybill', function () {
        return view('paybill');
    })->name('paybill.index');

    Route::get('/show', [PaybillController::class, 'show'])->name('show');

    Route::get('/paybills/show', [PayBillController::class, 'show'])->name('paybill.show');


    // download routes
    Route::get('/paybill/download/csv', [ReportController::class, 'downloadCsv'])->name('paybill.download.csv');
    Route::get('/reports/download/pdf', [ReportController::class, 'downloadPdf'])->name('paybill.download.pdf');


    // If using web.php
    Route::get('/api/paybills-monthly-income', [App\Http\Controllers\DashboardController::class, 'getMonthlyIncome']);
    Route::get('/api/waterbills-monthly-income', [DashboardController::class, 'getWaterIncome']);

    // Logout route
    // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');




});



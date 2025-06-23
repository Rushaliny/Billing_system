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

// Dashboard route
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Index route






// Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');


// Charger routes
// Route::get('/dashboard', [ChargerController::class, 'index'])->name('dashboard');



// Route::get('/profile', function () {
//     return view('profile');
// })->name('profile.index');



// Route::middleware(['auth'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
//     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
// });
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/login', [LoginController::class, 'logout'])->name('logout');




Route::middleware(['auth'])->group(function () {


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/chargers', [ChargerController::class, 'index']);

Route::get('/chargers', function () {
    return view('chargers', ['chargers' => Charger::all()]);
})->name('chargers.index');

Route::post('/chargers', [ChargerController::class, 'store']);
Route::put('/chargers/{id}', [ChargerController::class, 'update']);
Route::delete('/chargers/{id}', [ChargerController::class, 'destroy']);
Route::get('/get-charge/{type}', [App\Http\Controllers\ChargerController::class, 'getCharge']);



// Show the report page (default)
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

// Handle filter form submission
Route::get('/reports/filter', [App\Http\Controllers\ReportController::class, 'filter'])->name('reports.filter');

// Handle download request (filtered CSV or PDF)
Route::get('/reports/download', [App\Http\Controllers\ReportController::class, 'download'])->name('reports.download');



// Paybill routes
Route::get('/paybill/create', [PaybillController::class, 'create'])->name('paybill.create');
Route::post('/paybill/store', [PaybillController::class, 'store'])->name('paybill.store');
// Route::get('/paybill', [PaybillController::class, 'paybill'])->name('paybill.index');
Route::get('/paybill', function () {
    return view('paybill');
})->name('paybill.index');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/show', [PaybillController::class, 'show'])->name('show');
// Route::get('/reports/download', [ReportController::class, 'download'])->name('reports.download');
Route::get('/paybill/download/csv', [ReportController::class, 'downloadCsv'])->name('paybill.download.csv');
Route::get('/reports/download/pdf', [ReportController::class, 'downloadPdf'])->name('paybill.download.pdf');


});



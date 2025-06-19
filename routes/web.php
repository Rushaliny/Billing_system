<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('index');
})->name('dashboard.index');


Route::get('/chargers', function () {
    return view('chargers');
})->name('chargers.index');




// Route::get('/tables', function () {
//     return view('tables');
// });
// Route::get('/notifications', function () {
//     return view('notifications');
// });
// Route::get('/icons', function () {
//     return view('icons');
// });
// Route::get('/typography', function () {
//     return view('typography');
// });
// Route::get('/forms', function () {
//     return view('forms');
// });


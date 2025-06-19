<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/table', function () {
    return view('table');
});
Route::get('/notifications', function () {
    return view('notifications');
});
Route::get('/icons', function () {
    return view('icons');
});
Route::get('/typography', function () {
    return view('typography');
});
Route::get('/forms', function () {
    return view('forms');
});




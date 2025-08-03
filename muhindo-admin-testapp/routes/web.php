<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bootstrap-test', function () {
    return view('bootstrap-test');
});

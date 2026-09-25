<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorController;

Route::resource('/motor', MotorController::class);

Route::get('/', function () {
    return view('welcome');
});

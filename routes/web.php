<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DashboardController;


Route::get('/', [DashboardController::class,'index'])->name('dashboard');
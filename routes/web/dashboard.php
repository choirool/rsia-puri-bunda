<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/total-users', [DashboardController::class, 'totalUsers'])->name('total-users');
        Route::get('/total-units', [DashboardController::class, 'totalUnits'])->name('total-units');
        Route::get('/total-positions', [DashboardController::class, 'totalPostions'])->name('total-positions');
        Route::get('/total-login-history', [DashboardController::class, 'totalLoginHistory'])->name('total-login-history');
        Route::get('/top-ten-user-login', [DashboardController::class, 'topTenUserLogin'])->name('top-ten-user-login');
    });

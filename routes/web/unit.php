<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;

Route::middleware('auth')->group(function () {
    Route::resources([
        'units' => UnitController::class,
    ]);
});

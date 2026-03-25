<?php

declare(strict_types = 1);

use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\System\SystemController;
use Illuminate\Support\Facades\Route;

Route::prefix('departments')->name('departments.')->group(function (): void {
    Route::get('/', [DepartmentController::class, 'index'])->name('index');
    Route::post('/', [DepartmentController::class, 'store'])->name('store');
    Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
    Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
});

Route::prefix('systems')->name('systems.')->group(function (): void {
    Route::get('/', [SystemController::class, 'index'])->name('index');
    Route::post('/', [SystemController::class, 'store'])->name('store');
    Route::get('/{system}', [SystemController::class, 'show'])->name('show');
    Route::put('/{system}', [SystemController::class, 'update'])->name('update');
});

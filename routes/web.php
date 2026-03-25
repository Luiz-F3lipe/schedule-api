<?php

declare(strict_types = 1);

use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Password\PasswordController;
use App\Http\Controllers\Product\ProductController;
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

Route::prefix('products')->name('products.')->group(function (): void {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
});

Route::prefix('passwords')->name('passwords.')->group(function (): void {
    Route::get('/', [PasswordController::class, 'index'])->name('index');
    Route::post('/', [PasswordController::class, 'store'])->name('store');
    Route::get('/{password}', [PasswordController::class, 'show'])->name('show');
    Route::put('/{password}', [PasswordController::class, 'update'])->name('update');
});

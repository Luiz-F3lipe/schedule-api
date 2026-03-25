<?php

declare(strict_types = 1);

use App\Http\Controllers\Department\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): array => [config('app.name')]);

Route::prefix('api')->name('api.')->group(function (): void {
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
});

<?php

declare(strict_types = 1);

use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Password\PasswordController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\ScheduleStatus\ScheduleStatusController;
use App\Http\Controllers\System\SystemController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function (): void {
    Route::prefix('departments')->name('departments.')->group(function (): void {
        Route::get('/', [DepartmentController::class, 'index'])->name('index')->middleware('permission:department,list');
        Route::post('/', [DepartmentController::class, 'store'])->name('store')->middleware('permission:department,create');
        Route::get('/{department}', [DepartmentController::class, 'show'])->name('show')->middleware('permission:department,show');
        Route::put('/{department}', [DepartmentController::class, 'update'])->name('update')->middleware('permission:department,edit');
    });

    Route::prefix('systems')->name('systems.')->group(function (): void {
        Route::get('/', [SystemController::class, 'index'])->name('index')->middleware('permission:system,list');
        Route::post('/', [SystemController::class, 'store'])->name('store')->middleware('permission:system,create');
        Route::get('/{system}', [SystemController::class, 'show'])->name('show')->middleware('permission:system,show');
        Route::put('/{system}', [SystemController::class, 'update'])->name('update')->middleware('permission:system,edit');
    });

    Route::prefix('products')->name('products.')->group(function (): void {
        Route::get('/', [ProductController::class, 'index'])->name('index')->middleware('permission:product,list');
        Route::post('/', [ProductController::class, 'store'])->name('store')->middleware('permission:product,create');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show')->middleware('permission:product,show');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update')->middleware('permission:product,edit');
    });

    Route::prefix('passwords')->name('passwords.')->group(function (): void {
        Route::get('/', [PasswordController::class, 'index'])->name('index')->middleware('permission:password,list');
        Route::post('/', [PasswordController::class, 'store'])->name('store')->middleware('permission:password,create');
        Route::get('/{password}', [PasswordController::class, 'show'])->name('show')->middleware('permission:password,show');
        Route::put('/{password}', [PasswordController::class, 'update'])->name('update')->middleware('permission:password,edit');
    });

    Route::prefix('schedule-status')->name('schedule-status.')->group(function (): void {
        Route::get('/', [ScheduleStatusController::class, 'index'])->name('index')->middleware('permission:schedule_status,list');
        Route::post('/', [ScheduleStatusController::class, 'store'])->name('store')->middleware('permission:schedule_status,create');
        Route::get('/{scheduleStatus}', [ScheduleStatusController::class, 'show'])->name('show')->middleware('permission:schedule_status,show');
        Route::put('/{scheduleStatus}', [ScheduleStatusController::class, 'update'])->name('update')->middleware('permission:schedule_status,edit');
    });

    Route::prefix('schedules')
        ->name('schedules.')
        // ->middleware('can:own,schedule')
        ->group(function (): void {
            Route::get('/', [ScheduleController::class, 'index'])->name('index')->middleware('permission:schedule,list');
            Route::post('/', [ScheduleController::class, 'store'])->name('store')->middleware('permission:schedule,create');
            Route::get('/{schedule}', [ScheduleController::class, 'show'])->name('show')->middleware('permission:schedule,show');
            Route::put('/{schedule}', [ScheduleController::class, 'update'])->name('update')->middleware('permission:schedule,edit');
            Route::patch('/{schedule}/cancel', [ScheduleController::class, 'cancel'])->name('cancel')->middleware('permission:schedule,edit');
        });

    Route::prefix('user')->name('user.')->group(function (): void {
        Route::get('/me', fn (Request $request) => $request->user());

        Route::get('/', [UserController::class, 'index'])->name('index')->middleware('permission:user,list');
        Route::post('/', [UserController::class, 'store'])->name('store')->middleware('permission:user,create');
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->middleware('permission:user,show');
    });

    Route::prefix('permissions')->name('permissions.')->group(function (): void {
        Route::get('/', [PermissionController::class, 'index'])
            ->name('index')
            ->middleware('permission:user,list');

        Route::get('/me', [PermissionController::class, 'userPermissions'])
            ->name('user-permissions');

        Route::prefix('departments/{department}')->name('departments.')->group(function (): void {
            // Get department permissions
            Route::get('/', [PermissionController::class, 'departmentPermissions'])
                ->name('show')
                ->middleware('permission:department,show');

            // Assign permissions to department (add without removing existing)
            Route::post('/assign', [PermissionController::class, 'assignPermissions'])
                ->name('assign')
                ->middleware('permission:department,edit');

            // Remove permissions from department
            Route::post('/remove', [PermissionController::class, 'removePermissions'])
                ->name('remove')
                ->middleware('permission:department,edit');

            // Sync permissions (replace all)
            Route::post('/sync', [PermissionController::class, 'syncPermissions'])
                ->name('sync')
                ->middleware('permission:department,edit');
        });
    });
});

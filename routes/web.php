<?php

declare(strict_types = 1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function (): void {
    Route::post('/auth/session', [AuthController::class, 'login'])->name('login');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
});

Route::get('/pdf/relatorio-vendas', [ReportController::class, 'sales']);

<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TotalVisitorConttroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', DashboardController::class)->name('admin.dashboard');

    // Filter Total Visitor
    Route::get('filter/total-visitor', [TotalVisitorConttroller::class, 'filter'])->name('admin.filter.total-visitor');
});

require __DIR__ . '/auth.php';

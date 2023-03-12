<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TotalVisitorConttroller;
use App\Http\Controllers\Admin\VirusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', DashboardController::class)->name('admin.dashboard');

    // Filter Total Visitor
    Route::get('filter/total-visitor', [TotalVisitorConttroller::class, 'filter'])->name('admin.filter.total-visitor');

    // Bank Data
    Route::resource('bank', BankController::class, ['as' => 'admin']);

    // Author
    Route::resource('author', AuthorController::class, ['as' => 'admin']);

    // Virus
    Route::resource('virus', VirusController::class, ['as' => 'admin']);
});

require __DIR__ . '/auth.php';

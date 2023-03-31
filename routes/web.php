<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CasesController;
use App\Http\Controllers\Admin\CitationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TotalVisitorConttroller;
use App\Http\Controllers\Admin\VirusController;
use App\Http\Controllers\Admin\GenotipeController;
use App\Http\Controllers\Admin\HivCaseController;
use App\Http\Controllers\Admin\TransmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {

    Route::post('/filter-visitor', [DashboardController::class, 'filterVisitor'])->name('admin.dashboard.filter-visitor');
    Route::post('/filter-sample', [DashboardController::class, 'filterSample'])->name('admin.dashboard.filter-sample');
    Route::get('/', DashboardController::class)->name('admin.dashboard');

    // Bank Data
    Route::get('bank/print', [BankController::class, 'print'])->name('admin.bank.print');
    Route::get('bank/get-data', [BankController::class, 'getData'])->name('admin.bank.get-data');
    Route::get('bank/advanced-search', [BankController::class, 'advancedSearch'])->name('admin.bank.advanced-search');
    Route::post('bank/import', [BankController::class, 'import'])->name('admin.bank.import');
    Route::post('bank/get-district', [BankController::class, 'getDistrict'])->name('admin.bank.get-district');
    Route::post('bank/get-genotipe', [BankController::class, 'getGenotipe'])->name('admin.bank.get-genotipe');
    Route::post('bank/get-regency', [BankController::class, 'getRegency'])->name('admin.bank.get-regency');
    Route::resource('bank', BankController::class, ['as' => 'admin']);

    // Author
    Route::resource('author', AuthorController::class, ['as' => 'admin']);

    // Virus
    Route::resource('virus', VirusController::class, ['as' => 'admin']);

    // Genotipe & Subtipe
    Route::resource('genotipe', GenotipeController::class, ['as' => 'admin']);

    // Transmission
    Route::resource('transmission', TransmissionController::class, ['as' => 'admin']);

    // HIV Case
    Route::post('hiv-case/import', [HivCaseController::class, 'import'])->name('admin.hiv-case.import');
    Route::resource('hiv-case', HivCaseController::class, ['as' => 'admin']);

    // Cases
    Route::get('cases/hiv', [CasesController::class, 'hiv'])->name('admin.cases.hiv');

    // Citation
    Route::resource('citation', CitationController::class, ['as' => 'admin']);
});

require __DIR__ . '/auth.php';

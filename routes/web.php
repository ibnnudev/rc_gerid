<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CasesController;
use App\Http\Controllers\Admin\CitationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GenotipeController;
use App\Http\Controllers\Admin\HivCaseController;
use App\Http\Controllers\Admin\ImportRequestController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TransmissionController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\VirusController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\SlideController;
use Illuminate\Support\Facades\Route;

// Frontend
Route::get('/chartGroupYear', [FrontendController::class, 'groupChartYear'])->name('groupChartYear');
Route::get('/chartGroupCity', [FrontendController::class, 'groupChartCity'])->name('groupChartCity');
Route::get('/setStateMaps', [FrontendController::class, 'getGrouping'])->name('getGrouping');
Route::get('/home', [FrontendController::class, 'home'])->name('home');
Route::get('/detail-virus/{name}', [FrontendController::class, 'detail'])->name('detail-virus');
Route::post('/list-citation', [FrontendController::class, 'listCitations'])->name('listCitation');
Route::get('/detail-citation/{id}', [FrontendController::class, 'detailCitation'])->name('detailCitation');
Route::get('/detail-fasta/{id}', [FrontendController::class, 'detailFasta'])->name('detailFasta');
Route::get('/dowloadFasta', [FrontendController::class, 'downloadFasta'])->name('downloadFasta');

Route::get('/', function () {
    return redirect()->route('home');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    // Dashboard
    Route::post('/filter-visitor', [DashboardController::class, 'filterVisitor'])->name('admin.dashboard.filter-visitor');
    Route::post('/filter-sample', [DashboardController::class, 'filterSample'])->name('admin.dashboard.filter-sample');
    Route::get('/', DashboardController::class)->name('admin.dashboard');

    // Slide
    Route::resource('slide', SlideController::class, ['as' => 'admin'])->middleware('is_admin');

    // Bank Data
    Route::post('bank/recovery-by-file-code', [BankController::class, 'recoveryByFileCode'])->name('admin.bank.recovery-by-file-code')->middleware('is_admin');
    Route::post('bank/delete-by-file-code', [BankController::class, 'deleteByFileCode'])->name('admin.bank.delete-by-file-code');
    Route::get('bank/imported', [BankController::class, 'imported'])->name('admin.bank.imported');
    Route::get('bank/print', [BankController::class, 'print'])->name('admin.bank.print');
    Route::get('bank/get-data', [BankController::class, 'getData'])->name('admin.bank.get-data')->middleware('is_admin');
    Route::get('bank/advanced-search', [BankController::class, 'advancedSearch'])->name('admin.bank.advanced-search')->middleware('is_admin');
    Route::post('bank/import', [BankController::class, 'import'])->name('admin.bank.import')->middleware('is_admin');
    Route::post('bank/get-district', [BankController::class, 'getDistrict'])->name('admin.bank.get-district')->middleware('is_admin');
    Route::post('bank/get-genotipe', [BankController::class, 'getGenotipe'])->name('admin.bank.get-genotipe')->middleware('is_admin');
    Route::post('bank/get-regency', [BankController::class, 'getRegency'])->name('admin.bank.get-regency')->middleware('is_admin');
    Route::resource('bank', BankController::class, ['as' => 'admin'])->middleware('is_admin');

    // Author
    Route::resource('author', AuthorController::class, ['as' => 'admin'])->middleware('is_admin');

    // Virus
    Route::resource('virus', VirusController::class, ['as' => 'admin'])->middleware('is_admin');

    // Genotipe & Subtipe
    Route::resource('genotipe', GenotipeController::class, ['as' => 'admin'])->middleware('is_admin');

    // Transmission
    Route::resource('transmission', TransmissionController::class, ['as' => 'admin'])->middleware('is_admin');

    // HIV Case
    Route::post('hiv-case/import', [HivCaseController::class, 'import'])->name('admin.hiv-case.import')->middleware('is_admin');
    Route::resource('hiv-case', HivCaseController::class, ['as' => 'admin'])->middleware('is_admin');

    // Cases
    Route::get('cases/hiv', [CasesController::class, 'hiv'])->name('admin.cases.hiv')->middleware('is_admin');

    // Citation
    Route::post('citation/get-citation-by-author', [CitationController::class, 'getCitationByAuthor'])->name('admin.citation.get-citation-by-author');
    Route::resource('citation', CitationController::class, ['as' => 'admin'])->middleware('is_admin');

    // Management User
    Route::group(['middleware' => 'is_admin'], function () {
        Route::post('user-management/role', [UserManagementController::class, 'role'])->name('admin.user-management.role');
        Route::get('user-management/activate/{id}', [UserManagementController::class, 'activate'])->name('admin.user-management.activate');
        Route::get('user-management/deactivate/{id}', [UserManagementController::class, 'deactivate'])->name('admin.user-management.deactivate');
        Route::resource('user-management', UserManagementController::class, ['as' => 'admin']);
    });

    // Import Request
    Route::put('import-request/change-status-single/{id}', [ImportRequestController::class, 'changeStatusSingle'])->name('admin.import-request.change-status-single');
    Route::put('import-request/update-single/{id}', [ImportRequestController::class, 'updateSingle'])->name('admin.import-request.update-single');
    Route::get('import-request/show-single/{id}', [ImportRequestController::class, 'showSingle'])->name('admin.import-request.show-single');
    Route::get('import-request/edit-single/{id}', [ImportRequestController::class, 'editSingle'])->name('admin.import-request.edit-single');
    Route::post('import-request/store-single', [ImportRequestController::class, 'storeSingle'])->name('admin.import-request.store-single');
    Route::get('import-request/create-single/{fileCode}', [ImportRequestController::class, 'createSingle'])->name('admin.import-request.create-single');
    Route::post('import-request/import', [ImportRequestController::class, 'import'])->name('admin.import-request.import');
    Route::post('import-request/validation-file', [ImportRequestController::class, 'validationFile'])->name('admin.import-request.validation-file');
    Route::post('import-request/change-status', [ImportRequestController::class, 'changeStatus'])->name('admin.import-request.change-status')->middleware('is_admin');
    Route::get('import-request/admin', [ImportRequestController::class, 'admin'])->name('admin.import-request.admin')->middleware('is_admin');
    Route::resource('import-request', ImportRequestController::class, ['as' => 'admin']);

    // Profile
    Route::post('profile/change-password', [ProfileController::class, 'changePassword'])->name('admin.profile.change-password');
    Route::resource('profile', ProfileController::class, ['as' => 'admin'])->only(['index', 'update']);
});

require __DIR__ . '/auth.php';

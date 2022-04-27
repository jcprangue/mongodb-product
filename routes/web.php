<?php

use App\Http\Controllers\BarangayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProcurementRecordController;
use App\Http\Controllers\ProcurementDetailsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LGUsController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\DocumentFieldController;
use App\Http\Controllers\CategoryDocumentController;
use App\Http\Controllers\ProcurementRecordLinkController;
use App\Http\Controllers\UserHistoryController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('/search', SearchController::class);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/records', ProcurementRecordController::class);
    Route::resource('/records-details', ProcurementDetailsController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/LGUs', LGUsController::class);
    Route::resource('/documents', DocumentsController::class);
    Route::resource('/document-type/field', DocumentFieldController::class);
    Route::resource('/category-document', CategoryDocumentController::class);
    Route::resource('/records-link', ProcurementRecordLinkController::class);
    Route::resource('/user-history', UserHistoryController::class);
    Route::resource('/brgy', BarangayController::class)->except([
        'create'
    ]);;


    //extension function in resource
    Route::get('/records/list/export', [ProcurementRecordController::class, 'export'])->name('records.export');
    Route::get('/records/list/pdf', [ProcurementRecordController::class, 'pdf'])->name('records.pdf');
    Route::post('/dashboard/status/category', [DashboardController::class, 'getCategoryChart'])->name('dashboard.stat.category');
    Route::get('/brgy/{id}/create', [BarangayController::class, 'create'])->name('brgy.create');
    Route::post('/document-type/field/listOrder', [DocumentFieldController::class, 'updateOrder'])->name('field.updateOrder');
    Route::post('/records-details/listUpdate', [ProcurementDetailsController::class, 'listDetails'])->name('records-details.listUpdate');
    Route::post('/records-details/headerList', [ProcurementDetailsController::class, 'headerList'])->name('records-details.headerList');
});

<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ClientTypeController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\ServiceOptionController;
use App\Http\Controllers\Admin\SurveyAdminController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'security.headers'])->group(function () {
    // Public Client Satisfaction Survey Routes
    Route::get('/', [SurveyController::class, 'create'])->name('survey.create');
    Route::post('/survey', [SurveyController::class, 'store'])->middleware('throttle:10,1')->name('survey.store');
    Route::get('/survey/success/{reference}', [SurveyController::class, 'success'])->name('survey.success');
    Route::get('/survey/print/{reference}', [SurveyController::class, 'print'])->name('survey.print');

    // Admin sign-in routes
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->middleware('throttle:5,1')->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.submit');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

    // Admin Analytics & Response Management Routes
    Route::prefix('admin')->name('admin.')->middleware(['admin.auth'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
        Route::get('/dashboard', [SurveyAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/surveys', [SurveyAdminController::class, 'index'])->name('surveys.index');
        Route::get('/offices', [OfficeController::class, 'index'])->name('offices.index');
        Route::post('/offices', [OfficeController::class, 'store'])->name('offices.store');
        Route::put('/offices/{office}', [OfficeController::class, 'update'])->name('offices.update');
        Route::delete('/offices/{office}', [OfficeController::class, 'destroy'])->name('offices.destroy');
        Route::post('/client-types', [ClientTypeController::class, 'store'])->name('client-types.store');
        Route::delete('/client-types/{clientType}', [ClientTypeController::class, 'destroy'])->name('client-types.destroy');
        Route::post('/service-options', [ServiceOptionController::class, 'store'])->name('service-options.store');
        Route::delete('/service-options/{serviceOption}', [ServiceOptionController::class, 'destroy'])->name('service-options.destroy');
        Route::get('/surveys/export', [SurveyAdminController::class, 'exportCsv'])->name('surveys.export');
        Route::get('/surveys/report/print', [SurveyAdminController::class, 'printReport'])->name('surveys.report.print');
        Route::get('/surveys/{response}', [SurveyAdminController::class, 'show'])->name('surveys.show');
        Route::delete('/surveys/{response}', [SurveyAdminController::class, 'destroy'])->name('surveys.destroy');
    });
});

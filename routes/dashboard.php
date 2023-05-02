<?php

use App\Http\Controllers\Administration\AdministrationController;
use App\Http\Controllers\Administration\ContactController;
use App\Http\Controllers\Administration\FinanceController;
use App\Http\Controllers\Administration\NewsController;
use App\Http\Controllers\Api\FileController as ApiFileController;
use App\Http\Controllers\Api\GroundMovementController as ApiGroundMovementController;
use App\Http\Controllers\Api\ProfileController as ApiProfileController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroundMovement\EventController as GroundMovementEventController;
use App\Http\Controllers\GroundMovementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// all route here have prefix dashboard already
// todo, FIND THE FUCK OUT WHY!?

// Tata Usaha
Route::name('admin.')
    ->middleware('auth')
    ->group(function () {

        // employee
        // internal - todo finish internal management user
        Route::get(
            '/admin/employee/index',
            [AdministrationController::class, 'index']
        )->name('employee.index');

        Route::get(
            '/admin/employee/get',
            [AdministrationController::class, 'getEmployee']
        )->name('employee.get');

        // sipeg
        Route::get(
            '/admin/employee/sipeg',
            [AdministrationController::class, 'indexSipeg']
        )->name('employee.sipeg');

        Route::get(
            '/admin/employee/get-sipeg',
            [AdministrationController::class, 'getEmployeeSipeg']
        )->name('employee.get-sipeg');

        // nominative
        Route::get(
            '/admin/finance/input-nominative',
            [FinanceController::class, 'masterNominative']
        )->name('finance.get.master-nominative');

        Route::post(
            '/admin/finance/input-nominative',
            [FinanceController::class, 'saveMasterNominative']
        )->name('finance.post.master-nominative');

        Route::get(
            '/admin/finance/input-nominative/step/nom/{id}',
            [FinanceController::class, 'nominative']
        )->name('finance.get.nominative');

        Route::get(
            '/admin/finance/input-nominative/view/{id}',
            [FinanceController::class, 'viewNominative']
        )->name('finance.view.nominative');

        Route::post(
            '/admin/finance/input-nominative/step/nom',
            [FinanceController::class, 'saveNominative']
        )->name('finance.post.nominative');

        Route::post(
            '/admin/finance/input-nominative/step/bp',
            [FinanceController::class, 'saveBudgetPlan']
        )->name('finance.post.bp');

        Route::post(
            '/admin/finance/input-nominative/step/cpd',
            [FinanceController::class, 'saveCostPlanDetail']
        )->name('finance.post.cpd');

        // tracking sppd
        Route::get(
            '/admin/finance/track-spd',
            [FinanceController::class, 'trackSpd']
        )->name('finance.get.track-spd');

        Route::get(
            '/admin/finance/get-spd',
            [FinanceController::class, 'getDataSpd']
        )->name('finance.post.get-spd');
    });

// Default routing dashboard
Route::get('/', [DashboardController::class, 'index'])->name('index');

// Pegawai
Route::prefix('pegawai')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('pegawai.index');
    Route::get('/create', 'create')->name('pegawai.create');
    Route::get('/{id}/edit', 'edit')->name('pegawai.edit');
    Route::get('/export', 'export')->name('pegawai.export');
});

// Layanan Publik
Route::prefix('layanan-publik')->name('layanan-publik.')->group(function () {
    $layananPublik = 'dashboard.layanan-publik';

    // Layanan Publik > Kerja Sama > Informasi Kerja Sama
    Route::prefix('kerja-sama')->name('kerja-sama.')->group(function () use ($layananPublik) {
        $kerjaSama = "$layananPublik.kerja-sama";

        // Layanan Publik > Kerja Sama > Informasi Kerja Sama
        Route::view(
            'informasi',
            "$kerjaSama.informasi.index"
        )->name('informasi');
    });

    // Layanan Publik > Kontak
    Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');

    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/add', [NewsController::class, 'add'])->name('news.add');
    Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
});

// Gerakan Tanah
Route::prefix('gerakan-tanah')->name('gerakan-tanah.')->group(function () {
    // Gerakan Tanah > Daftar Kejadian
    Route::prefix('kejadian')->controller(GroundMovementEventController::class)->group(function () {
        Route::get('/', 'index')->name('kejadian.index');
        Route::get('/create', 'create')->name('kejadian.create');
        Route::post('/', 'store')->name('kejadian.store');
        Route::get('/{id}/edit', 'edit')->name('kejadian.edit');
        Route::put('/{id}', 'update')->name('kejadian.update');
        Route::delete('/{id}', 'destroy')->name('kejadian.destroy');
    });

    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/add', [NewsController::class, 'add'])->name('news.add');
    Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');

    Route::controller(GroundMovementController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{id}/edit', 'edit')->name('edit');
    });
});

Route::prefix('gunung-api')->name('gunung-api.')->group(function () {
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/add', [NewsController::class, 'add'])->name('news.add');
    Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
});

Route::prefix('gempa-bumi-tsunami')->name('gempa-bumi-tsunami.')->group(function () {
    Route::get('/news', [NewsController::class, 'index'])->name('news');
    Route::get('/news/add', [NewsController::class, 'add'])->name('news.add');
    Route::get('/news/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
});
// Profile
Route::prefix('profile')->name('profile.')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/{id}/form', 'edit')->name('index');
    });
});

// Upload Center
Route::prefix('upload-center')->name('upload-center.')->group(function () {
    Route::controller(FileController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
    });
});

// Api
Route::group(['middleware' => ['auth'], 'prefix' => 'api'], function () {
    // Gerakan Tanah
    Route::group(['prefix' => 'gerakan-tanah'], function () {
        Route::controller(ApiGroundMovementController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/', 'update');
            Route::delete('/', 'destroy');
        });
    });

    // Profile
    Route::group(['prefix' => 'profile'], function () {
        Route::controller(ApiProfileController::class)->group(function () {
            Route::post('/', 'store');
            Route::put('/', 'update');
        });
    });

    // Pegawai
    Route::group(['prefix' => 'pegawai'], function () {
        Route::controller(ApiUserController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/', 'update');
            Route::delete('/', 'destroy');
        });
    });

    // Upload Center
    Route::group(['prefix' => 'upload-center'], function () {
        Route::controller(ApiFileController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::delete('/', 'destroy');
            Route::get('/label', 'indexLabel');
            Route::get('/tags', 'indexTags');
        });
    });
});

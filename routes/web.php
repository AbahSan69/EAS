<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController as GlobalDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\EnterpriseArchitectureController as AdminEnterpriseArchitectureController;
use App\Http\Controllers\Admin\EA\VisionController as AdminEAVisionController;
use App\Http\Controllers\Admin\ProgressMonitoringController as AdminProgressMonitoringController;

use App\Http\Controllers\Admin\EA\DomainController as AdminEADomainController;
use App\Http\Controllers\Admin\EA\SubDomainController as AdminEASubDomainController;
use App\Http\Controllers\Admin\EA\ComponentController as AdminEAComponentController;

//Stakeholder PTS Controller
use App\Http\Controllers\StakeholderPTS\DashboardController as StakeholderPTSDashboardController;
use App\Http\Controllers\StakeholderPTS\HomeController as StakeholderPTSHomeController;
use App\Http\Controllers\StakeholderPTS\EA\ContentController as StakeholderPTSContentController;
use App\Http\Controllers\StakeholderPTS\EnterpriseArchitectureController as StakeholderPTSEnterpriseArchitectureController;
use App\Http\Controllers\StakeholderPTS\ProgressMonitoringController as StakeholderPTSProgressMonitoringController;

//Yayasan
use App\Http\Controllers\Yayasan\DashboardController as YayasanDashboardController;
use App\Http\Controllers\Yayasan\EA\ContentController as YayasanContentController;

use App\Http\Controllers\Yayasan\ProgressMonitoringController as YayasanProgressMonitoringController;
use App\Http\Controllers\EA\VisionController;
use App\Http\Controllers\PerguruanTinggiController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/api/kampus', [PerguruanTinggiController::class, 'index'])->name('api.kampus');
Route::get('/register', [AuthController::class, 'halaman_register'])->name('halaman_register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'halaman_login'])->name('halaman_login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware(['auth'])->group(function () {
    // Dashboard umum
    Route::get('/dashboard', [GlobalDashboardController::class, 'dashboard'])->name('dashboard');

    // Admin only
    Route::middleware(['role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard_admin');
        Route::get('/account', [AdminAccountController::class, 'index'])->name('account');
        Route::post('/save_account', [AdminAccountController::class, 'save_account'])->name('save_account');
        Route::post('/update_account', [AdminAccountController::class, 'update_account'])->name('update_account');
        Route::get('/delete_account/{id}', [AdminAccountController::class, 'delete_account'])->name('delete_account');
        Route::prefix('ea')->name('ea.')->group(function () {
            Route::get('/create', [AdminEnterpriseArchitectureController::class, 'create'])->name('create');
            Route::post('/store_pts', [AdminEnterpriseArchitectureController::class, 'store_pts'])->name('store_pts');
            Route::get('/delete_pts/{id}', [AdminEnterpriseArchitectureController::class, 'delete_pts'])->name('delete_pts');
            Route::get('/index/{id}', [AdminEnterpriseArchitectureController::class, 'index'])->name('index');

            Route::prefix('domain')->name('domain.')->group(function () {
                Route::get('/domain', [AdminEADomainController::class, 'index'])->name('show');
                Route::post('/save_domain', [AdminEADomainController::class, 'save_domain'])->name('save_domain');
                Route::post('/update_domain', [AdminEADomainController::class, 'update_domain'])->name('update_domain');
                Route::get('/delete_domain/{id}', [AdminEADomainController::class, 'delete_domain'])->name('delete_domain');
            });

            Route::prefix('subdomain')->name('subdomain.')->group(function () {
                Route::get('/subdomain/{id}', [AdminEASubDomainController::class, 'index'])->name('show');
                Route::post('/save_subdomain', [AdminEASubDomainController::class, 'save_subdomain'])->name('save_subdomain');
                Route::post('/update_subdomain', [AdminEASubDomainController::class, 'update_subdomain'])->name('update_subdomain');
                Route::get('/delete_subdomain/{id}', [AdminEASubDomainController::class, 'delete_subdomain'])->name('delete_subdomain');
            });

            Route::prefix('component')->name('component.')->group(function () {
                Route::get('/component/{id}', [AdminEAComponentController::class, 'index'])->name('show');
                Route::post('/save_component', [AdminEAComponentController::class, 'save_component'])->name('save_component');
                Route::post('/update_component', [AdminEAComponentController::class, 'update_component'])->name('update_component');
                Route::get('/delete_component/{id}', [AdminEAComponentController::class, 'delete_component'])->name('delete_component');
            });
        });

        Route::prefix('progress')->name('progress.')->group(function () {
            Route::get('/load', [AdminProgressMonitoringController::class, 'load'])->name('load');
            Route::post('/load_pts', [AdminProgressMonitoringController::class, 'load_pts'])->name('load_pts');
            Route::get('/index/{id}', [AdminProgressMonitoringController::class, 'index'])->name('index');
        });
    });

    // Stakeholder PTS only
    Route::middleware(['role:Stakeholder PTS'])->prefix('sp')->name('sp.')->group(function () {
        // Route::get('/dashboard', [StakeholderPTSDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard', [StakeholderPTSHomeController::class, 'index'])->name('dashboard');
        Route::prefix('ea')->name('ea.')->group(function () {
            Route::get('/content/{id}', [StakeholderPTSContentController::class, 'index'])->name('content');
            Route::post('/component_content_simpan', [StakeholderPTSContentController::class, 'storeComponent'])->name('component_content_simpan');
            Route::post('/component_content_update/{id}', [StakeholderPTSContentController::class, 'updateComponent'])->name('component_content_update');
            Route::get('/component_content_delete/{id}', [StakeholderPTSContentController::class, 'deleteComponent'])->name('component_content_delete');
            Route::post('/subdomain_content_simpan', [StakeholderPTSContentController::class, 'storeSubdomain'])->name('subdomain_content_simpan');
            Route::get('/component_show/{id}', [StakeholderPTSContentController::class, 'component_detail'])->name('component_show');
            Route::get('/stakeholder_show/{id}', [StakeholderPTSContentController::class, 'stakeholder_detail'])->name('stakeholder_show');
            Route::get('/stakeholder_create/{id}', [StakeholderPTSContentController::class, 'create'])->name('stakeholder_create');
            Route::get('/stakeholder_edit/{id}/{componentId}', [StakeholderPTSContentController::class, 'edit'])->name('stakeholder_edit');
            // Route::post('/stakeholder_simpan', [StakeholderPTSContentController::class, 'storeStakeholder'])->name('stakeholder_simpan');
            Route::post('/stakeholder_store', [StakeholderPTSContentController::class, 'storeStakeholder'])->name('stakeholder_store');
            Route::put('/stakeholder_update', [StakeholderPTSContentController::class, 'updateStakeholder'])->name('stakeholder_update');
            Route::get('stakeholder_destroy/{id}', [StakeholderPTSContentController::class, 'destroyStakeholder'])->name('stakeholder_destroy');
            Route::get('/getComments/{id}', [StakeholderPTSContentController::class, 'getComments'])
            ->name('getComments');
            Route::get('/create', [StakeholderPTSEnterpriseArchitectureController::class, 'create'])->name('create');
            Route::post('/store_pts', [StakeholderPTSEnterpriseArchitectureController::class, 'store_pts'])->name('store_pts');
            Route::get('/index/{id}', [StakeholderPTSEnterpriseArchitectureController::class, 'index'])->name('index');
            
        });

        Route::prefix('progress')->name('progress.')->group(function () {
            Route::get('/load', [StakeholderPTSProgressMonitoringController::class, 'load'])->name('load');
            Route::post('/load_pts', [StakeholderPTSProgressMonitoringController::class, 'load_pts'])->name('load_pts');
            Route::get('/index/{id}', [StakeholderPTSProgressMonitoringController::class, 'index'])->name('index');
        });
    });

    // Yayasan only
    Route::middleware(['role:Yayasan'])->prefix('yayasan')->name('yayasan.')->group(function () {
        Route::get('/dashboard', [YayasanDashboardController::class, 'index'])->name('dashboard');
        Route::prefix('ea')->name('ea.')->group(function () {
            Route::get('/content/{id}', [YayasanContentController::class, 'index'])->name('content');
            Route::get('/component_show/{id}', [YayasanContentController::class, 'component_detail'])->name('component_show');
            Route::get('/stakeholder_show/{id}', [YayasanContentController::class, 'stakeholder_detail'])->name('stakeholder_show');
            Route::get('/getComments/{id}', [YayasanContentController::class, 'getComments'])
            ->name('getComments');
            Route::post('/saveComments', [YayasanContentController::class, 'saveComment'])->name('saveComments');
        });
        Route::get('/load', [YayasanProgressMonitoringController::class, 'load'])->name('load');
        Route::post('/load_pts', [YayasanProgressMonitoringController::class, 'load_pts'])->name('load_pts');
        Route::get('/index/{id}', [YayasanProgressMonitoringController::class, 'index'])->name('index');

    });

});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

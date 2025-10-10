<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController as GlobalDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AccountController as AdminAccountController;
use App\Http\Controllers\Admin\EnterpriseArchitectureController as AdminEnterpriseArchitectureController;
use App\Http\Controllers\Admin\EA\VisionController as AdminEAVisionController;
use App\Http\Controllers\Admin\ProgressMonitoringController as AdminProgressMonitoringController;

use App\Http\Controllers\Admin\EA\AVision\VisiMisiController as AdminEAVisionVisiMisiController;
use App\Http\Controllers\Admin\EA\AVision\PrincipleController as AdminEAVisionPrincipleController;
use App\Http\Controllers\Admin\EA\AVision\BisnisController as AdminEAVisionBisnisController;
use App\Http\Controllers\Admin\EA\AVision\ObjectiveDriverController as AdminEAVisionObjectiveDriverController;

use App\Http\Controllers\Admin\EA\ABisnis\DigitalOrganisasiController as AdminEABisnisDOController;
use App\Http\Controllers\Admin\EA\ABisnis\BisnisInovasiController as AdminEABisnisInovasiController;
use App\Http\Controllers\Admin\EA\ABisnis\AccountabilityController as AdminEABisnisAccountabilityController;
use App\Http\Controllers\Admin\EA\ABisnis\ProdukController as AdminEABisnisProdukController;
use App\Http\Controllers\Admin\EA\ABisnis\ConstrainController as AdminEABisnisConstrainController;
use App\Http\Controllers\Admin\EA\ABisnis\RiskController as AdminEABisnisRiskController;

use App\Http\Controllers\Admin\EA\AInformasi\InformasiController as AdminEAInformasiController;
use App\Http\Controllers\Admin\EA\AAplikasi\AplikasiController as AdminEAAplikasiController;
use App\Http\Controllers\Admin\EA\ATeknologi\TeknologiController as AdminEATeknologiController;
use App\Http\Controllers\Admin\EA\AKeamanan\KeamananController as AdminEAKeamananController;

//Stakeholder PTS Controller
use App\Http\Controllers\StakeholderPTS\DashboardController as StakeholderPTSDashboardController;
use App\Http\Controllers\StakeholderPTS\EnterpriseArchitectureController as StakeholderPTSEnterpriseArchitectureController;

use App\Http\Controllers\StakeholderPTS\EA\AVision\VisionVisiMisiController as StakeholderPTSEAVisionVisiMisiController;
use App\Http\Controllers\StakeholderPTS\EA\AVision\VisionPrincipleController as StakeholderPTSEAVisionPrincipleController;
use App\Http\Controllers\StakeholderPTS\EA\AVision\VisionBisnisController as StakeholderPTSEAVisionBisnisController;
use App\Http\Controllers\StakeholderPTS\EA\AVision\VisionObjectiveDriverController as StakeholderPTSEAVisionObjectiveDriverController;
use App\Http\Controllers\StakeholderPTS\ProgressMonitoringController as StakeholderPTSProgressMonitoringController;

use App\Http\Controllers\StakeholderPTS\EA\ABisnis\DigitalOrganisasiController as StakeholderPTSEABisnisDOController;
use App\Http\Controllers\StakeholderPTS\EA\ABisnis\BisnisInovasiController as StakeholderPTSEABisnisInovasiController;
use App\Http\Controllers\StakeholderPTS\EA\ABisnis\AccountabilityController as StakeholderPTSEABisnisAccountabilityController;
use App\Http\Controllers\StakeholderPTS\EA\ABisnis\ProdukController as StakeholderPTSEABisnisProdukController;
use App\Http\Controllers\StakeholderPTS\EA\ABisnis\ConstrainController as StakeholderPTSEABisnisConstrainController;
use App\Http\Controllers\StakeholderPTS\EA\ABisnis\RiskController as StakeholderPTSEABisnisRiskController;

use App\Http\Controllers\StakeholderPTS\EA\AInformasi\InformasiController as StakeholderPTSEAInformasiController;
use App\Http\Controllers\StakeholderPTS\EA\AAplikasi\AplikasiController as StakeholderPTSEAAplikasiController;
use App\Http\Controllers\StakeholderPTS\EA\ATeknologi\TeknologiController as StakeholderPTSEATeknologiController;
use App\Http\Controllers\StakeholderPTS\EA\AKeamanan\KeamananController as StakeholderPTSEAKeamananController;

//Yayasan
use App\Http\Controllers\Yayasan\DashboardController as YayasanDashboardController;
use App\Http\Controllers\Yayasan\Vision\VisiMisiController as YayasanVisionVisiMisiController;
use App\Http\Controllers\Yayasan\Vision\PrincipleController as YayasanVisionPrincipleController;
use App\Http\Controllers\Yayasan\Vision\BisnisController as YayasanVisionBisnisController;
use App\Http\Controllers\Yayasan\Vision\ObjectiveDriverController as YayasanVisionObjectiveDriverController;

use App\Http\Controllers\Yayasan\Bisnis\DigitalOrganisasiController as YayasanBisnisDigitalOrganisasiController;
use App\Http\Controllers\Yayasan\Bisnis\BisnisInovasiController as YayasanBisnisBisnisInovasiController;
use App\Http\Controllers\Yayasan\Bisnis\AccountabilityController as YayasanBisnisAccountabilityController;
use App\Http\Controllers\Yayasan\Bisnis\ProdukController as YayasanBisnisProdukController;
use App\Http\Controllers\Yayasan\Bisnis\ConstrainController as YayasanBisnisConstrainController;
use App\Http\Controllers\Yayasan\Bisnis\RiskController as YayasanBisnisRiskController;
use App\Http\Controllers\Yayasan\Informasi\InformasiController as YayasanInformasiController;
use App\Http\Controllers\Yayasan\Aplikasi\AplikasiController as YayasanAplikasiController;
use App\Http\Controllers\Yayasan\Teknologi\TeknologiController as YayasanTeknologiController;
use App\Http\Controllers\Yayasan\Keamanan\KeamananController as YayasanKeamananController;
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
    Route::middleware(['role:1'])->prefix('admin')->name('admin.')->group(function () {
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
            Route::prefix('vision')->name('vision.')->group(function () {
                Route::prefix('visimisi')->name('visimisi.')->group(function () {
                    Route::get('/show/{id}', [AdminEAVisionVisiMisiController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEAVisionVisiMisiController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEAVisionVisiMisiController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEAVisionVisiMisiController::class, 'delete'])->name('delete');
                });
                Route::prefix('principle')->name('principle.')->group(function () {
                    Route::get('/show/{id}', [AdminEAVisionPrincipleController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEAVisionPrincipleController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEAVisionPrincipleController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEAVisionPrincipleController::class, 'delete'])->name('delete');
                });
                Route::prefix('bisnis')->name('bisnis.')->group(function () {
                    Route::get('/show/{id}', [AdminEAVisionBisnisController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEAVisionBisnisController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEAVisionBisnisController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEAVisionBisnisController::class, 'delete'])->name('delete');
                });
                Route::prefix('objective_driver')->name('objective_driver.')->group(function () {
                    Route::get('/show/{id}', [AdminEAVisionObjectiveDriverController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEAVisionObjectiveDriverController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEAVisionObjectiveDriverController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEAVisionObjectiveDriverController::class, 'delete'])->name('delete');
                });
            });

            Route::prefix('bisnis')->name('bisnis.')->group(function () {
                Route::prefix('do')->name('do.')->group(function () {
                    Route::get('/show/{id}', [AdminEABisnisDOController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEABisnisDOController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEABisnisDOController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEABisnisDOController::class, 'delete'])->name('delete');
                });

                Route::prefix('bisnis_inovasi')->name('bisnis_inovasi.')->group(function () {
                    Route::get('/show/{id}', [AdminEABisnisInovasiController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEABisnisInovasiController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEABisnisInovasiController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEABisnisInovasiController::class, 'delete'])->name('delete');
                });

                Route::prefix('accountability')->name('accountability.')->group(function () {
                    Route::get('/show/{id}', [AdminEABisnisAccountabilityController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEABisnisAccountabilityController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEABisnisAccountabilityController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEABisnisAccountabilityController::class, 'delete'])->name('delete');
                });

                Route::prefix('produk')->name('produk.')->group(function () {
                    Route::get('/show/{id}', [AdminEABisnisProdukController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEABisnisProdukController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEABisnisProdukController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEABisnisProdukController::class, 'delete'])->name('delete');
                });

                Route::prefix('constrain')->name('constrain.')->group(function () {
                    Route::get('/show/{id}', [AdminEABisnisConstrainController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEABisnisConstrainController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEABisnisConstrainController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEABisnisConstrainController::class, 'delete'])->name('delete');
                });

                Route::prefix('risk')->name('risk.')->group(function () {
                    Route::get('/show/{id}', [AdminEABisnisRiskController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEABisnisRiskController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEABisnisRiskController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEABisnisRiskController::class, 'delete'])->name('delete');
                });
            });

            Route::prefix('informasi')->name('informasi.')->group(function () {
                    Route::get('/show/{id}', [AdminEAInformasiController::class, 'show'])->name('show');
                    Route::post('/save', [AdminEAInformasiController::class, 'save'])->name('save');
                    Route::post('/update', [AdminEAInformasiController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [AdminEAInformasiController::class, 'delete'])->name('delete');
            });

            Route::prefix('aplikasi')->name('aplikasi.')->group(function () {
                Route::get('/show/{id}', [AdminEAAplikasiController::class, 'show'])->name('show');
                Route::post('/save', [AdminEAAplikasiController::class, 'save'])->name('save');
                Route::post('/update', [AdminEAAplikasiController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [AdminEAAplikasiController::class, 'delete'])->name('delete');
            });

            Route::prefix('teknologi')->name('teknologi.')->group(function () {
                Route::get('/show/{id}', [AdminEATeknologiController::class, 'show'])->name('show');
                Route::post('/save', [AdminEATeknologiController::class, 'save'])->name('save');
                Route::post('/update', [AdminEATeknologiController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [AdminEATeknologiController::class, 'delete'])->name('delete');
            });

            Route::prefix('keamanan')->name('keamanan.')->group(function () {
                Route::get('/show/{id}', [AdminEAKeamananController::class, 'show'])->name('show');
                Route::post('/save', [AdminEAKeamananController::class, 'save'])->name('save');
                Route::post('/update', [AdminEAKeamananController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [AdminEAKeamananController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('progress')->name('progress.')->group(function () {
            Route::get('/load', [AdminProgressMonitoringController::class, 'load'])->name('load');
            Route::post('/load_pts', [AdminProgressMonitoringController::class, 'load_pts'])->name('load_pts');
            Route::get('/index/{id}', [AdminProgressMonitoringController::class, 'index'])->name('index');
        });
    });

    // Stakeholder PTS only
    Route::middleware(['role:2'])->prefix('sp')->name('sp.')->group(function () {
        Route::get('/dashboard', [StakeholderPTSDashboardController::class, 'dashboard'])->name('dashboard');
        Route::prefix('ea')->name('ea.')->group(function () {
            Route::get('/create', [StakeholderPTSEnterpriseArchitectureController::class, 'create'])->name('create');
            Route::post('/store_pts', [StakeholderPTSEnterpriseArchitectureController::class, 'store_pts'])->name('store_pts');
            Route::get('/index/{id}', [StakeholderPTSEnterpriseArchitectureController::class, 'index'])->name('index');
            Route::prefix('vision')->name('vision.')->group(function () {
                Route::prefix('visimisi')->name('visimisi.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEAVisionVisiMisiController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEAVisionVisiMisiController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEAVisionVisiMisiController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEAVisionVisiMisiController::class, 'delete'])->name('delete');
                });
                Route::prefix('principle')->name('principle.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEAVisionPrincipleController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEAVisionPrincipleController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEAVisionPrincipleController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEAVisionPrincipleController::class, 'delete'])->name('delete');
                });
                Route::prefix('bisnis')->name('bisnis.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEAVisionBisnisController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEAVisionBisnisController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEAVisionBisnisController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEAVisionBisnisController::class, 'delete'])->name('delete');
                });
                Route::prefix('objective_driver')->name('objective_driver.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEAVisionObjectiveDriverController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEAVisionObjectiveDriverController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEAVisionObjectiveDriverController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEAVisionObjectiveDriverController::class, 'delete'])->name('delete');
                });
            });

            Route::prefix('bisnis')->name('bisnis.')->group(function () {
                Route::prefix('do')->name('do.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEABisnisDOController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEABisnisDOController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEABisnisDOController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEABisnisDOController::class, 'delete'])->name('delete');
                });

                Route::prefix('bisnis_inovasi')->name('bisnis_inovasi.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEABisnisInovasiController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEABisnisInovasiController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEABisnisInovasiController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEABisnisInovasiController::class, 'delete'])->name('delete');
                });

                Route::prefix('accountability')->name('accountability.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEABisnisAccountabilityController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEABisnisAccountabilityController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEABisnisAccountabilityController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEABisnisAccountabilityController::class, 'delete'])->name('delete');
                });

                Route::prefix('produk')->name('produk.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEABisnisProdukController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEABisnisProdukController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEABisnisProdukController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEABisnisProdukController::class, 'delete'])->name('delete');
                });

                Route::prefix('constrain')->name('constrain.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEABisnisConstrainController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEABisnisConstrainController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEABisnisConstrainController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEABisnisConstrainController::class, 'delete'])->name('delete');
                });

                Route::prefix('risk')->name('risk.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEABisnisRiskController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEABisnisRiskController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEABisnisRiskController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEABisnisRiskController::class, 'delete'])->name('delete');
                });
            });

            Route::prefix('informasi')->name('informasi.')->group(function () {
                    Route::get('/show/{id}', [StakeholderPTSEAInformasiController::class, 'show'])->name('show');
                    Route::post('/save', [StakeholderPTSEAInformasiController::class, 'save'])->name('save');
                    Route::post('/update', [StakeholderPTSEAInformasiController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [StakeholderPTSEAInformasiController::class, 'delete'])->name('delete');
            });

            Route::prefix('aplikasi')->name('aplikasi.')->group(function () {
                Route::get('/show/{id}', [StakeholderPTSEAAplikasiController::class, 'show'])->name('show');
                Route::post('/save', [StakeholderPTSEAAplikasiController::class, 'save'])->name('save');
                Route::post('/update', [StakeholderPTSEAAplikasiController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [StakeholderPTSEAAplikasiController::class, 'delete'])->name('delete');
            });

            Route::prefix('teknologi')->name('teknologi.')->group(function () {
                Route::get('/show/{id}', [StakeholderPTSEATeknologiController::class, 'show'])->name('show');
                Route::post('/save', [StakeholderPTSEATeknologiController::class, 'save'])->name('save');
                Route::post('/update', [StakeholderPTSEATeknologiController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [StakeholderPTSEATeknologiController::class, 'delete'])->name('delete');
            });

            Route::prefix('keamanan')->name('keamanan.')->group(function () {
                Route::get('/show/{id}', [StakeholderPTSEAKeamananController::class, 'show'])->name('show');
                Route::post('/save', [StakeholderPTSEAKeamananController::class, 'save'])->name('save');
                Route::post('/update', [StakeholderPTSEAKeamananController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [StakeholderPTSEAKeamananController::class, 'delete'])->name('delete');
            });
            
        });

        Route::prefix('progress')->name('progress.')->group(function () {
            Route::get('/load', [StakeholderPTSProgressMonitoringController::class, 'load'])->name('load');
            Route::post('/load_pts', [StakeholderPTSProgressMonitoringController::class, 'load_pts'])->name('load_pts');
            Route::get('/index/{id}', [StakeholderPTSProgressMonitoringController::class, 'index'])->name('index');
        });
    });

    // Yayasan only
    Route::middleware(['role:3'])->prefix('yayasan')->name('yayasan.')->group(function () {
        Route::get('/dashboard', [YayasanDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/load', [YayasanProgressMonitoringController::class, 'load'])->name('load');
        Route::post('/load_pts', [YayasanProgressMonitoringController::class, 'load_pts'])->name('load_pts');
        Route::get('/index/{id}', [YayasanProgressMonitoringController::class, 'index'])->name('index');
        Route::prefix('vision')->name('vision.')->group(function () {
            Route::prefix('visimisi')->name('visimisi.')->group(function () {
                Route::get('/show/{id}', [YayasanVisionVisiMisiController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanVisionVisiMisiController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('principle')->name('principle.')->group(function () {
                Route::get('/show/{id}', [YayasanVisionPrincipleController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanVisionPrincipleController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('bisnis')->name('bisnis.')->group(function () {
                Route::get('/show/{id}', [YayasanVisionBisnisController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanVisionBisnisController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('objective_driver')->name('objective_driver.')->group(function () {
                Route::get('/show/{id}', [YayasanVisionObjectiveDriverController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanVisionObjectiveDriverController::class, 'save_comment'])->name('save_comment');
            });
        });

        Route::prefix('bisnis')->name('bisnis.')->group(function () {
            Route::prefix('digital_organisasi')->name('digital_organisasi.')->group(function () {
                Route::get('/show/{id}', [YayasanBisnisDigitalOrganisasiController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanBisnisDigitalOrganisasiController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('bisnis_inovasi')->name('bisnis_inovasi.')->group(function () {
                Route::get('/show/{id}', [YayasanBisnisBisnisInovasiController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanBisnisBisnisInovasiController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('accountability')->name('accountability.')->group(function () {
                Route::get('/show/{id}', [YayasanBisnisAccountabilityController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanBisnisAccountabilityController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('produk')->name('produk.')->group(function () {
                Route::get('/show/{id}', [YayasanBisnisProdukController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanBisnisProdukController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('constrain')->name('constrain.')->group(function () {
                Route::get('/show/{id}', [YayasanBisnisConstrainController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanBisnisConstrainController::class, 'save_comment'])->name('save_comment');
            });
            Route::prefix('risk')->name('risk.')->group(function () {
                Route::get('/show/{id}', [YayasanBisnisRiskController::class, 'show'])->name('show');
                Route::post('/save_comment', [YayasanBisnisRiskController::class, 'save_comment'])->name('save_comment');
            });
        });

        Route::prefix('informasi')->name('informasi.')->group(function () {
            Route::get('/show/{id}', [YayasanInformasiController::class, 'show'])->name('show');
            Route::post('/save_comment', [YayasanInformasiController::class, 'save_comment'])->name('save_comment');
        });

        Route::prefix('aplikasi')->name('aplikasi.')->group(function () {
            Route::get('/show/{id}', [YayasanAplikasiController::class, 'show'])->name('show');
            Route::post('/save_comment', [YayasanAplikasiController::class, 'save_comment'])->name('save_comment');
        });

        Route::prefix('teknologi')->name('teknologi.')->group(function () {
            Route::get('/show/{id}', [YayasanTeknologiController::class, 'show'])->name('show');
            Route::post('/save_comment', [YayasanTeknologiController::class, 'save_comment'])->name('save_comment');
        });

        Route::prefix('keamanan')->name('keamanan.')->group(function () {
            Route::get('/show/{id}', [YayasanKeamananController::class, 'show'])->name('show');
            Route::post('/save_comment', [YayasanKeamananController::class, 'save_comment'])->name('save_comment');
        });

    });

});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

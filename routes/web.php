<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/pengajuan-surat/create', [PengajuanSuratController::class, 'create'])->name('pengajuan-surat.create');
    Route::post('/pengajuan-surat', [PengajuanSuratController::class, 'store'])->name('pengajuan-surat.store');
    Route::delete('/pengajuan-surat/{pengajuanSurat}', [PengajuanSuratController::class, 'destroy'])->name('pengajuan-surat.destroy');

    Route::middleware('can:admin')->group(function () {
        Route::get('/pengajuan-surat', [PengajuanSuratController::class, 'index'])->name('pengajuan-surat.index');
        Route::get('/pengajuan-surat/riwayat', [PengajuanSuratController::class, 'riwayat'])->name('pengajuan-surat.riwayat');

        Route::prefix('pengajuan-surat')
            ->name('pengajuan-surat.')
            ->group(function () {

            /*
        |--------------------------------------------------------------------------
        | Surat Diajukan
        |--------------------------------------------------------------------------
        */


            /*
        |--------------------------------------------------------------------------
        | Detail Pengajuan (AJAX)
        |--------------------------------------------------------------------------
        */
            Route::get('/{pengajuanSurat}/show', [PengajuanSuratController::class, 'show'])
                ->name('show');

            /*
        |--------------------------------------------------------------------------
        | Verifikasi / Tolak / Selesai
        |--------------------------------------------------------------------------
        */
            Route::put('/{pengajuanSurat}/tolak', [PengajuanSuratController::class, 'tolak'])
                ->name('tolak');

            Route::put('/{pengajuanSurat}/selesaikan', [PengajuanSuratController::class, 'selesaikan'])
                ->name('selesaikan');
            
            Route::get('/riwayat', [PengajuanSuratController::class, 'riwayat'])
                ->name('riwayat');
        });
    });

    /* Route Penduduk */
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
    Route::get('/penduduk/edit/{id}', [PendudukController::class, 'edit'])->name('penduduk.edit');
    Route::put('/penduduk/{penduduk}', [PendudukController::class, 'update'])->name('penduduk.update');
    Route::delete('/penduduk/{penduduk}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');

    /* Route Profile */
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profile', [HomeController::class, 'update'])->name('profile.update');


    Route::prefix('masyarakat')
        ->name('masyarakat.')
        ->group(function () {

            Route::get('/pengajuan-surat', [PengajuanSuratController::class, 'indexMasyarakat'])
                ->name('pengajuan-surat.index');

            Route::get('/riwayat-pengajuan', [PengajuanSuratController::class, 'riwayatMasyarakat'])
                ->name('riwayat-pengajuan');

            Route::get('/riwayat-pengajuan/{pengajuanSurat}/show', [PengajuanSuratController::class, 'showMasyarakat'])
                ->name('show');
        });

    Route::get('create/berita', [BeritaController::class, 'create'])
        ->name('news.create');
    Route::resource('berita', BeritaController::class);

    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])
        ->name('berita.edit');
    Route::resource('berita', BeritaController::class)
        ->parameters([
            'berita' => 'berita'
        ]);

    Route::resource('jenis-surat', \App\Http\Controllers\JenisSuratController::class)->except(['create', 'store', 'destroy']);
    Route::get('/jenis-surat/{id}/detail', [\App\Http\Controllers\JenisSuratController::class, 'getDetail']);
});

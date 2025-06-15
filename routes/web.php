<?php

use App\Http\Controllers\CekResiController;
use App\Http\Controllers\KepalaPerwakilanController;
use App\Http\Controllers\MobileServiceController;
use App\Http\Controllers\PjPelayananController;
use App\Http\Controllers\SocController;
use App\Http\Controllers\KeuanganUmumController;
use App\Http\Controllers\PembayaranKlaimController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


use Illuminate\Support\Facades\Artisan;

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
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    // Artisan::call('cache:clear');
    // Artisan::call('route:clear');
    
    return "Cache cleared successfully";
 });
Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::get('/dashboard/risk-chart-data', [HomeController::class, 'getRiskChartData'])->name('dashboard.risk-chart-data');
Route::get('/dashboard/top-risk-photos', [HomeController::class, 'getTopRiskPhotos'])->name('dashboard.top-risk-photos');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    
    Route::resource('soc', SocController::class);
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/photos/upload', [PhotoController::class, 'upload'])->name('photos.upload');
        Route::post('/photos/delete', [PhotoController::class, 'destroy'])->name('photos.delete');

    });
    Route::put('/user/update/profile/{user}', [UserController::class, 'editProfile'])->name('update.profile');
    Route::get('user/profile/{user}', [UserController::class, 'show'])->name('user.profile');

});



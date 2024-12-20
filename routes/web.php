<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    // echo "www";die;
    //  return redirect('/admin');
});

Route::group(['middleware' => ['guest']], function () {
   // Auth::routes();
    
});
Route::get('/clear-cache', function() {
    Artisan::call('optimize:clear');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
});

Route::group(['middleware'=>['auth']],function(){
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

 Route::get('/test-cron', [App\Http\Controllers\CronController::class, 'index'])->name('testCron');

Route::get('fcm',function(){
    return view('firebase');
});

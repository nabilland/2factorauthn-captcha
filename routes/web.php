<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('dashboard');
});

Route::get('/index', function () {
    return view('main.index');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();
Route::middleware(['2fa'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/2fa', function(){
        return redirect(route('home'));
    })->name('2fa');
});

Route::get('/complete-registration', [RegisterController::class, 'completeRegistration'])->name('complete-registration');

Route::get('/contact-form', [CaptchaServiceController::class, 'index']);
Route::post('/captcha-validation', [CaptchaServiceController::class, 'capthcaFormValidate']);
Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);
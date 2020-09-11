<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class,'index'])->name('home');

Route::get('/2fa',[\App\Http\Controllers\PasswordSecurityController::class,'index'])->name('2fa');
Route::post('/2fagenerate',[\App\Http\Controllers\PasswordSecurityController::class,'generate'])->name('2fa_generate');
Route::post('/2faverify',[\App\Http\Controllers\PasswordSecurityController::class,'enable2fa'])->name('2fa_verify');
Route::post('/2fadisable',[\App\Http\Controllers\PasswordSecurityController::class,'disable2fa'])->name('2fa_disable');
Route::post('/verify2fa', function() {
    return view('home');
})->name('verify2fa')->middleware('2fa');


Route::get('/verify2fa', function() {
    return redirect(URL()->previous());
})->name('verify2fa')->middleware('2fa');

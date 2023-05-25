<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ContactUsController;

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
Route::get('/', [Controller::class,'home'])->name('home');
Route::get('/optimize',[Controller::class,'optimize']);
Route::post('/contactus',[ContactUsController::class,'store'])->name('contactus.store');

////////////////////////////// Admin Routes //////////////////////////
Route::get('/admin/login',[AdminAuth::class,'login'])->name('admin.login')->middleware('isLogin');
Route::post('/admin/login',[AdminAuth::class,'dologin'])->name('admin.dologin')->middleware('isLogin');
Route::get('/admin/forgot/password',[AdminAuth::class,'forgetPassword'])->name('admin.forgotPassword')->middleware('isLogin');
Route::post('/admin/forgot/password',[AdminAuth::class,'resetPassword'])->name('admin.resetPassword')->middleware('isLogin');
Route::get('/admin/reset/password/{token}',[AdminAuth::class,'resetPasswordWithToken'])->name('admin.resetPasswordToken')->middleware('isLogin');
Route::post('/admin/update/{token}',[AdminAuth::class,'updatePassword'])->name('admin.updatePassword')->middleware('isLogin');
///////////////////////////////////////////////////////////
Route::group(['middleware'=>'admin','prefix'=>'/admin/dashboard'],function (){
    /// First admin word means middleware class and second admin word means guard type
    Route::view('/', 'admin.dashboard')->name('admin.home');

    Route::post('/logout',[AdminAuth::class,'logout'])->name('logout');
    Route::get('/setting',[AdminAuth::class,'setting'])->name('setting');
    Route::post('/setting/email',[AdminAuth::class,'setting_email'])->name('setting_email');
    Route::post('/setting/password',[AdminAuth::class,'setting_password'])->name('setting_password');
    Route::resource('contactus', ContactUsController::class)->except('store');
});


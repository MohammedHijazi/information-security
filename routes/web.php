<?php

use App\Http\Controllers\Admin\AdminAuth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserAuth;
use App\Http\Controllers\User\DocumentController;
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
Route::get('/', [Controller::class,'home'])->name('home');
Route::get('/optimize',[Controller::class,'optimize']);

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
    Route::resource('administrator',AdminController::class);
    Route::resource('user',UserController::class);
    Route::post('/logout',[AdminAuth::class,'logout'])->name('logout');
    Route::get('/setting',[AdminAuth::class,'setting'])->name('setting');
    Route::post('/setting/email',[AdminAuth::class,'setting_email'])->name('setting_email');
    Route::post('/setting/password',[AdminAuth::class,'setting_password'])->name('setting_password');
});

////////////////////////////// User Routes //////////////////////////
Route::get('/',[UserAuth::class,'login'])->name('user.login')->middleware('isLogin');
Route::post('/user/login',[UserAuth::class,'dologin'])->name('user.dologin')->middleware('isLogin');
Route::get('/user/forgot/password',[UserAuth::class,'forgetPassword'])->name('user.forgotPassword')->middleware('isLogin');
Route::post('/user/forgot/password',[UserAuth::class,'resetPassword'])->name('user.resetPassword')->middleware('isLogin');
Route::get('/user/reset/password/{token}',[UserAuth::class,'resetPasswordWithToken'])->name('user.resetPasswordToken')->middleware('isLogin');
Route::post('/user/update/{token}',[UserAuth::class,'updatePassword'])->name('user.updatePassword')->middleware('isLogin');
///////////////////////////////////////////////////////////
Route::group(['middleware'=>'user','prefix'=>'/user/dashboard'],function (){
    /// First user word means middleware class and second user word means guard type
    Route::get('/', [DocumentController::class,'index'])->name('user.home');
    Route::get('/document/permission/{document_id}', [DocumentController::class,'permission_form'])->name('document.permission');
    Route::post('/document/permission/{document_id}', [DocumentController::class,'permission_post'])->name('document.permission_post');
    Route::resource('document', DocumentController::class);

    Route::post('/logout',[UserAuth::class,'logout'])->name('logout');
    Route::get('/setting',[UserAuth::class,'setting'])->name('setting');
    Route::post('/setting/email',[UserAuth::class,'setting_email'])->name('setting_email');
    Route::post('/setting/password',[UserAuth::class,'setting_password'])->name('setting_password');
});





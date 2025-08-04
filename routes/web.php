<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetaiController;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\GiaodienQLController;
use App\Http\Controllers\GiaodienNguoiDungController;
use App\Http\Controllers\SanphamnghiencuuController;
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
/*
| Đăng nhập, đăng xuất---------------------------------
*/

Route::post('/loginuser', [DangNhapController::class, 'loginNguoidung']);
/*
| Giao diện---------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('/trangdangnhap', [GiaodienNguoiDungController::class, 'TrangDangnhap']);
// giao diện admin
Route::get('/admin/trangquanly', [GiaodienQLController::class, 'dashboardAdmin']);
// giao diện quản lý hệ thống
Route::get('/quanlyhethong/trangquanly', [GiaodienQLController::class, 'dashboardQL']);
// giao diện quản lý sản phẩm nghiên cứu
Route::get('/sanphamnghiencuu', [SanphamnghiencuuController::class, 'index']);

//Đề tài
route::post('/pdangkydetai', [DetaiController::class, 'DangkyDetai']);

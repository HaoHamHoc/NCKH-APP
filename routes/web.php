<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetaiController;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\GiaodienQLController;
use App\Http\Controllers\GiaodienNguoiDungController;
use App\Http\Controllers\SanphamnghiencuuController;
use App\Http\Controllers\QuanlyTaiKhoanController;
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

Route::post('/loginuser', [DangNhapController::class, 'loginNguoidung'])->name('login');;
Route::post('/logoutuser', [DangNhapController::class, 'Dangxuat'])->name('logout');;
/*
| Giao diện view---------------------------------------------
*/
Route::get('/', [GiaodienNguoiDungController::class, 'TrangDangnhap']);
Route::get('/trangdangnhap', [GiaodienNguoiDungController::class, 'TrangDangnhap']);
Route::middleware(['checknguoidung'])->group(function () {
    Route::get('/detainckh/detaicuatoi', [GiaodienNguoiDungController::class, 'TrangDeTaiCaNhan']);
    Route::get('/quanlydetai', [GiaodienNguoiDungController::class, 'TrangQLdetai']);
    Route::get('/thongtincanhan', [GiaodienNguoiDungController::class, 'TrangCaNhan']);
    Route::get('/detainckh/dangkydetai', [GiaodienNguoiDungController::class, 'TrangDangKyDetai']);
    Route::get('/detainckh', [GiaodienNguoiDungController::class, 'TrangTimKiemDetai']);
});
/*
| Tìm kiếm---------------------------------------------
*/
Route::get('/detai/{idloai}', [GiaodienNguoiDungController::class, 'timkiemtheoloai']);


// giao diện admin
Route::get('/admin/trangquanly', [GiaodienQLController::class, 'dashboardAdmin']);
// giao diện quản lý hệ thống
Route::get('/quanlyhethong/trangquanly', [GiaodienQLController::class, 'dashboardQL']);
// giao diện quản lý sản phẩm nghiên cứu
Route::get('/quanlyhethong/sanphamnghiencuu', [SanphamnghiencuuController::class, 'index']);
// giao diện quản lý sản phẩm nghiên cứu
Route::get('/quanlyhethong/taikhoan', [QuanlyTaiKhoanController::class, 'Danhsachtaikhoan']);
Route::post('/quanlyhethong/taikhoan/update', [QuanlyTaiKhoanController::class, 'update'])->name('updateTaiKhoan');
Route::post('/quanlyhethong/taikhoan/delete', [QuanlyTaiKhoanController::class, 'delete'])->name('deleteTaiKhoan');

/*
| Backend route post---------------------------------------------
*/
//Đề tài
Route::middleware(['checknguoidung'])->group(function () {
    route::post('/detai/dangkydetai', [DetaiController::class, 'DangkyDetai'])->name('detai.dangkydetai');
    route::post('/tiendo/{id}/themkinhphi', [DetaiController::class, 'ThemKinhPhi'])->name('detai.ThemKinhPhi');
    route::delete('/detai/{id_detai}/tiendo/{id_tiendo}/kinhphi/{id_kinhphi}', [DetaiController::class, 'xoaKinhPhi'])->name('detai.xoaKinhPhi');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetaiController;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\GiaodienQLController;
use App\Http\Controllers\GiaodienNguoiDungController;
use App\Http\Controllers\SanphamnghiencuuController;
use App\Http\Controllers\QuanlyTaiKhoanController;
use App\Http\Controllers\QuanlyLoaiDeTaiController;
use App\Http\Controllers\QuanlySogiotheonamController;
use App\Http\Controllers\QuanlyLinhVucNghienCuu;
use App\Http\Controllers\QuanlyLoaiSanPhamNghienCuuController;
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
// giao diện quản lý tài khoản
Route::get('/quanlyhethong/taikhoan', [QuanlyTaiKhoanController::class, 'Danhsachtaikhoan']);
Route::post('/quanlyhethong/taikhoan/update', [QuanlyTaiKhoanController::class, 'update'])->name('updateTaiKhoan');
Route::post('/quanlyhethong/taikhoan/delete', [QuanlyTaiKhoanController::class, 'delete'])->name('deleteTaiKhoan');
Route::post('/quanlyhethong/taikhoan/add', [QuanlyTaiKhoanController::class, 'create'])->name('addTaiKhoan');
// Quản lý loại đề tài
Route::get('/quanlyhethong/loaidetai', [QuanlyLoaiDeTaiController::class, 'index'])->name('quanlyLoaiDeTai');
Route::post('/quanlyhethong/loaidetai/update', [QuanlyLoaiDeTaiController::class, 'update'])->name('updateLoaiDeTai');
Route::post('/quanlyhethong/loaidetai/delete', [QuanlyLoaiDeTaiController::class, 'delete'])->name('deleteLoaiDeTai');
Route::post('/quanlyhethong/loaidetai/add', [QuanlyLoaiDeTaiController::class, 'store'])->name('addLoaiDeTai');

Route::get('/quanlyhethong/sogiotheonam', [QuanlySogiotheonamController::class, 'index'])->name('quanlySogiotheonam');
Route::post('/quanlyhethong/sogiotheonam/update', [QuanlySogiotheonamController::class, 'update'])->name('updateSogiotheonam');
Route::post('/quanlyhethong/sogiotheonam/delete', [QuanlySogiotheonamController::class, 'delete'])->name('deleteSogiotheonam');
Route::post('/quanlyhethong/sogiotheonam/add', [QuanlySogiotheonamController::class, 'store'])->name('addSogiotheonam');

//Quản lý lĩnh vực nghiên cứu
Route::get('/quanlyhethong/linhvucnghiencuu', [QuanlyLinhVucNghienCuu::class, 'index'])->name('quanlyLinhVucNghienCuu');
Route::post('/quanlyhethong/linhvucnghiencuu/update', [QuanlyLinhVucNghienCuu::class, 'update'])->name('updateLinhVucNghienCuu');
Route::post('/quanlyhethong/linhvucnghiencuu/delete', [QuanlyLinhVucNghienCuu::class, 'delete'])->name('deleteLinhVucNghienCuu');
Route::post('/quanlyhethong/linhvucnghiencuu/add', [QuanlyLinhVucNghienCuu::class, 'store'])->name('addLinhVucNghienCuu');

//Quản lý loại sản phẩm nghiên cứu
Route::get('/quanlyhethong/loaisanphamnghiencuu', [QuanlyLoaiSanPhamNghienCuuController::class, 'index'])->name('quanlyLoaiSanPhamNghienCuu');
Route::post('/quanlyhethong/loaisanphamnghiencuu/update', [QuanlyLoaiSanPhamNghienCuuController::class, 'update'])->name('updateLoaiSanPhamNghienCuu');
Route::post('/quanlyhethong/loaisanphamnghiencuu/delete', [QuanlyLoaiSanPhamNghienCuuController::class, 'delete'])->name('deleteLoaiSanPhamNghienCuu');
Route::post('/quanlyhethong/loaisanphamnghiencuu/add', [QuanlyLoaiSanPhamNghienCuuController::class, 'store'])->name('addLoaiSanPhamNghienCuu');

//Đề tài
Route::middleware(['checknguoidung'])->group(function () {
    route::post('/detai/dangkydetai', [DetaiController::class, 'DangkyDetai'])->name('detai.dangkydetai');
    route::post('/tiendo/{id}/themkinhphi', [DetaiController::class, 'ThemKinhPhi'])->name('detai.ThemKinhPhi');
    route::delete('/detai/{id_detai}/tiendo/{id_tiendo}/kinhphi/{id_kinhphi}', [DetaiController::class, 'xoaKinhPhi'])->name('detai.xoaKinhPhi');
});

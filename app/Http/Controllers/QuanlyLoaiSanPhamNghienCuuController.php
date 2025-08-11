<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaispnghiencuuModel;

class QuanlyLoaiSanPhamNghienCuuController extends Controller
{
    /**
     * Hiển thị danh sách loại sản phẩm nghiên cứu
     */
    public function index(Request $request)
    {
        $layout = $request->query('layout', 'table');
        $columns = [
            ['key' => 'tenloaispnc', 'label' => 'Tên loại sản phẩm nghiên cứu', 'type' => 'text'],
        ];
        
        $items = LoaispnghiencuuModel::all()->toArray();

        $type = 'Quản lý loại sản phẩm nghiên cứu';
        $updateRoute = 'updateLoaiSanPhamNghienCuu';
        $deleteRoute = 'deleteLoaiSanPhamNghienCuu';
        $addRoute = 'addLoaiSanPhamNghienCuu';
        $primaryKey = 'id_loai';
        $allowAdd = true;
        
        return view('managerPage.index', compact(
            'items', 
            'primaryKey', 
            'columns', 
            'type', 
            'layout', 
            'updateRoute', 
            'deleteRoute', 
            'addRoute', 
            'allowAdd'
        ));
    }

    /**
     * Thêm mới loại sản phẩm nghiên cứu
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenloaispnc' => 'required|string|max:255|unique:loaispnghiencuu,tenloaispnc',
        ]);

        LoaispnghiencuuModel::create([
            'tenloaispnc' => $request->input('tenloaispnc'),
        ]);

        return back()->with('success', 'Thêm mới loại sản phẩm nghiên cứu thành công!');
    }

    /**
     * Cập nhật loại sản phẩm nghiên cứu
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $request->validate([
            'tenloaispnc' => 'required|string|max:255|unique:loaispnghiencuu,tenloaispnc,' . $id . ',id_loai',
        ]);

        $loaispnc = LoaispnghiencuuModel::findOrFail($id);
        $loaispnc->update([
            'tenloaispnc' => $request->input('tenloaispnc'),
        ]);

        return back()->with('success', 'Cập nhật loại sản phẩm nghiên cứu thành công!');
    }

    /**
     * Xóa loại sản phẩm nghiên cứu
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        
        // Kiểm tra xem có sản phẩm nào đang sử dụng loại này không
        $loaispnc = LoaispnghiencuuModel::findOrFail($id);
        
        // Kiểm tra ràng buộc trước khi xóa
        if ($loaispnc->Sanpham()->count() > 0) {
            return back()->with('error', 'Không thể xóa loại sản phẩm này vì đang có sản phẩm sử dụng!');
        }
        
        $loaispnc->delete();
        
        return back()->with('success', 'Xóa loại sản phẩm nghiên cứu thành công!');
    }
} 
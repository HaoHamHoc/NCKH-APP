<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinhvucnghiencuuModel;

class QuanlyLinhVucNghienCuuController extends Controller
{
    /**
     * Hiển thị danh sách lĩnh vực nghiên cứu
     */
    public function index(Request $request)
    {
        $layout = $request->query('layout', 'table');
        $columns = [
            ['key' => 'tenlvnc', 'label' => 'Tên lĩnh vực nghiên cứu', 'type' => 'text'],
        ];
        
        $items = LinhvucnghiencuuModel::all()->toArray();

        $type = 'Quản lý lĩnh vực nghiên cứu';
        $updateRoute = 'updateLinhVucNghienCuu';
        $deleteRoute = 'deleteLinhVucNghienCuu';
        $addRoute = 'addLinhVucNghienCuu';
        $primaryKey = 'id_lvnc';
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
     * Thêm mới lĩnh vực nghiên cứu
     */
    public function store(Request $request)
    {
        $request->validate([
            'tenlvnc' => 'required|string|max:255|unique:linhvucnghiencuu,tenlvnc',
        ]);

        LinhvucnghiencuuModel::create([
            'tenlvnc' => $request->input('tenlvnc'),
        ]);

        return back()->with('success', 'Thêm mới lĩnh vực nghiên cứu thành công!');
    }

    /**
     * Cập nhật lĩnh vực nghiên cứu
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $request->validate([
            'tenlvnc' => 'required|string|max:255|unique:linhvucnghiencuu,tenlvnc,' . $id . ',id_lvnc',
        ]);

        $linhvuc = LinhvucnghiencuuModel::findOrFail($id);
        $linhvuc->update([
            'tenlvnc' => $request->input('tenlvnc'),
        ]);

        return back()->with('success', 'Cập nhật lĩnh vực nghiên cứu thành công!');
    }

    /**
     * Xóa lĩnh vực nghiên cứu
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        
        // Kiểm tra xem có đề tài nào đang sử dụng lĩnh vực này không
        $linhvuc = LinhvucnghiencuuModel::findOrFail($id);
        
        // TODO: Thêm logic kiểm tra ràng buộc trước khi xóa
        // if ($linhvuc->detai()->count() > 0) {
        //     return back()->with('error', 'Không thể xóa lĩnh vực này vì đang có đề tài sử dụng!');
        // }
        
        $linhvuc->delete();
        
        return back()->with('success', 'Xóa lĩnh vực nghiên cứu thành công!');
    }
}

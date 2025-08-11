<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SogiotheonamModel;

class QuanlySogiotheonamController extends Controller {
    // Hiển thị danh sách số giờ theo năm
    public function index(Request $request)
    {
        $layout = $request->query('layout', 'table');
        $columns = [
            ['key' => 'tenloaidetai', 'label' => 'Tên loại đề tài', 'type' => 'text'],
            ['key' => 'sogioTGtoida', 'label' => 'Số giờ tác giả tối đa', 'type' => 'number'],
            ['key' => 'sogioTVtoida', 'label' => 'Số giờ thành viên tối đa', 'type' => 'number'],
            ['key' => 'soTVtoida', 'label' => 'Số thành viên tối đa', 'type' => 'number'],
            ['key' => 'nam', 'label' => 'Năm', 'type' => 'number'],
        ];
        $items = SogiotheonamModel::with('loaidetai')->get()->map(function($item) {
            return [
                'tenloaidetai' => $item->loaidetai->tenloaidetai ?? '',
                'sogioTGtoida' => $item->sogioTGtoida,
                'sogioTVtoida' => $item->sogioTVtoida,
                'soTVtoida' => $item->soTVtoida,
                'nam' => $item->nam,
            ];
        })->toArray();
        $type = 'Quản lý số giờ theo năm';
        $updateRoute = '';
        $deleteRoute = '';
        $addRoute = ''; // Đổi thành tên route tương ứng nếu có
        $allowAdd = false; // Đổi thành true nếu muốn cho phép thêm mới
        return view('managerPage.index', compact('items', 'columns', 'type', 'layout', 'updateRoute', 'deleteRoute', 'addRoute', 'allowAdd'));
    }

    // Sửa số giờ theo năm
    public function update(Request $request)
    {
        // ...
    }

    // Thêm mới số giờ theo năm
    public function store(Request $request)
    {
        // ...
    }

    // Xóa số giờ theo năm
    public function delete(Request $request)
    {
        // ...
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaidetaiModel;
use App\Models\SogiotheonamModel;

class QuanlyLoaiDeTaiController extends Controller {
    // Hiển thị danh sách loại đề tài
    public function index(Request $request)
    {
        $layout = $request->query('layout', 'table');
        $columns = [
            ['key' => 'tenloaidetai', 'label' => 'Tên loại đề tài', 'type' => 'text'],
            ['key' => 'sogioTGtoida', 'label' => 'Số giờ tác giả tối đa', 'type' => 'number'],
            ['key' => 'sogioTVtoida', 'label' => 'Số giờ thành viên tối đa', 'type' => 'number'],
            ['key' => 'soTVtoida', 'label' => 'Số thành viên tối đa', 'type' => 'number'],
            ['key' => 'ghichu', 'label' => 'Ghi chú', 'type' => 'longtext'],
        ];
        $items = LoaidetaiModel::all()->toArray();

        $type = 'Quản lý số giờ theo năm';
        $updateRoute = 'updateLoaiDeTai';
        $deleteRoute = '';
        $addRoute = 'addLoaiDeTai'; // Đổi thành tên route tương ứng nếu có
        $allowAdd = true; 
        $primaryKey = 'id_loaidt'; // Khóa chính của bảng loại đề tài
        return view('managerPage.index', compact('items', 'primaryKey', 'columns', 'type', 'layout', 'updateRoute', 'deleteRoute', 'addRoute', 'allowAdd'));
    }

    // Sửa loại đề tài
    public function update(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'tenloaidetai',
            'sogioTGtoida',
            'sogioTVtoida',
            'soTVtoida',
            'ghichu',
        ]);

        $loaidetai = LoaidetaiModel::findOrFail($id);
        $loaidetai->update($data);

        return back()->with('success', 'Cập nhật loại đề tài thành công!');
    }

    // Thêm mới loại đề tài
    public function store(Request $request)
    {
        $data = $request->only([
            'tenloaidetai',
            'sogioTGtoida',
            'sogioTVtoida',
            'soTVtoida',
            'ghichu',
        ]);
        $data['nam'] = date('Y');

        $isExistsLDT = LoaidetaiModel::where('tenloaidetai', $data['tenloaidetai'])
            ->where('nam', $data['nam'])
            ->first();

        if ($isExistsLDT) {
            // Nếu đã tồn tại, cập nhật lại bản ghi
            $isExistsLDT->update($data);
            $loaidt = $isExistsLDT;
        } else {
            // Nếu chưa tồn tại, thêm mới
            $loaidt = LoaidetaiModel::create($data);
        }

        // Thêm bản ghi vào sogiotheonam
        SogiotheonamModel::create([
            'id_loaidt' => $loaidt->id_loaidt,
            'sogioTGtoida' => $loaidt->sogioTGtoida ?? 0,
            'sogioTVtoida' => $loaidt->sogioTVtoida ?? 0,
            'soTVtoida' => $loaidt->soTVtoida ?? 0,
            'nam' => date('Y'),
        ]);

        return back()->with('success', 'Thêm mới thành công!');
    }

    // Xóa loại đề tài
    public function delete(Request $request)
    {
    //     $id = $request->input('id');
    //     LoaidetaiModel::destroy($id);
    //     return back()->with('success', 'Đã xóa thành công!');
    }
}

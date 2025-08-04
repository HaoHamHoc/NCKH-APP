<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SanphamnghiencuuController extends Controller
{
    // Hiển thị danh sách sản phẩm nghiên cứu
    public function index()
    {
        return view('sanphamnghiencuu');
    }

    // Hiển thị form tạo mới sản phẩm nghiên cứu
    public function create()
    {
        // ...
    }

    // Lưu sản phẩm nghiên cứu mới
    public function store(Request $request)
    {
        // ...
    }

    // Hiển thị chi tiết một sản phẩm nghiên cứu
    public function show($id)
    {
        // ...
    }

    // Hiển thị form chỉnh sửa sản phẩm nghiên cứu
    public function edit($id)
    {
        // ...
    }

    // Cập nhật sản phẩm nghiên cứu
    public function update(Request $request, $id)
    {
        // ...
    }

    // Xóa sản phẩm nghiên cứu
    public function destroy($id)
    {
        // ...
    }
}

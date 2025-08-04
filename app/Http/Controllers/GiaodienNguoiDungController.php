<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaidetaiModel;
use App\Models\LinhvucnghiencuuModel;
use App\Models\KinhphiModel;
use App\Models\DetaiModel;
use App\Models\TiendoModel;
use App\Models\ThongtincanhanModel;
use App\Models\ThanhvienModel;
use Illuminate\Support\Facades\Log;

class GiaodienNguoiDungController extends Controller
{
    //Đăng nhập 
    public function TrangDangnhap()
    {
        return view('login');
    }
    //Giao diện cá nhân 
    public function TrangDangKyDetai()
    {
        $loaiDeTai = LoaidetaiModel::all();
        $linhVuc = LinhvucnghiencuuModel::all();
        // Trả về view đăng ký đề tài với dữ liệu loại đề tài và lĩnh vực nghiên cứu
        return view('pages.dangkydetai', compact('loaiDeTai', 'linhVuc'));
    }
    public function TrangTimKiemDetai()
    {
        return view('pages.trangchu');
    }
    public function TrangCaNhan()
    {
        return view('pages.trangcanhan');
    }
    public function TrangDeTaiCaNhan(Request $request)
    {
        $id_ttcn = ThongtincanhanModel::where('user_id', $request->id_nguoidung)->first();
        if (!$id_ttcn) {
            Log::warning('truy cập gián đoạn', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'agent' => $request->userAgent()
            ]);
            return redirect()->back()->with('error', 'Thông tin cá nhân không tồn tại.');
        };
        // Trả về view với thông tin cá nhân
        $dsDetai = DetaiModel::where('id_ttcn', $id_ttcn->id_ttcn)->where('trangthai', 'Đã duyệt')
            ->first();
        if ($dsDetai == null) {
            $dieukien = false;
            return view('pages.detaicanhan', compact('dieukien'));
        } else {
            $dieukien = true;
            $id_detai = $dsDetai->id_detai;
            $tiendo = TiendoModel::with(['Kinhphi', 'Detai'])
                ->where('id_detai', $id_detai)
                ->get();
            $thanhviens = ThanhvienModel::with('ThanhvienDT')
                ->where('id_detai', $id_detai)
                ->get();
            return view('pages.detaicanhan', compact('dsDetai', 'tiendo', 'thanhviens', 'dieukien'));
        }
    }
}

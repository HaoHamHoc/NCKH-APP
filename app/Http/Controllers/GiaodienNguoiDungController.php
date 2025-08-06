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
    public function TrangQLdetai()
    {
        $user = auth()->user();
        $ttcn = ThongtincanhanModel::where('user_id', $user->id)->first();

        // Đề tài trạng thái "Chờ duyệt" hoặc "Đã nghiệm thu" mà user là chủ nhiệm
        $detai_choduyet = DetaiModel::where('id_ttcn', $ttcn->id_ttcn)
            ->whereIn('trangthai', ['Chờ duyệt', 'Không duyệt'])
            ->get();
        $detai_nghiemthu = DetaiModel::where('id_ttcn', $ttcn->id_ttcn)
            ->where('trangthai', 'Đã nghiệm thu')
            ->get();

        // Đề tài mà user là thành viên
        $detai_thanhvien = DetaiModel::whereIn(
            'id_detai',
            ThanhvienModel::where('id_ttcn', $ttcn->id_ttcn)->pluck('id_detai')
        )->get();

        return view('pages.quanlydetai', compact('detai_choduyet', 'detai_nghiemthu', 'detai_thanhvien'));
    }
    public function TrangTimKiemDetai()
    {
        $loaiDeTai = LoaidetaiModel::all();
        return view('pages.trangchu', compact('loaiDeTai'));
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
    public function timkiemtheoloai($idloai)
    {
        $loaiDeTai = LoaidetaiModel::all();
        $linhVuc = LinhvucnghiencuuModel::all();
        $dsDetai = DetaiModel::with(['Thanhvien', 'Linhvucnghiencuu', 'LoaiDT'])
            ->where('id_loaidt', $idloai)
            ->where('trangthai', 'Đã duyệt')
            ->paginate(10);
        if ($dsDetai->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Chưa có đề tài',
            ], 404);
        }
        return view('components.detai', compact('loaiDeTai', 'dsDetai'));
    }
}

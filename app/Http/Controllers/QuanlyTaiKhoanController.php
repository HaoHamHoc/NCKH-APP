<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ThongtincanhanModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class QuanlyTaiKhoanController extends Controller
{
    //
    public function Taotaikhoan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:7|confirmed',
            'permission' => 'required|in:user,admin,manager',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $user = User::create([
            'name'       => $request->input('name'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
            'permission' => $request->input('permission'),
        ]);

        return response()->json([
            'message' => 'Tài khoản đã được tạo thành công',
        ], 201);
    }

    public function Danhsachtaikhoan()
    {
        $taikhoans = User::leftJoin('thongtincanhan', 'users.id', '=', 'thongtincanhan.user_id')
            ->select('users.*', 'thongtincanhan.hovaten', 'thongtincanhan.dvcongtac')
            ->get();
        return view('qlDashbroard.qlTaikhoan', compact('taikhoans'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $request->validate([
            'email' => 'required|email',
            'permission' => 'required|in:user,manager,admin',
            'hovaten' => 'nullable|string|max:255',
            'dvcongtac' => 'nullable|string|max:255',
        ]);

        // Cập nhật bảng users
        $user = User::findOrFail($id);
        $user->email = $request->input('email');
        $user->permission = $request->input('permission');
        $user->save();

        // Cập nhật bảng thongtincanhan (nếu có)
        $ttcn = ThongtincanhanModel::where('user_id', $id)->first();
        if ($ttcn) {
            $ttcn->hovaten = $request->input('hovaten');
            $ttcn->dvcongtac = $request->input('dvcongtac');
            $ttcn->save();
        } else {
            // Nếu chưa có thì tạo mới
            ThongtincanhanModel::create([
                'user_id' => $id,
                'hovaten' => $request->input('hovaten'),
                'dvcongtac' => $request->input('dvcongtac'),
            ]);
        }

        return back()->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function delete(Request $request)
    {
        // $id = $request->input('id');

        // // Lấy thông tin cá nhân liên kết với user
        // $ttcn = ThongtincanhanModel::where('user_id', $id)->first();
        // if (!$ttcn) {
        //     return back()->with('error', 'Không tìm thấy thông tin cá nhân để xóa!');
        // }

        // // Xóa các bản ghi liên quan trong bảng detai (nếu có)
        // DB::table('detai')->where('id_ttcn', $ttcn->id_ttcn)->delete();

        // // Xóa thongtincanhan
        // $ttcn->delete();

        // // Xóa user
        // $user = User::findOrFail($id);
        // $user->delete();

        // return back()->with('success', 'Tài khoản đã được xóa thành công!');
    }
}

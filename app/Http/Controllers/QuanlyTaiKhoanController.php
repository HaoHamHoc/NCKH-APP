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

    public function Danhsachtaikhoan(Request $request)
    {
        $layout = $request->query('layout', 'table');
        $columns = [
            ['key' => 'hovaten', 'label' => 'Họ và tên', 'type' => 'text'],
            ['key' => 'email', 'label' => 'Email', 'type' => 'text'],
            ['key' => 'permission', 'label' => 'Quyền', 'type' => 'select', 'options' => ['user' => 'user', 'manager' => 'manager', 'admin' => 'admin']],
            ['key' => 'dvcongtac', 'label' => 'Đơn vị công tác', 'type' => 'text'],
        ];
        $items = User::leftJoin('thongtincanhan', 'users.id', '=', 'thongtincanhan.user_id')
            ->select('users.*', 'thongtincanhan.hovaten', 'thongtincanhan.dvcongtac')
            ->get()
            ->map(function($item) {
                return [
                    'user_id' => $item->id, 
                    'name' => $item->name,
                    'email' => $item->email,
                    'permission' => $item->permission,
                    'hovaten' => $item->hovaten,
                    'dvcongtac' => $item->dvcongtac,
                ];
            })->toArray();

        $type = 'Quản lý tài khoản';
        $updateRoute = 'updateTaiKhoan';
        $deleteRoute = 'deleteTaiKhoan';
        $addRoute = 'addTaiKhoan'; // Đổi thành tên route tương ứng nếu có
        $primaryKey = 'user_id';
        $allowAdd = true;
        return view('managerPage.index', compact('items', 'primaryKey', 'columns', 'type', 'layout', 'updateRoute', 'deleteRoute', 'addRoute', 'allowAdd'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'permission' => 'required|in:user,manager,admin',
        ]);

        $user = User::create([
            'email' => $request->input('email'),
            'password' => "123456",
            'permission' => $request->input('permission'),
            'name' => $this->shortName($request->input('hovaten')),
        ]);

        // Tạo thông tin cá nhân nếu có
        ThongtincanhanModel::create([
            'user_id' => $user->id,
            'hovaten' => $request->input('hovaten'),
            'dvcongtac' => $request->input('dvcongtac'),
            'email' => $request->input('email'),
        ]);

        return back()->with('success', 'Tạo tài khoản thành công!');
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
            $ttcn->email = $request->input('email'); // Cập nhật email nếu cần
            $ttcn->save();
        } else {
            // Nếu chưa có thì tạo mới
            ThongtincanhanModel::create([
                'user_id' => $id,
                'hovaten' => $request->input('hovaten'),
                'dvcongtac' => $request->input('dvcongtac'),
                'email' => $request->input('email'),
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

     private function shortName($fullName)
    {
        // Bảng chuyển đổi bỏ dấu
        $map = [
            'à'=>'a','á'=>'a','ạ'=>'a','ả'=>'a','ã'=>'a',
            'â'=>'a','ầ'=>'a','ấ'=>'a','ậ'=>'a','ẩ'=>'a','ẫ'=>'a',
            'ă'=>'a','ằ'=>'a','ắ'=>'a','ặ'=>'a','ẳ'=>'a','ẵ'=>'a',
            'è'=>'e','é'=>'e','ẹ'=>'e','ẻ'=>'e','ẽ'=>'e',
            'ê'=>'e','ề'=>'e','ế'=>'e','ệ'=>'e','ể'=>'e','ễ'=>'e',
            'ì'=>'i','í'=>'i','ị'=>'i','ỉ'=>'i','ĩ'=>'i',
            'ò'=>'o','ó'=>'o','ọ'=>'o','ỏ'=>'o','õ'=>'o',
            'ô'=>'o','ồ'=>'o','ố'=>'o','ộ'=>'o','ổ'=>'o','ỗ'=>'o',
            'ơ'=>'o','ờ'=>'o','ớ'=>'o','ợ'=>'o','ở'=>'o','ỡ'=>'o',
            'ù'=>'u','ú'=>'u','ụ'=>'u','ủ'=>'u','ũ'=>'u',
            'ư'=>'u','ừ'=>'u','ứ'=>'u','ự'=>'u','ử'=>'u','ữ'=>'u',
            'ỳ'=>'y','ý'=>'y','ỵ'=>'y','ỷ'=>'y','ỹ'=>'y',
            'đ'=>'d',
            // Chữ hoa
            'À'=>'A','Á'=>'A','Ạ'=>'A','Ả'=>'A','Ã'=>'A',
            'Â'=>'A','Ầ'=>'A','Ấ'=>'A','Ậ'=>'A','Ẩ'=>'A','Ẫ'=>'A',
            'Ă'=>'A','Ằ'=>'A','Ắ'=>'A','Ặ'=>'A','Ẳ'=>'A','Ẵ'=>'A',
            'È'=>'E','É'=>'E','Ẹ'=>'E','Ẻ'=>'E','Ẽ'=>'E',
            'Ê'=>'E','Ề'=>'E','Ế'=>'E','Ệ'=>'E','Ể'=>'E','Ễ'=>'E',
            'Ì'=>'I','Í'=>'I','Ị'=>'I','Ỉ'=>'I','Ĩ'=>'I',
            'Ò'=>'O','Ó'=>'O','Ọ'=>'O','Ỏ'=>'O','Õ'=>'O',
            'Ô'=>'O','Ồ'=>'O','Ố'=>'O','Ộ'=>'O','Ổ'=>'O','Ỗ'=>'O',
            'Ơ'=>'O','Ờ'=>'O','Ớ'=>'O','Ợ'=>'O','Ở'=>'O','Ỡ'=>'O',
            'Ù'=>'U','Ú'=>'U','Ụ'=>'U','Ủ'=>'U','Ũ'=>'U',
            'Ư'=>'U','Ừ'=>'U','Ứ'=>'U','Ự'=>'U','Ử'=>'U','Ữ'=>'U',
            'Ỳ'=>'Y','Ý'=>'Y','Ỵ'=>'Y','Ỷ'=>'Y','Ỹ'=>'Y',
            'Đ'=>'D'
        ];

        // Chuẩn hoá khoảng trắng
        $fullName = trim(preg_replace('/\s+/', ' ', $fullName));

        // Bỏ dấu
        $fullName = strtr($fullName, $map);

        // Tách tên
        $parts = explode(' ', $fullName);
        $lastName = strtolower(array_pop($parts));
        $initials = '';

        foreach ($parts as $word) {
            $initials .= strtolower($word[0]);
        }

        return $initials . $lastName;
    }
}

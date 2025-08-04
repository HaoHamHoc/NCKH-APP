<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DangNhapController extends Controller
{
    //
    public function loginNguoidung(Request $request)
    {
        try {
            Log::info('Bắt đầu quá trình đăng nhập', ['email' => $request->email]);
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            Log::debug('Validation thành công');

            $user = User::where('email', $request->email)->first();
            Log::debug('Kết quả tìm user', ['user_exists' => $user !== null]);

            if ($user) {
                Log::debug('Thông tin user', [
                    'db_password' => $user->password,
                    'input_password' => $request->password,
                    'permission' => $user->permission
                ]);
            }

            if ($user && $request->password === $user->password) {
                Log::debug('Mật khẩu khớp, kiểm tra permission');
                if ($user->permission === 'admin') {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return response()->json([
                        'success' => true,
                        'redirect' => '/admin/trangquanly'
                    ]);
                }
                if ($user->permission === 'manager') {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return response()->json([
                        'success' => true,
                        'redirect' => '/quanlyhethong/trangquanly'
                    ]);
                }
                if ($user->permission === 'user') {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return response()->json([
                        'success' => true,
                        'redirect' => '/detainckh'
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'redirect' => '/'
                ]);
            }
            Log::warning('Đăng nhập thất bại', ['reason' => 'Email hoặc mật khẩu không đúng']);
            return response()->json([
                'success' => false,
                'errors' => true,
                'message' => 'Email hoặc mật khẩu không đúng'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => true,
                'message' => 'Email sai định dạng'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi đăng nhập: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'input' => $request->only('email'),
                'trace' => $e->getTraceAsString() // Thêm stack trace để debug chi tiết
            ]);
            return back()->withErrors([
                'email' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.',
            ]);
        }
    }
    public function Dangxuat(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/trangdangnhap');
    }
}

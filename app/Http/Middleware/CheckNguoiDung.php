<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckNguoiDung
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            Log::warning('Truy cập không hợp lệ - người dùng chưa đăng nhập.', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'agent' => $request->userAgent()
            ]);
            // Nếu là request API / fetch
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa đăng nhập.'
                ], 401);
            }
            return redirect('/trangdangnhap');
        }
        $request->merge(['id_nguoidung' => Auth::id()]);
        Log::warning('Truy cập thành công', [
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'agent' => $request->userAgent()
        ]);
        return $next($request);
    }
}

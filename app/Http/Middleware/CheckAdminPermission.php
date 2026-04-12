<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     * 
     * Kiểm tra xem user có quyền truy cập admin area không
     * Yêu cầu: Đã đăng nhập bằng admin guard
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem đã đăng nhập với admin guard chưa
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }

        // Khi sẽ có tính năng phân quyền chi tiết hơn, có thể check role ở đây
        // Ví dụ: if (!Auth::guard('admin')->user()->hasPermission('admin.access')) { ... }

        return $next($request);
    }
}

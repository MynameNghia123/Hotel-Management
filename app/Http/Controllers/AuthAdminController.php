<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;

class AuthAdminController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Hiển thị trang đăng nhập admin
     */
    public function showLogin()
    {
        // Nếu đã login rồi → redirect tới dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(AuthRequest $request)
    {
        $validated = $request->validated();

        // Gọi service để authenticate
        $staff = $this->authService->login($validated['email'], $validated['password']);

        if (! $staff) {
            return redirect()->back()
                ->with('error', 'Email hoặc mật khẩu không đúng, hoặc tài khoản đã bị vô hiệu hóa')
                ->withInput($request->only('email'));
        }

        // Đăng nhập thành công
        return redirect()->route('admin.dashboard')
            ->with('success', 'Đăng nhập thành công! Xin chào '.$staff->first_name.' '.$staff->last_name);
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('admin.login')
            ->with('success', 'Đã đăng xuất thành công');
    }
}

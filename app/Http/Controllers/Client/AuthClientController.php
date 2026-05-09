<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Mail\WelcomeMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthClientController extends Controller
{

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        // Kiểm tra xem email đã được đăng ký chưa
        $customer = Customer::where('email', $email)->first();
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Email này chưa được đăng ký. Vui lòng tạo tài khoản trước.',
                'redirect' => route('register'),
            ], 422);
        }

        // Tạo ngẫu nhiên 6 số
        $otp = rand(100000, 999999);

        // Lưu vào Cache 5 phút
        Cache::put('login_otp_' . $email, $otp, now()->addMinutes(5));

        // Gửi email
        Mail::to($email)->send(new LoginOtpMail($otp));

        return response()->json([
            'success' => true,
            'message' => 'Mã xác thực đã được gửi! Vui lòng kiểm tra hộp thư email.',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $email = $request->email;
        $otp   = $request->otp;

        $cachedOtp = Cache::get('login_otp_' . $email);

        if (!$cachedOtp || $cachedOtp != $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Mã xác thực không hợp lệ hoặc đã hết hạn (5 phút).',
            ], 422);
        }

        Cache::forget('login_otp_' . $email);

        // Tìm khách hàng theo email — không tự động tạo tài khoản rỗng
        $customer = Customer::where('email', $email)->first();

        if (!$customer) {
            return response()->json([
                'success'  => false,
                'message'  => 'Email này chưa được đăng ký. Vui lòng tạo tài khoản trước.',
                'redirect' => route('register'),
            ], 422);
        }

        // Đăng nhập
        Auth::login($customer);

        return response()->json([
            'success'  => true,
            'message'  => 'Đăng nhập thành công!',
            'redirect' => route('home'),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|unique:customers,email',
            'phone_number' => 'nullable|string|max:20',
            'country'      => 'nullable|string|max:100',
        ], [
            'first_name.required' => 'Vui lòng nhập tên.',
            'last_name.required'  => 'Vui lòng nhập họ.',
            'email.required'      => 'Vui lòng nhập email.',
            'email.unique'        => 'Email này đã được đăng ký. Vui lòng đăng nhập.',
        ]);

        // Tạo tài khoản mới
        $customer = Customer::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'country'      => $request->country,
        ]);

        // Đăng nhập luôn sau khi đăng ký
        Auth::login($customer);

        // Gửi email chào mừng
        Mail::to($customer->email)->send(new WelcomeMail($customer));

        return response()->json([
            'success'  => true,
            'message'  => 'Tạo tài khoản thành công! Chào mừng bạn đến với Urban Luxe.',
            'redirect' => route('home'),
        ]);
    }

    // ─────────────────────────────────────────
    // Đăng xuất
    // ─────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Hiển thị trang profile của customer đang đăng nhập
     */
    public function show()
    {
        $customer = Auth::user();

        // Lấy lịch sử đặt phòng, mới nhất trước, kèm chi tiết phòng
        $bookings = $customer->bookings()
            ->with(['bookingDetails.room.roomType'])
            ->orderByDesc('booking_date')
            ->get();

        return view('client.pages.profile', compact('customer', 'bookings'));
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function update(Request $request)
    {
        $customer = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ], [
            'first_name.required' => 'Vui lòng nhập tên.',
            'last_name.required' => 'Vui lòng nhập họ.',
        ]);

        $customer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'country' => $request->country,
        ]);

        return redirect()->route('profile')->with('success', 'Thông tin của bạn đã được cập nhật thành công!');
    }
}

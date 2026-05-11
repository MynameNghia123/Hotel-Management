<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ClientBookingServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ClientBookingController extends Controller
{
    public function __construct(
        private readonly ClientBookingServiceInterface $clientBookingService
    ) {
    }

    public function initCheckout(Request $request)
    {
        try {
            $cart = $this->clientBookingService->buildCheckoutCart($request->all());
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        session(['booking_cart' => $cart]);

        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $cart = session('booking_cart');
        if (!$cart) {
            return redirect()->route('search')->with('error', 'Gio hang trong. Vui long chon phong.');
        }

        try {
            $checkoutData = $this->clientBookingService->prepareCheckoutData($cart);
        } catch (Throwable $e) {
            session()->forget('booking_cart');

            return redirect()
                ->route('search')
                ->with('error', $e->getMessage());
        }

        $user = Auth::guard('web')->user();

        return view('client.pages.checkout', array_merge($checkoutData, ['user' => $user]));
    }

    public function lookupCustomerByEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $customer = $this->clientBookingService->findCustomerByEmail($validated['email']);

        return response()->json([
            'exists' => (bool) $customer,
            'customer' => $customer ? [
                'id' => (int) $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'full_name' => trim(($customer->last_name ?? '') . ' ' . ($customer->first_name ?? '')),
                'email' => $customer->email,
                'phone_number' => $customer->phone_number,
            ] : null,
        ]);
    }

    public function store(Request $request)
    {
        $cart = session('booking_cart');
        if (!$cart) {
            return redirect()->route('search')->with('error', 'Gio hang trong.');
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $booking = $this->clientBookingService->createBookingFromCart(
                $cart,
                $request->only(['first_name', 'last_name', 'email', 'phone']),
                Auth::guard('web')->check() ? (int) Auth::guard('web')->id() : null
            );

            session()->forget('booking_cart');
            session(['booking_id' => $booking->id]);

            return redirect()->route('payment');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function payment()
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home');
        }

        $booking = $this->clientBookingService->getBookingForPayment((int) $bookingId);
        if (!$booking) {
            return redirect()->route('home');
        }

        return view('client.pages.payment', compact('booking'));
    }

    public function processPayment(Request $request)
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home');
        }

        $booking = $this->clientBookingService->getBookingForPayment((int) $bookingId);
        if (!$booking) {
            return redirect()->route('home');
        }

        $paymentType = $request->input('payment_type', 'pay_at_hotel');

        if ($paymentType === 'vnpay') {
            try {
                $paymentUrl = $this->clientBookingService->createVnpayPaymentUrl(
                    $booking,
                    $request->input('bank_code'),
                    $request->ip()
                );
            } catch (Throwable $e) {
                return redirect()->route('payment')->with('error', $e->getMessage());
            }

            return redirect($paymentUrl);
        }

        return redirect()
            ->route('success')
            ->with('success', 'Dat phong thanh cong! Vui long thanh toan tai quay khi nhan phong.');
    }

    public function vnpayReturn(Request $request)
    {
        $result = $this->clientBookingService->handleVnpayReturn($request->all());

        if (($result['ok'] ?? false) === true) {
            session(['booking_id' => $result['booking_id']]);

            return redirect()
                ->route('success')
                ->with('success', $result['message'] ?? 'Thanh toan dat phong thanh cong!');
        }

        $routeName = $result['route'] ?? 'payment';

        return redirect()
            ->route($routeName)
            ->with('error', $result['message'] ?? 'Khong the xu ly thanh toan VNPAY.');
    }

    public function success()
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home');
        }

        $booking = $this->clientBookingService->getBookingForSuccess((int) $bookingId);
        if (!$booking) {
            return redirect()->route('home');
        }

        return view('client.pages.success', compact('booking'));
    }
}

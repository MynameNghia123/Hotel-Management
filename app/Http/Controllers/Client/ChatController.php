<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    private const COOKIE_NAME = 'chat_session_token';
    private const COOKIE_DAYS = 30;

    public function __construct(private GeminiService $gemini) {}

    // ── Gửi tin nhắn ───────────────────────────────────────────────
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $session = $this->resolveSession($request);

        $history = $session->messages()
            ->orderBy('created_at')
            ->take(20)
            ->get()
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->toArray();

        $userMessage = $request->input('message');

        ChatMessage::create([
            'chat_session_id' => $session->id,
            'role'            => 'user',
            'content'         => $userMessage,
        ]);

        $aiReply = $this->gemini->chat($history, $userMessage);

        ChatMessage::create([
            'chat_session_id' => $session->id,
            'role'            => 'model',
            'content'         => $aiReply,
        ]);

        $response = response()->json([
            'success'       => true,
            'reply'         => $aiReply,
            'session_token' => $session->session_token,
        ]);

        // Guest → set cookie; Logged-in → xoá guest cookie nếu còn
        if (!Auth::check()) {
            $response->withCookie(
                cookie(self::COOKIE_NAME, $session->session_token, self::COOKIE_DAYS * 24 * 60)
            );
        } else {
            $response->withCookie(cookie()->forget(self::COOKIE_NAME));
        }

        return $response;
    }

    // ── Lấy lịch sử chat ───────────────────────────────────────────
    public function getHistory(Request $request): JsonResponse
    {
        $session = $this->findOrMergeSession($request);

        if (!$session) {
            return response()->json(['success' => true, 'messages' => [], 'session_token' => null]);
        }

        $messages = $session->messages()
            ->orderBy('created_at')
            ->get(['role', 'content', 'created_at']);

        $response = response()->json([
            'success'       => true,
            'messages'      => $messages,
            'session_token' => Auth::check() ? null : $session->session_token,
        ]);

        // Xoá guest cookie khi đã đăng nhập
        if (Auth::check()) {
            $response->withCookie(cookie()->forget(self::COOKIE_NAME));
        }

        return $response;
    }

    // ── Resume session bằng token (Guest) ──────────────────────────
    public function resumeSession(Request $request): JsonResponse
    {
        $request->validate(['token' => 'required|string|size:32']);

        $session = ChatSession::where('session_token', $request->token)
            ->whereNull('customer_id')
            ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Mã token không hợp lệ hoặc đã hết hạn.',
            ], 404);
        }

        $messages = $session->messages()
            ->orderBy('created_at')
            ->get(['role', 'content', 'created_at']);

        return response()->json([
            'success'       => true,
            'messages'      => $messages,
            'session_token' => $session->session_token,
        ])->withCookie(
            cookie(self::COOKIE_NAME, $session->session_token, self::COOKIE_DAYS * 24 * 60)
        );
    }

    // ─────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────────────────────────────

    /**
     * Lấy/tạo session. Nếu customer vừa login và có guest cookie → merge.
     */
    private function resolveSession(Request $request): ChatSession
    {
        $guestToken = $request->cookie(self::COOKIE_NAME);

        if (Auth::check()) {
            return $this->resolveCustomerSession(Auth::id(), $guestToken);
        }

        // Guest có cookie hợp lệ
        if ($guestToken) {
            $session = ChatSession::where('session_token', $guestToken)
                ->whereNull('customer_id')
                ->first();
            if ($session) return $session;
        }

        // Guest mới → tạo session
        return ChatSession::create([
            'session_token' => Str::random(32),
            'customer_id'   => null,
        ]);
    }

    /**
     * Tìm session (không tạo mới). Tự động merge nếu customer có guest cookie.
     */
    private function findOrMergeSession(Request $request): ?ChatSession
    {
        $guestToken = $request->cookie(self::COOKIE_NAME);

        if (Auth::check()) {
            return $this->resolveCustomerSession(Auth::id(), $guestToken);
        }

        if ($guestToken) {
            return ChatSession::where('session_token', $guestToken)
                ->whereNull('customer_id')
                ->first();
        }

        return null;
    }

    /**
     * Resolve session cho customer đã đăng nhập.
     * Tự động merge guest session nếu có.
     */
    private function resolveCustomerSession(int $customerId, ?string $guestToken): ChatSession
    {
        $customerSession = ChatSession::where('customer_id', $customerId)->first();

        // Không có guest cookie → dùng/tạo customer session
        if (!$guestToken) {
            return $customerSession ?? ChatSession::create([
                'session_token' => Str::random(32),
                'customer_id'   => $customerId,
            ]);
        }

        // Có guest cookie → tìm guest session
        $guestSession = ChatSession::where('session_token', $guestToken)
            ->whereNull('customer_id')
            ->first();

        if (!$guestSession) {
            // Guest cookie không hợp lệ → dùng/tạo customer session
            return $customerSession ?? ChatSession::create([
                'session_token' => Str::random(32),
                'customer_id'   => $customerId,
            ]);
        }

        // ── Merge: guest session → customer session ──
        if ($customerSession) {
            // Customer đã có session → gộp tin nhắn của guest vào
            ChatMessage::where('chat_session_id', $guestSession->id)
                ->orderBy('created_at')
                ->update(['chat_session_id' => $customerSession->id]);
            $guestSession->delete();
            return $customerSession;
        }

        // Customer chưa có session → claim luôn guest session
        $guestSession->update(['customer_id' => $customerId]);
        return $guestSession->fresh();
    }
}

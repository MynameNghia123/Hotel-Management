<?php

namespace App\Services;

use App\Enums\RoomStatus;
use App\Models\RoomType;
use App\Models\Service;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;

    private string $model;

    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-2.5-flash-lite');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Gửi tin nhắn và nhận phản hồi từ Gemini API.
     */
    public function chat(array $history, string $newMessage): string
    {
        $contents = [];
        foreach ($history as $msg) {
            $contents[] = [
                'role' => $msg['role'],
                'parts' => [['text' => $msg['content']]],
            ];
        }
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $newMessage]],
        ];

        $systemPrompt = $this->buildSystemPrompt();

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemPrompt]],
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 600,
            ],
        ];

        try {
            $response = $this->callApi($payload);

            if ($response->failed()) {
                Log::error('Gemini API error', [
                    'status' => $response->status(),
                    'body' => substr($response->body(), 0, 500),
                    'prompt_length' => strlen($systemPrompt),
                ]);

                if (in_array($response->status(), [429, 503])) {
                    return 'Hệ thống AI đang bận do nhiều người dùng cùng lúc. Vui lòng thử lại sau vài giây! ⏳';
                }

                return 'Xin lỗi, tôi đang gặp sự cố kỹ thuật. Vui lòng thử lại sau hoặc liên hệ lễ tân để được hỗ trợ. 🙏';
            }

            $data = $response->json();

            return $data['candidates'][0]['content']['parts'][0]['text']
                ?? 'Xin lỗi, tôi không thể xử lý yêu cầu này. Vui lòng thử lại.';

        } catch (\Exception $e) {
            Log::error('Gemini Service exception', ['message' => $e->getMessage()]);

            return 'Xin lỗi, dịch vụ AI tạm thời không khả dụng. Vui lòng thử lại sau.';
        }
    }

    /**
     * Gọi Gemini API — thử lần lượt các model khi bị rate limit.
     */
    private function callApi(array $payload): Response
    {
        // Danh sách model fallback theo ưu tiên
        $models = array_unique([
            $this->model,
            'gemini-3.7-flash',
            'gemini-3.6-flash',
            'gemini-3.5-flash',
            'gemini-2.5-flash',
            'gemini-2.5-flash-lite',
        ]);

        $lastResponse = null;

        foreach ($models as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";
            $res = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$url}?key={$this->apiKey}", $payload);

            if ($res->successful()) {
                if ($model !== $this->model) {
                    Log::info('Gemini fallback to model', ['model' => $model]);
                }

                return $res;
            }

            $lastResponse = $res;

            // Nếu 429 (Rate limit) hoặc 503 (Overloaded) → chờ rồi thử model tiếp theo
            if (in_array($res->status(), [429, 503])) {
                Log::warning('Gemini busy or rate limited, trying next model', ['tried' => $model, 'status' => $res->status()]);
                sleep(2);

                continue;
            }

            // Lỗi khác (ví dụ sai key 400, 403) → dừng
            break;
        }

        return $lastResponse;
    }

    // ──────────────────────────────────────────────────────────────────
    // System prompt — cache 10 phút
    // ──────────────────────────────────────────────────────────────────
    private function buildSystemPrompt(): string
    {
        return Cache::remember('gemini_system_prompt', 600, function () {
            // Giới hạn độ dài để tránh vượt token limit
            $roomInfo = mb_substr($this->buildRoomInfo(), 0, 3000);
            $serviceInfo = mb_substr($this->buildServiceInfo(), 0, 800);

            $prompt = "Bạn là trợ lý ảo thân thiện của khách sạn **Urban Luxe** - khách sạn 5 sao sang trọng tại trung tâm thành phố.\n\n"
                ."## NHIỆM VỤ\n"
                ."- Tư vấn chi tiết về các loại phòng, giá, tiện ích dựa trên dữ liệu thực tế bên dưới\n"
                ."- Hỗ trợ khách đặt phòng, giải thích quy trình đặt phòng trên website\n"
                ."- Giải đáp chính sách hủy, thanh toán, check-in/check-out\n\n"
                ."## THÔNG TIN KHÁCH SẠN\n"
                ."- Hotline: 1900-xxxx | Email: info@urbanluxe.vn\n"
                ."- Check-in: 14:00 | Check-out: 12:00\n"
                ."- Chính sách hủy: Miễn phí trước 24h; mất 1 đêm nếu hủy trong 24h\n"
                ."- Thanh toán: Tiền mặt, thẻ, VNPay\n\n"
                ."## DANH SÁCH PHÒNG\n".$roomInfo."\n\n"
                ."## DỊCH VỤ BỔ SUNG\n".$serviceInfo."\n\n"
                ."## CÁCH ĐẶT PHÒNG\n"
                ."Vào trang Tìm kiếm → chọn ngày → chọn phòng → điền thông tin → thanh toán.\n\n"
                ."## PHONG CÁCH\n"
                ."- Lịch sự, thân thiện, dùng emoji phù hợp 😊\n"
                ."- Tiếng Việt ưu tiên; tiếng Anh nếu khách hỏi tiếng Anh\n"
                ."- Tối đa 200 từ/câu trả lời\n"
                ."- Nêu giá, sức chứa, tiện ích khi tư vấn phòng\n"
                .'- Không biết thì đề nghị liên hệ lễ tân';

            Log::info('Gemini system prompt built', ['length' => strlen($prompt)]);

            return $prompt;
        });
    }

    // ──────────────────────────────────────────────────────────────────
    // Build thông tin phòng từ DB
    // ──────────────────────────────────────────────────────────────────
    private function buildRoomInfo(): string
    {
        $roomTypes = RoomType::where('is_active', true)
            ->with(['amenities', 'rooms'])
            ->get();

        if ($roomTypes->isEmpty()) {
            return 'Hiện chưa có thông tin phòng. Vui lòng liên hệ lễ tân.';
        }

        $lines = [];
        foreach ($roomTypes as $rt) {
            $available = $rt->rooms->filter(fn ($r) => $r->status === RoomStatus::EMPTY)->count();
            $total = $rt->rooms->count();
            $dailyPrice = number_format($rt->daily_price, 0, ',', '.').' VNĐ/đêm';
            $hourlyPrice = $rt->hourly_price
                ? number_format($rt->hourly_price, 0, ',', '.').' VNĐ/giờ'
                : null;
            $size = ($rt->width && $rt->height) ? "{$rt->width}x{$rt->height}m" : '';
            $beds = array_filter([
                $rt->single_bed_quantity ? "{$rt->single_bed_quantity} đơn" : null,
                $rt->double_bed_quantity ? "{$rt->double_bed_quantity} đôi" : null,
            ]);
            $amenities = $rt->amenities->pluck('name')->implode(', ') ?: 'đang cập nhật';
            $statusStr = $available > 0 ? "còn {$available}/{$total} phòng" : 'hết phòng';

            $line = "- **{$rt->name}** ({$rt->code}): {$dailyPrice}"
                .($hourlyPrice ? " | {$hourlyPrice}" : '')
                .($size ? " | {$size}" : '')
                ." | {$rt->adult_quantity} người lớn"
                .(count($beds) ? ' | '.implode(', ', $beds) : '')
                ." | {$amenities} | {$statusStr}";

            if ($rt->description) {
                $line .= "\n  ".mb_substr($rt->description, 0, 120);
            }
            $lines[] = $line;
        }

        return implode("\n", $lines);
    }

    // ──────────────────────────────────────────────────────────────────
    // Build thông tin dịch vụ từ DB
    // ──────────────────────────────────────────────────────────────────
    private function buildServiceInfo(): string
    {
        $services = Service::with('group')->get();

        if ($services->isEmpty()) {
            return 'Đang cập nhật. Vui lòng liên hệ lễ tân.';
        }

        $grouped = $services->groupBy(fn ($s) => $s->group?->name ?? 'Khác');
        $lines = [];

        foreach ($grouped as $groupName => $items) {
            $itemLines = $items->map(function ($s) {
                $price = $s->unit_price
                    ? number_format($s->unit_price, 0, ',', '.')." VNĐ/{$s->unit}"
                    : 'liên hệ';

                return "  - {$s->name}: {$price}";
            })->implode("\n");
            $lines[] = "**{$groupName}**:\n{$itemLines}";
        }

        return implode("\n", $lines);
    }
}

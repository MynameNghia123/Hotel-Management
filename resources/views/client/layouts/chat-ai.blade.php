{{-- Urban Luxe AI Chat Box Widget --}}
<div class="chat-ai-widget">

    {{-- Toggle Button --}}
    <div class="chat-ai-toggle" id="chatAiToggle">
        <i class="fas fa-robot"></i>
        <i class="fas fa-times"></i>
    </div>

    {{-- Chat Container --}}
    <div class="chat-ai-container" id="chatAiContainer">

        {{-- Header --}}
        <div class="chat-ai-header">
            <div class="ai-avatar">
                <i class="fas fa-robot"></i>
                <div class="status-dot"></div>
            </div>
            <div class="ai-info">
                <h4>Hỗ trợ Urban Luxe AI</h4>
                <span>Trực tuyến 24/7</span>
            </div>
        </div>

        {{-- Messages --}}
        <div class="chat-ai-messages" id="chatAiMessages">
            <div class="message message-ai">
                Xin chào! Tôi là trợ lý ảo của Urban Luxe. Tôi có thể giúp gì cho bạn hôm nay? 😊
            </div>

            {{-- Typing Indicator --}}
            <div class="message message-ai typing-indicator-msg" style="display: none;">
                <div class="typing-indicator">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            </div>
        </div>

        {{-- Quick Action Chips --}}
        <div class="chat-quick-actions">
            <div class="action-chip" onclick="sendQuickMessage('Có những loại phòng nào?')">Loại phòng?</div>
            <div class="action-chip" onclick="sendQuickMessage('Tiện ích khách sạn có gì?')">Tiện ích?</div>
            <div class="action-chip" onclick="sendQuickMessage('Chính sách hủy phòng như thế nào?')">Hủy phòng?</div>
            <div class="action-chip" onclick="sendQuickMessage('Giờ check-in và check-out?')">Check-in?</div>
        </div>

        {{-- Input Area --}}
        <div class="chat-ai-input-area">
            <div class="chat-input-wrapper">
                <input type="text" id="chatAiInput" placeholder="Nhập tin nhắn..." autocomplete="off" maxlength="2000">
            </div>
            <button class="btn-send" id="chatAiSend" title="Gửi">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
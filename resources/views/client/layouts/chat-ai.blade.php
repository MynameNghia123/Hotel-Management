<!-- Urban Luxe AI Chat Box Widget -->
<div class="chat-ai-widget">
    <!-- Toggle Button -->
    <div class="chat-ai-toggle" id="chatAiToggle">
        <i class="fas fa-robot"></i>
        <i class="fas fa-times"></i>
    </div>

    <!-- Chat Container -->
    <div class="chat-ai-container" id="chatAiContainer">
        <!-- Header -->
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

        <!-- Messages -->
        <div class="chat-ai-messages" id="chatAiMessages">
            <div class="message message-ai">
                Xin chào! Tôi là trợ lý ảo của Urban Luxe. Tôi có thể giúp gì cho bạn hôm nay?
            </div>
            
            <!-- Typing Indicator (Hidden by default) -->
            <div class="message message-ai typing-indicator-msg" style="display: none;">
                <div class="typing-indicator">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            </div>
        </div>

        <!-- Quick Action Chips -->
        <div class="chat-quick-actions">
            <div class="action-chip" onclick="sendQuickMessage('Giá phòng hôm nay?')">Giá phòng hôm nay?</div>
            <div class="action-chip" onclick="sendQuickMessage('Tiện ích khách sạn?')">Tiện ích?</div>
            <div class="action-chip" onclick="sendQuickMessage('Chính sách hủy?')">Hủy phòng?</div>
        </div>

        <!-- Input Area -->
        <div class="chat-ai-input-area">
            <div class="chat-input-wrapper">
                <input type="text" id="chatAiInput" placeholder="Nhập tin nhắn..." autocomplete="off">
            </div>
            <button class="btn-send" id="chatAiSend">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('chatAiToggle');
        const container = document.getElementById('chatAiContainer');
        const input = document.getElementById('chatAiInput');
        const sendBtn = document.getElementById('chatAiSend');
        const messagesLayer = document.getElementById('chatAiMessages');

        // Toggle Chat Window
        toggle.addEventListener('click', () => {
            toggle.classList.toggle('active');
            container.classList.toggle('active');
            if(container.classList.contains('active')) {
                input.focus();
            }
        });

        // Send Message Function
        function sendMessage() {
            const text = input.value.trim();
            if (text === '') return;

            // Add User Message
            addMessage(text, 'user');
            input.value = '';

            // Simulate AI Response
            showTyping(true);
            setTimeout(() => {
                showTyping(false);
                addMessage('Cảm ơn bạn đã quan tâm. Đây là câu trả lời mẫu từ trợ lý AI của Urban Luxe về "' + text + '".', 'ai');
            }, 1500);
        }

        // Add Message to DOM
        function addMessage(text, type) {
            const msgDiv = document.createElement('div');
            msgDiv.classList.add('message');
            msgDiv.classList.add(type === 'user' ? 'message-user' : 'message-ai');
            msgDiv.textContent = text;
            messagesLayer.appendChild(msgDiv);
            
            // Scroll to bottom
            messagesLayer.scrollTop = messagesLayer.scrollHeight;
        }

        // Show/Hide Typing
        function showTyping(show) {
            const typingMsg = document.querySelector('.typing-indicator-msg');
            if (show) {
                messagesLayer.appendChild(typingMsg);
                typingMsg.style.display = 'block';
            } else {
                typingMsg.style.display = 'none';
            }
            messagesLayer.scrollTop = messagesLayer.scrollHeight;
        }

        // Event Listeners
        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });

        // Global function for quick chips
        window.sendQuickMessage = function(text) {
            input.value = text;
            sendMessage();
        };
    });
</script>

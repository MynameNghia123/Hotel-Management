/**
 * chat.js — Logic AI Chat cho Urban Luxe Hotel
 */
document.addEventListener('DOMContentLoaded', function () {
    const toggle     = document.getElementById('chatAiToggle');
    const container  = document.getElementById('chatAiContainer');
    const input      = document.getElementById('chatAiInput');
    const sendBtn    = document.getElementById('chatAiSend');
    const messagesEl = document.getElementById('chatAiMessages');

    if (!toggle || !container) return;

    let isOpen        = false;
    let historyLoaded = false;

    // ── Toggle chatbox ──────────────────────────────────────────────
    toggle.addEventListener('click', () => {
        isOpen = !isOpen;
        toggle.classList.toggle('active', isOpen);
        container.classList.toggle('active', isOpen);

        if (isOpen && !historyLoaded) {
            loadHistory();
        }
        if (isOpen) setTimeout(() => input && input.focus(), 300);
    });

    // ── Load history khi mở chat lần đầu ───────────────────────────
    async function loadHistory() {
        historyLoaded = true;
        try {
            const res  = await fetch('/chat/history', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });
            const data = await res.json();

            if (data.success && data.messages && data.messages.length > 0) {
                const defaultMsg = messagesEl.querySelector('.message-ai:first-child');
                if (defaultMsg) defaultMsg.remove();
                data.messages.forEach(msg =>
                    addMessage(msg.content, msg.role === 'user' ? 'user' : 'ai', false)
                );
            }
        } catch (e) {
            console.warn('Could not load chat history:', e);
        }
    }

    // ── Gửi tin nhắn ───────────────────────────────────────────────
    async function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        addMessage(text, 'user');
        input.value = '';
        setBusy(true);

        try {
            const res = await fetch('/chat/send', {
                method:  'POST',
                headers: {
                    'Content-Type':     'application/json',
                    'X-CSRF-TOKEN':     getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ message: text }),
            });

            const data = await res.json();

            if (data.success) {
                addMessage(data.reply, 'ai');
            } else {
                addMessage('Xin lỗi, đã xảy ra lỗi. Vui lòng thử lại.', 'ai');
            }
        } catch (e) {
            addMessage('Không thể kết nối. Vui lòng kiểm tra mạng và thử lại.', 'ai');
        } finally {
            setBusy(false);
        }
    }

    // ── Thêm tin nhắn vào DOM ───────────────────────────────────────
    function addMessage(text, type, animate = true) {
        const typing = messagesEl.querySelector('.typing-indicator-msg');
        const msgDiv = document.createElement('div');
        msgDiv.classList.add('message', type === 'user' ? 'message-user' : 'message-ai');
        if (animate) msgDiv.classList.add('message-new');
        msgDiv.innerHTML = formatText(text);

        if (typing) {
            messagesEl.insertBefore(msgDiv, typing);
        } else {
            messagesEl.appendChild(msgDiv);
        }
        scrollToBottom();
    }

    // ── Format text ─────────────────────────────────────────────────
    function formatText(text) {
        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');
    }

    // ── Typing indicator ────────────────────────────────────────────
    function setBusy(busy) {
        const typingMsg = messagesEl.querySelector('.typing-indicator-msg');
        if (typingMsg) {
            if (busy) {
                typingMsg.style.display = 'block';
                messagesEl.appendChild(typingMsg);
                scrollToBottom();
            } else {
                typingMsg.style.display = 'none';
            }
        }
        if (sendBtn) sendBtn.disabled = busy;
        if (input)   input.disabled   = busy;
    }

    function scrollToBottom() {
        messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    // ── CSRF Token ──────────────────────────────────────────────────
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    }

    // ── Event Listeners ─────────────────────────────────────────────
    if (sendBtn) sendBtn.addEventListener('click', sendMessage);
    if (input) {
        input.addEventListener('keypress', e => {
            if (e.key === 'Enter' && !e.shiftKey) sendMessage();
        });
    }

    // ── Quick chips ─────────────────────────────────────────────────
    window.sendQuickMessage = function (text) {
        if (input) input.value = text;
        sendMessage();
    };
});

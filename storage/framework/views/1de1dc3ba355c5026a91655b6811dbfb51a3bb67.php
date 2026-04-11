
<?php if(auth()->guard()->check()): ?>
<div id="supportChatWidget">
    
    <button type="button" id="chatBubbleBtn" class="chat-bubble-btn" title="Chat with Support">
        <svg viewBox="0 0 24 24" fill="currentColor" width="26" height="26"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12z"/><path d="M7 9h2v2H7zm4 0h2v2h-2zm4 0h2v2h-2z"/></svg>
        <span id="chatUnreadBadge" class="chat-unread-badge" style="display:none;">0</span>
    </button>

    
    <div id="chatPanel" class="chat-panel" style="display:none;">
        <div class="chat-panel-header">
            <div class="chat-header-info">
                <div class="chat-header-avatar">🐾</div>
                <div>
                    <div class="chat-header-name">PetMarkt-PH Support</div>
                    <div class="chat-header-status" id="chatHeaderStatus">
                        <span class="chat-status-dot online"></span> Online
                    </div>
                </div>
            </div>
            <button type="button" class="chat-close-btn" id="chatCloseBtn">✕</button>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="chat-welcome">
                <div class="chat-welcome-icon">👋</div>
                <div class="chat-welcome-title">Hi there!</div>
                <div class="chat-welcome-text">How can we help you today? Send us a message and we'll reply as soon as possible.</div>
            </div>
        </div>

        
        <div id="chatTypingIndicator" class="chat-typing" style="display:none;">
            <div class="typing-dots"><span></span><span></span><span></span></div>
            <span>Support is typing...</span>
        </div>

        
        <div class="chat-quick-actions" id="chatQuickActions">
            <button type="button" class="chat-quick-btn" data-msg="Where is my order?">📦 Where is my order?</button>
            <button type="button" class="chat-quick-btn" data-msg="I need help with a return">🔄 Help with return</button>
            <button type="button" class="chat-quick-btn" data-msg="I have a product question">❓ Product question</button>
        </div>

        
        <div class="chat-input-area">
            <label for="chatImageInput" class="chat-attach-btn" title="Send Image">
                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                <input type="file" id="chatImageInput" accept="image/*" style="display:none;">
            </label>
            <div id="chatImagePreview" class="chat-image-preview" style="display:none;">
                <img id="chatImagePreviewImg" src="" alt="Preview">
                <button type="button" id="chatRemoveImage" class="chat-remove-image">✕</button>
            </div>
            <input type="text" id="chatInput" class="chat-input" placeholder="Type a message..." maxlength="2000" autocomplete="off">
            <button type="button" id="chatSendBtn" class="chat-send-btn" title="Send">
                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
            </button>
        </div>
    </div>
</div>

<style>
/* ── Chat Bubble ───────────────────────── */
.chat-bubble-btn {
    position: fixed; bottom: 80px; right: 24px; z-index: 9998;
    width: 60px; height: 60px; border-radius: 50%;
    background: linear-gradient(135deg, #FF8C42, #ea580c);
    color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 24px rgba(234,88,12,0.4);
    transition: all 0.3s cubic-bezier(.175,.885,.32,1.275);
    animation: chatBubblePulse 3s ease infinite;
}
.chat-bubble-btn:hover { transform: scale(1.1); box-shadow: 0 8px 30px rgba(234,88,12,0.5); }
@keyframes  chatBubblePulse {
    0%, 100% { box-shadow: 0 6px 24px rgba(234,88,12,0.4); }
    50% { box-shadow: 0 6px 24px rgba(234,88,12,0.2), 0 0 0 12px rgba(234,88,12,0.06); }
}
.chat-unread-badge {
    position: absolute; top: -4px; right: -4px;
    background: #ef4444; color: #fff; border-radius: 50%;
    width: 22px; height: 22px; font-size: 11px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    border: 2px solid #fff;
}

/* ── Chat Panel ─────────────────────────── */
.chat-panel {
    position: fixed; bottom: 80px; right: 24px; z-index: 9999;
    width: 380px; max-height: 560px; border-radius: 16px;
    background: #fff; box-shadow: 0 12px 48px rgba(0,0,0,0.18);
    display: flex; flex-direction: column;
    overflow: hidden;
    animation: chatSlideUp 0.35s cubic-bezier(.175,.885,.32,1.275);
}
@keyframes  chatSlideUp {
    from { opacity: 0; transform: translateY(20px) scale(0.95); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

.chat-panel-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 18px;
    background: linear-gradient(135deg, #FF8C42, #ea580c);
    color: #fff;
}
.chat-header-info { display: flex; align-items: center; gap: 12px; }
.chat-header-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(255,255,255,.2); display: flex;
    align-items: center; justify-content: center; font-size: 20px;
}
.chat-header-name { font-size: 15px; font-weight: 700; }
.chat-header-status { font-size: 12px; opacity: .9; display: flex; align-items: center; gap: 6px; }
.chat-status-dot {
    width: 8px; height: 8px; border-radius: 50%;
    display: inline-block;
}
.chat-status-dot.online { background: #4ade80; }
.chat-status-dot.offline { background: #9ca3af; }
.chat-close-btn {
    background: rgba(255,255,255,.2); border: none; color: #fff;
    width: 32px; height: 32px; border-radius: 50%;
    font-size: 16px; cursor: pointer; display: flex;
    align-items: center; justify-content: center;
    transition: background 0.2s;
}
.chat-close-btn:hover { background: rgba(255,255,255,.35); }

/* ── Messages ──────────────────────────── */
.chat-messages {
    flex: 1; overflow-y: auto; padding: 16px;
    min-height: 280px; max-height: 340px;
    background: #fafaf9;
}
.chat-welcome {
    text-align: center; padding: 30px 16px; color: #6b7280;
}
.chat-welcome-icon { font-size: 36px; margin-bottom: 8px; }
.chat-welcome-title { font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 6px; }
.chat-welcome-text { font-size: 13px; line-height: 1.5; }

.chat-msg {
    display: flex; margin-bottom: 10px; gap: 8px;
    animation: msgFadeIn 0.3s ease;
}
@keyframes  msgFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.chat-msg.user { flex-direction: row-reverse; }
.chat-msg-bubble {
    max-width: 75%; padding: 10px 14px; border-radius: 16px;
    font-size: 13px; line-height: 1.5; word-wrap: break-word;
}
.chat-msg.admin .chat-msg-bubble {
    background: #fff; color: #1f2937; border: 1px solid #e5e7eb;
    border-bottom-left-radius: 4px;
}
.chat-msg.user .chat-msg-bubble {
    background: linear-gradient(135deg, #FF8C42, #ea580c);
    color: #fff; border-bottom-right-radius: 4px;
}
.chat-msg-time {
    font-size: 10px; color: #9ca3af; margin-top: 4px;
    text-align: right;
}
.chat-msg.admin .chat-msg-time { text-align: left; }
.chat-msg-image {
    max-width: 200px; border-radius: 10px; margin-top: 6px;
    cursor: pointer; transition: transform 0.2s;
}
.chat-msg-image:hover { transform: scale(1.03); }

/* ── Typing ─────────────────────────────── */
.chat-typing {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 16px; font-size: 12px; color: #9ca3af;
    background: #fafaf9;
}
.typing-dots { display: flex; gap: 3px; }
.typing-dots span {
    width: 6px; height: 6px; border-radius: 50%;
    background: #9ca3af; animation: typingBounce 1.4s infinite;
}
.typing-dots span:nth-child(2) { animation-delay: 0.2s; }
.typing-dots span:nth-child(3) { animation-delay: 0.4s; }
@keyframes  typingBounce {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-6px); }
}

/* ── Quick Actions ──────────────────────── */
.chat-quick-actions {
    padding: 8px 12px; display: flex; gap: 6px; flex-wrap: wrap;
    border-top: 1px solid #f3f4f6; background: #fafaf9;
}
.chat-quick-btn {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 20px;
    padding: 6px 14px; font-size: 12px; color: #374151;
    cursor: pointer; transition: all 0.2s; white-space: nowrap;
}
.chat-quick-btn:hover { background: #FFF4EC; border-color: #ea580c; color: #ea580c; }

/* ── Input Area ─────────────────────────── */
.chat-input-area {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 14px; border-top: 1px solid #e5e7eb;
    background: #fff;
}
.chat-attach-btn {
    color: #9ca3af; cursor: pointer; display: flex;
    align-items: center; transition: color 0.2s;
}
.chat-attach-btn:hover { color: #ea580c; }
.chat-input {
    flex: 1; border: 1px solid #e5e7eb; border-radius: 20px;
    padding: 10px 16px; font-size: 13px; outline: none;
    transition: border-color 0.2s;
}
.chat-input:focus { border-color: #ea580c; }
.chat-send-btn {
    width: 38px; height: 38px; border-radius: 50%;
    background: linear-gradient(135deg, #FF8C42, #ea580c);
    color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: transform 0.2s;
}
.chat-send-btn:hover { transform: scale(1.08); }

.chat-image-preview {
    position: relative; max-width: 60px;
}
.chat-image-preview img {
    width: 50px; height: 50px; border-radius: 8px; object-fit: cover;
    border: 2px solid #ea580c;
}
.chat-remove-image {
    position: absolute; top: -6px; right: -6px;
    width: 18px; height: 18px; border-radius: 50%;
    background: #ef4444; color: #fff; border: none;
    font-size: 10px; cursor: pointer; display: flex;
    align-items: center; justify-content: center;
}

/* ── Mobile ──────────────────────────────── */
@media (max-width: 600px) {
    .chat-bubble-btn { bottom: 70px; right: 16px; width: 52px; height: 52px; }
    .chat-panel {
        bottom: 0; right: 0; left: 0; top: 0;
        width: 100vw; max-height: 100vh; border-radius: 0;
        position: fixed;
    }
    .chat-messages { max-height: none; flex: 1; }
}
</style>

<script>
(function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    let chatOpen = false;
    let chatLoaded = false;
    let selectedImage = null;
    let typingTimer = null;
    let sseSource = null;

    const bubble = document.getElementById('chatBubbleBtn');
    const panel = document.getElementById('chatPanel');
    const closeBtn = document.getElementById('chatCloseBtn');
    const sendBtn = document.getElementById('chatSendBtn');
    const input = document.getElementById('chatInput');
    const msgContainer = document.getElementById('chatMessages');
    const unreadBadge = document.getElementById('chatUnreadBadge');
    const quickActions = document.getElementById('chatQuickActions');
    const imageInput = document.getElementById('chatImageInput');
    const imagePreview = document.getElementById('chatImagePreview');
    const imagePreviewImg = document.getElementById('chatImagePreviewImg');
    const removeImageBtn = document.getElementById('chatRemoveImage');
    const typingIndicator = document.getElementById('chatTypingIndicator');

    // Toggle chat
    bubble.addEventListener('click', function() {
        if (chatOpen) {
            panel.style.display = 'none';
            bubble.style.display = 'flex';
            chatOpen = false;
        } else {
            panel.style.display = 'flex';
            bubble.style.display = 'none';
            chatOpen = true;
            if (!chatLoaded) loadMessages();
        }
    });

    closeBtn.addEventListener('click', function() {
        panel.style.display = 'none';
        bubble.style.display = 'flex';
        chatOpen = false;
    });

    // Send message
    function sendMessage() {
        const text = input.value.trim();
        if (!text && !selectedImage) return;

        const formData = new FormData();
        if (text) formData.append('message', text);
        if (selectedImage) formData.append('image', selectedImage);

        // Optimistic render
        appendMessage({
            sender_type: 'user',
            message: text,
            image_path: selectedImage ? URL.createObjectURL(selectedImage) : null,
            created_at: new Date().toISOString(),
            _local_image: true,
        });

        input.value = '';
        clearImagePreview();
        quickActions.style.display = 'none';
        scrollToBottom();

        fetch('<?php echo e(route("support-chat.send")); ?>', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin',
            body: formData,
        })
        .then(r => r.json())
        .catch(() => {});
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Typing indicator
    input.addEventListener('input', function() {
        if (typingTimer) clearTimeout(typingTimer);
        fetch('<?php echo e(route("support-chat.typing")); ?>', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin',
        }).catch(() => {});
        typingTimer = setTimeout(() => {}, 3000);
    });

    // Image handling
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        selectedImage = file;
        imagePreviewImg.src = URL.createObjectURL(file);
        imagePreview.style.display = 'block';
    });
    removeImageBtn.addEventListener('click', clearImagePreview);

    function clearImagePreview() {
        selectedImage = null;
        imagePreview.style.display = 'none';
        imagePreviewImg.src = '';
        imageInput.value = '';
    }

    // Quick actions
    quickActions.querySelectorAll('.chat-quick-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            input.value = this.dataset.msg;
            sendMessage();
        });
    });

    // Load messages
    function loadMessages() {
        chatLoaded = true;
        fetch('<?php echo e(route("support-chat.messages")); ?>', {
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin',
        })
        .then(r => r.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                msgContainer.innerHTML = '';
                data.messages.forEach(m => appendMessage(m));
                quickActions.style.display = 'none';
                scrollToBottom();
            }
        })
        .catch(() => {});
    }

    // Append a message to the chat
    function appendMessage(msg) {
        const isUser = msg.sender_type === 'user';
        const div = document.createElement('div');
        div.className = 'chat-msg ' + (isUser ? 'user' : 'admin');

        let content = '';
        if (msg.message) content += '<div>' + escapeHtml(msg.message) + '</div>';
        if (msg.image_path) {
            const imgSrc = msg._local_image ? msg.image_path : '/storage/' + msg.image_path;
            content += '<img src="' + imgSrc + '" class="chat-msg-image" onclick="window.open(this.src)" alt="Image">';
        }
        content += '<div class="chat-msg-time">' + formatTime(msg.created_at) + '</div>';

        div.innerHTML = '<div class="chat-msg-bubble">' + content + '</div>';
        msgContainer.appendChild(div);
    }

    function scrollToBottom() {
        setTimeout(() => { msgContainer.scrollTop = msgContainer.scrollHeight; }, 50);
    }

    function formatTime(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function escapeHtml(s) {
        if (!s) return '';
        const d = document.createElement('div'); d.textContent = s; return d.innerHTML;
    }

    // ── SSE Integration ──
    function connectSSE() {
        if (sseSource) sseSource.close();

        sseSource = new EventSource('<?php echo e(route("sse.user-stream")); ?>');

        sseSource.addEventListener('chat_count', function(e) {
            try {
                const data = JSON.parse(e.data);
                if (data.unread_count > 0 && !chatOpen) {
                    unreadBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                    unreadBadge.style.display = 'flex';
                } else {
                    unreadBadge.style.display = 'none';
                }
            } catch(ex) {}
        });

        sseSource.addEventListener('new_chat_message', function(e) {
            try {
                const data = JSON.parse(e.data);
                if (data.sender_type === 'admin' && chatOpen) {
                    appendMessage(data);
                    scrollToBottom();
                    // Mark as read
                    fetch('<?php echo e(route("support-chat.messages")); ?>', {
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    }).catch(() => {});
                }
            } catch(ex) {}
        });

        sseSource.addEventListener('admin_typing', function(e) {
            try {
                const data = JSON.parse(e.data);
                typingIndicator.style.display = data.typing ? 'flex' : 'none';
                if (data.typing) scrollToBottom();
            } catch(ex) {}
        });

        sseSource.addEventListener('notification_count', function(e) {
            try {
                const data = JSON.parse(e.data);
                if (typeof window.updateNotifBadgeFromSSE === 'function') {
                    window.updateNotifBadgeFromSSE(data.unread_count);
                }
            } catch(ex) {}
        });

        sseSource.addEventListener('new_notification', function(e) {
            try {
                const data = JSON.parse(e.data);
                if (typeof window.showNotificationToast === 'function') {
                    window.showNotificationToast(data.title, data.message, data.icon);
                }
                if (typeof window.loadUserNotifications === 'function') {
                    window.loadUserNotifications();
                }
            } catch(ex) {}
        });

        sseSource.addEventListener('reconnect', function() {
            sseSource.close();
            setTimeout(connectSSE, 2000);
        });

        sseSource.onerror = function() {
            sseSource.close();
            setTimeout(connectSSE, 5000);
        };
    }

    // Start SSE when page loads
    document.addEventListener('DOMContentLoaded', connectSSE);

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (sseSource) sseSource.close();
    });
})();
</script>
<?php endif; ?>
<?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/components/support_chat.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Support Chat — PetMarkt-PH Admin'); ?>

<?php $__env->startSection('content'); ?>
<style>
.sc-page { display: flex; height: calc(100vh - 70px); background: #f9fafb; }
.sc-sidebar { width: 320px; background: #fff; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; }
.sc-sidebar-header { padding: 20px; border-bottom: 1px solid #e5e7eb; }
.sc-sidebar-header h2 { margin: 0; font-size: 18px; font-weight: 700; color: #1f2937; }
.sc-sidebar-header p { margin: 4px 0 0; font-size: 12px; color: #9ca3af; }
.sc-conv-list { flex: 1; overflow-y: auto; }
.sc-conv-item {
    display: flex; align-items: center; gap: 12px; padding: 14px 20px;
    cursor: pointer; border-bottom: 1px solid #f3f4f6; transition: background 0.2s;
}
.sc-conv-item:hover, .sc-conv-item.active { background: #FFF4EC; }
.sc-conv-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg, #FF8C42, #ea580c);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 700; flex-shrink: 0;
}
.sc-conv-info { flex: 1; min-width: 0; }
.sc-conv-name { font-size: 14px; font-weight: 600; color: #1f2937; }
.sc-conv-preview { font-size: 12px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
.sc-conv-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
.sc-conv-time { font-size: 11px; color: #9ca3af; }
.sc-conv-unread {
    background: #ef4444; color: #fff; border-radius: 50%;
    width: 20px; height: 20px; font-size: 10px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}

/* Chat area */
.sc-chat { flex: 1; display: flex; flex-direction: column; }
.sc-chat-header {
    padding: 16px 24px; border-bottom: 1px solid #e5e7eb;
    background: #fff; display: flex; align-items: center; gap: 12px;
}
.sc-chat-header-name { font-size: 16px; font-weight: 700; color: #1f2937; }
.sc-chat-header-email { font-size: 12px; color: #9ca3af; }
.sc-chat-messages { flex: 1; overflow-y: auto; padding: 20px 24px; background: #fafaf9; }
.sc-empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #9ca3af; }
.sc-empty-state svg { width: 80px; height: 80px; margin-bottom: 16px; opacity: 0.3; }
.sc-empty-state p { font-size: 16px; font-weight: 600; }

/* Messages styling (reuse from user chat) */
.sc-msg { display: flex; margin-bottom: 10px; gap: 8px; animation: msgFadeIn 0.3s ease; }
@keyframes  msgFadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
.sc-msg.from-user { flex-direction: row; }
.sc-msg.from-admin { flex-direction: row-reverse; }
.sc-msg-bubble { max-width: 65%; padding: 10px 14px; border-radius: 16px; font-size: 13px; line-height: 1.5; word-wrap: break-word; }
.sc-msg.from-user .sc-msg-bubble { background: #fff; color: #1f2937; border: 1px solid #e5e7eb; border-bottom-left-radius: 4px; }
.sc-msg.from-admin .sc-msg-bubble { background: linear-gradient(135deg, #FF8C42, #ea580c); color: #fff; border-bottom-right-radius: 4px; }
.sc-msg-time { font-size: 10px; color: #9ca3af; margin-top: 4px; }
.sc-msg.from-admin .sc-msg-time { text-align: right; }
.sc-msg-image { max-width: 200px; border-radius: 10px; margin-top: 6px; cursor: pointer; }

/* Typing */
.sc-typing { display: flex; align-items: center; gap: 8px; padding: 8px 24px; font-size: 12px; color: #9ca3af; }
.sc-typing-dots { display: flex; gap: 3px; }
.sc-typing-dots span { width: 6px; height: 6px; border-radius: 50%; background: #9ca3af; animation: scTyping 1.4s infinite; }
.sc-typing-dots span:nth-child(2) { animation-delay: 0.2s; }
.sc-typing-dots span:nth-child(3) { animation-delay: 0.4s; }
@keyframes  scTyping { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-6px); } }

/* Canned replies */
.sc-canned-bar { padding: 8px 16px; border-top: 1px solid #f3f4f6; background: #fafaf9; display: flex; gap: 6px; flex-wrap: wrap; }
.sc-canned-btn {
    background: #fff; border: 1px solid #e5e7eb; border-radius: 16px;
    padding: 5px 12px; font-size: 11px; color: #374151; cursor: pointer; transition: all 0.2s;
}
.sc-canned-btn:hover { background: #FFF4EC; border-color: #ea580c; color: #ea580c; }

/* Input */
.sc-input-area {
    display: flex; align-items: center; gap: 8px;
    padding: 14px 20px; border-top: 1px solid #e5e7eb; background: #fff;
}
.sc-input {
    flex: 1; border: 1px solid #e5e7eb; border-radius: 20px;
    padding: 10px 16px; font-size: 13px; outline: none; transition: border-color 0.2s;
}
.sc-input:focus { border-color: #ea580c; }
.sc-send-btn {
    width: 40px; height: 40px; border-radius: 50%;
    background: linear-gradient(135deg, #FF8C42, #ea580c);
    color: #fff; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}
.sc-attach-btn { color: #9ca3af; cursor: pointer; display: flex; align-items: center; }
.sc-attach-btn:hover { color: #ea580c; }

@media (max-width: 768px) {
    .sc-sidebar { width: 100%; max-width: 280px; }
}
</style>

<div class="sc-page">
    
    <div class="sc-sidebar">
        <div class="sc-sidebar-header">
            <h2>💬 Support Chat</h2>
            <p id="scConvCount">Loading conversations...</p>
        </div>
        <div class="sc-conv-list" id="scConvList">
            <div style="text-align:center; padding:40px; color:#9ca3af;">Loading...</div>
        </div>
    </div>

    
    <div class="sc-chat" id="scChatArea">
        <div class="sc-empty-state" id="scEmptyState">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12z"/></svg>
            <p>Select a conversation to start chatting</p>
        </div>

        <div id="scChatContent" style="display:none; flex:1; flex-direction:column; height:100%;">
            <div class="sc-chat-header">
                <div class="sc-conv-avatar" id="scChatAvatar">?</div>
                <div>
                    <div class="sc-chat-header-name" id="scChatName">—</div>
                    <div class="sc-chat-header-email" id="scChatEmail">—</div>
                </div>
            </div>

            <div class="sc-chat-messages" id="scChatMessages"></div>

            <div class="sc-typing" id="scTyping" style="display:none;">
                <div class="sc-typing-dots"><span></span><span></span><span></span></div>
                <span>Customer is typing...</span>
            </div>

            <div class="sc-canned-bar">
                <button class="sc-canned-btn" data-msg="Your order is being processed and will ship soon! 📦">📦 Order processing</button>
                <button class="sc-canned-btn" data-msg="Your refund has been approved and will be processed within 3-5 business days.">💰 Refund approved</button>
                <button class="sc-canned-btn" data-msg="Thank you for reaching out! Is there anything else I can help you with?">🙏 Anything else?</button>
                <button class="sc-canned-btn" data-msg="Your order has been shipped! You can track it from your orders page.">🚚 Order shipped</button>
                <button class="sc-canned-btn" data-msg="I apologize for the inconvenience. Let me look into this for you right away.">😔 Apology</button>
            </div>

            <div class="sc-input-area">
                <label class="sc-attach-btn" title="Attach Image">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                    <input type="file" id="scImageInput" accept="image/*" style="display:none;">
                </label>
                <input type="text" class="sc-input" id="scInput" placeholder="Type a reply..." maxlength="2000" autocomplete="off">
                <button type="button" class="sc-send-btn" id="scSendBtn" title="Send">
                    <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    let activeUserId = null;
    let pollTimer = null;

    function fetchJSON(url, options) {
        options = options || {};
        return fetch(url, Object.assign({
            credentials: 'same-origin',
            headers: Object.assign({
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }, options.headers || {}),
        }, options));
    }

    function escapeHtml(s) {
        if (!s) return '';
        const d = document.createElement('div'); d.textContent = s; return d.innerHTML;
    }

    function formatTime(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function timeAgo(dateStr) {
        const now = new Date(), d = new Date(dateStr);
        const diff = Math.floor((now - d) / 1000);
        if (diff < 60) return 'now';
        if (diff < 3600) return Math.floor(diff / 60) + 'm';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h';
        return Math.floor(diff / 86400) + 'd';
    }

    // Load conversation list
    function loadConversations() {
        fetchJSON('<?php echo e(route("admin.support-chat.conversations")); ?>')
            .then(r => r.json())
            .then(data => {
                const list = document.getElementById('scConvList');
                const count = document.getElementById('scConvCount');

                if (!data.conversations || data.conversations.length === 0) {
                    list.innerHTML = '<div style="text-align:center; padding:40px; color:#9ca3af; font-size:14px;">No conversations yet</div>';
                    count.textContent = '0 conversations';
                    return;
                }

                count.textContent = data.conversations.length + ' conversation' + (data.conversations.length !== 1 ? 's' : '') + (data.total_unread > 0 ? ' · ' + data.total_unread + ' unread' : '');

                list.innerHTML = data.conversations.map(c => {
                    const initials = (c.user_name || '?').split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
                    return '<div class="sc-conv-item' + (activeUserId == c.user_id ? ' active' : '') + '" data-user-id="' + c.user_id + '" data-user-name="' + escapeHtml(c.user_name) + '" data-user-email="' + escapeHtml(c.user_email) + '">' +
                        '<div class="sc-conv-avatar">' + initials + '</div>' +
                        '<div class="sc-conv-info">' +
                            '<div class="sc-conv-name">' + escapeHtml(c.user_name) + '</div>' +
                            '<div class="sc-conv-preview">' + escapeHtml(c.last_message || 'No messages') + '</div>' +
                        '</div>' +
                        '<div class="sc-conv-meta">' +
                            '<span class="sc-conv-time">' + timeAgo(c.last_message_at) + '</span>' +
                            (c.unread_count > 0 ? '<span class="sc-conv-unread">' + c.unread_count + '</span>' : '') +
                        '</div>' +
                    '</div>';
                }).join('');

                // Bind click events
                list.querySelectorAll('.sc-conv-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const uid = this.dataset.userId;
                        const name = this.dataset.userName;
                        const email = this.dataset.userEmail;
                        openChat(uid, name, email);
                    });
                });
            })
            .catch(() => {});
    }

    // Open a chat
    function openChat(userId, name, email) {
        activeUserId = userId;

        document.getElementById('scEmptyState').style.display = 'none';
        const content = document.getElementById('scChatContent');
        content.style.display = 'flex';

        const initials = (name || '?').split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
        document.getElementById('scChatAvatar').textContent = initials;
        document.getElementById('scChatName').textContent = name;
        document.getElementById('scChatEmail').textContent = email;

        // Highlight active conversation
        document.querySelectorAll('.sc-conv-item').forEach(i => i.classList.remove('active'));
        document.querySelector('.sc-conv-item[data-user-id="' + userId + '"]')?.classList.add('active');

        loadChatMessages(userId);
        startPolling(userId);
    }

    // Load messages for a user
    function loadChatMessages(userId) {
        fetchJSON('/admin/api/support-chat/messages/' + userId)
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('scChatMessages');
                if (!data.messages || data.messages.length === 0) {
                    container.innerHTML = '<div style="text-align:center; padding:40px; color:#9ca3af;">No messages yet</div>';
                    return;
                }

                container.innerHTML = data.messages.map(m => {
                    const isAdmin = m.sender_type === 'admin';
                    let content = '';
                    if (m.message) content += '<div>' + escapeHtml(m.message) + '</div>';
                    if (m.image_path) content += '<img src="/storage/' + m.image_path + '" class="sc-msg-image" onclick="window.open(this.src)" alt="Image">';
                    content += '<div class="sc-msg-time">' + formatTime(m.created_at) + '</div>';
                    return '<div class="sc-msg ' + (isAdmin ? 'from-admin' : 'from-user') + '"><div class="sc-msg-bubble">' + content + '</div></div>';
                }).join('');

                container.scrollTop = container.scrollHeight;

                // Update typing
                document.getElementById('scTyping').style.display = data.is_typing ? 'flex' : 'none';

                // Refresh conversation list to clear unread badges
                loadConversations();
            })
            .catch(() => {});
    }

    // Polling for active chat
    function startPolling(userId) {
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = setInterval(() => {
            if (activeUserId === userId) loadChatMessages(userId);
        }, 3000);
    }

    // Send reply
    function sendReply() {
        if (!activeUserId) return;
        const inputEl = document.getElementById('scInput');
        const imageInput = document.getElementById('scImageInput');
        const text = inputEl.value.trim();
        const file = imageInput.files[0];

        if (!text && !file) return;

        const formData = new FormData();
        if (text) formData.append('message', text);
        if (file) formData.append('image', file);

        inputEl.value = '';
        imageInput.value = '';

        fetch('/admin/api/support-chat/reply/' + activeUserId, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin',
            body: formData,
        })
        .then(r => r.json())
        .then(() => {
            loadChatMessages(activeUserId);
            loadConversations();
        })
        .catch(() => {});
    }

    document.getElementById('scSendBtn').addEventListener('click', sendReply);
    document.getElementById('scInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendReply();
        }
        // Send typing indicator
        fetch('/admin/api/support-chat/typing/' + activeUserId, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            credentials: 'same-origin',
        }).catch(() => {});
    });

    // Canned replies
    document.querySelectorAll('.sc-canned-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('scInput').value = this.dataset.msg;
            sendReply();
        });
    });

    // Initial load
    document.addEventListener('DOMContentLoaded', function() {
        loadConversations();
        setInterval(loadConversations, 10000);
    });
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\John Carry\.gemini\antigravity\scratch\petanimixon\resources\views/admin_support_chat.blade.php ENDPATH**/ ?>
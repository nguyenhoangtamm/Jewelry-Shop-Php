@extends('user.layout')

@section('title', 'Chatbox AI - Tư vấn trang sức')

@push('styles')
<style>
    .chatbox-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        background: var(--white);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(26, 35, 126, 0.1);
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .chatbox-header {
        background: linear-gradient(135deg, var(--galaxy-blue) 0%, var(--galaxy-blue-light) 100%);
        color: white;
        padding: 20px;
        border-radius: 15px 15px 0 0;
        text-align: center;
        margin: -20px -20px 20px -20px;
    }

    .chatbox-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .chatbox-header p {
        margin: 5px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .chat-messages {
        height: 500px;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
    }

    .message.user {
        justify-content: flex-end;
    }

    .message.bot {
        justify-content: flex-start;
    }

    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        margin: 0 10px;
        flex-shrink: 0;
    }

    .message.user .message-avatar {
        background: var(--galaxy-blue);
        order: 2;
    }

    .message.bot .message-avatar {
        background: var(--gold-accent);
        color: var(--galaxy-blue);
    }

    .message-content {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 18px;
        word-wrap: break-word;
    }

    .message.user .message-content {
        background: var(--galaxy-blue);
        color: white;
        border-bottom-right-radius: 5px;
    }

    .message.bot .message-content {
        background: white;
        color: var(--text-dark);
        border: 1px solid #e9ecef;
        border-bottom-left-radius: 5px;
    }

    .message-time {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
        text-align: right;
    }

    .message.bot .message-time {
        text-align: left;
    }

    .chat-input {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .chat-input input {
        flex: 1;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    .chat-input input:focus {
        border-color: var(--galaxy-blue);
    }

    .chat-input button {
        background: var(--galaxy-blue);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .chat-input button:hover {
        background: var(--galaxy-blue-dark);
    }

    .chat-input button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    .typing-indicator {
        display: none;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .typing-indicator.show {
        display: flex;
    }

    .typing-dots {
        display: flex;
        gap: 4px;
    }

    .typing-dots span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--galaxy-blue);
        animation: typing 1.4s infinite;
    }

    .typing-dots span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dots span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {

        0%,
        60%,
        100% {
            transform: translateY(0);
        }

        30% {
            transform: translateY(-10px);
        }
    }

    .welcome-message {
        text-align: center;
        color: #666;
        padding: 40px 20px;
        font-style: italic;
    }

    .suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
        justify-content: center;
    }

    .suggestion-chip {
        background: var(--light-gray);
        border: 1px solid var(--border-light);
        padding: 8px 16px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .suggestion-chip:hover {
        background: var(--galaxy-blue);
        color: white;
        border-color: var(--galaxy-blue);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chatbox-container {
            margin: 10px;
            padding: 15px;
        }

        .message-content {
            max-width: 85%;
        }

        .chat-messages {
            height: 400px;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="chatbox-container">
        <div class="chatbox-header">
            <h2><i class="fa fa-robot"></i> Trợ lý AI Trang sức</h2>
            <p>Tư vấn và hỗ trợ 24/7 về trang sức, kim cương và dịch vụ</p>
            <div style="margin-top: 10px; padding: 5px 10px; background: rgba(255,255,255,0.2); border-radius: 15px; font-size: 12px;">
                <i class="fa {{ $aiStatus['gemini_enabled'] ? 'fa-check-circle' : 'fa-cog' }}"></i>
                Powered by: {{ $aiStatus['ai_model'] }}
            </div>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="welcome-message">
                <div class="message bot">
                    <div class="message-avatar">
                        <i class="fa fa-robot"></i>
                    </div>
                    <div class="message-content">
                        <div>Xin chào! Tôi là trợ lý AI của Jewelry Shop. Tôi có thể giúp bạn:</div>
                        <ul style="margin: 10px 0; padding-left: 20px;">
                            <li>Tư vấn về trang sức phù hợp</li>
                            <li>Thông tin về giá cả và chất liệu</li>
                            <li>Hướng dẫn chọn mua sản phẩm</li>
                            <li>Chính sách bảo hành và dịch vụ</li>
                        </ul>
                        <div>Hãy đặt câu hỏi hoặc chọn chủ đề bên dưới!</div>
                        <div class="suggestions">
                            <span class="suggestion-chip" onclick="sendSuggestion('Tôi muốn mua nhẫn cưới')">Nhẫn cưới</span>
                            <span class="suggestion-chip" onclick="sendSuggestion('Dây chuyền kim cương giá bao nhiêu?')">Giá dây chuyền</span>
                            <span class="suggestion-chip" onclick="sendSuggestion('Tư vấn vòng tay cho nữ')">Vòng tay nữ</span>
                            <span class="suggestion-chip" onclick="sendSuggestion('Chính sách bảo hành')">Bảo hành</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="typing-indicator" id="typingIndicator">
            <div class="message-avatar" style="background: var(--gold-accent); color: var(--galaxy-blue);">
                <i class="fa fa-robot"></i>
            </div>
            <div class="message-content" style="background: white; border: 1px solid #e9ecef;">
                Đang nhập...
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>

        <form class="chat-input" id="chatForm">
            @csrf
            <input type="text" id="messageInput" placeholder="Nhập câu hỏi của bạn..." required>
            <button type="submit" id="sendButton">
                <i class="fa fa-paper-plane"></i>
                Gửi
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatForm = document.getElementById('chatForm');
        const messageInput = document.getElementById('messageInput');
        const chatMessages = document.getElementById('chatMessages');
        const sendButton = document.getElementById('sendButton');
        const typingIndicator = document.getElementById('typingIndicator');

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            sendMessage();
        });

        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });

        function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) return;

            // Disable input and button
            messageInput.disabled = true;
            sendButton.disabled = true;

            // Add user message to chat
            addMessage(message, 'user');

            // Clear input
            messageInput.value = '';

            // Show typing indicator
            showTypingIndicator();

            // Send message to server
            fetch('{{ route("user.chatbox.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Hide typing indicator
                    hideTypingIndicator();

                    if (data.success) {
                        // Add bot response with delay for natural feel
                        setTimeout(() => {
                            addMessage(data.bot_response, 'bot');
                        }, 500);
                    } else {
                        addMessage('Xin lỗi, có lỗi xảy ra. Vui lòng thử lại.', 'bot');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideTypingIndicator();
                    addMessage('Xin lỗi, không thể kết nối. Vui lòng thử lại.', 'bot');
                })
                .finally(() => {
                    // Re-enable input and button
                    messageInput.disabled = false;
                    sendButton.disabled = false;
                    messageInput.focus();
                });
        }

        function addMessage(content, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`;

            const avatar = document.createElement('div');
            avatar.className = 'message-avatar';
            avatar.innerHTML = sender === 'user' ? getFirstLetter() : '<i class="fa fa-robot"></i>';

            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            messageContent.innerHTML = content;

            const messageTime = document.createElement('div');
            messageTime.className = 'message-time';
            messageTime.textContent = new Date().toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });

            messageDiv.appendChild(avatar);
            messageContent.appendChild(messageTime);
            messageDiv.appendChild(messageContent);

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function showTypingIndicator() {
            typingIndicator.classList.add('show');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function hideTypingIndicator() {
            typingIndicator.classList.remove('show');
        }

        function getFirstLetter() {
            @if(Auth::check())
            const name = '{{ Auth::user()->username ?? Auth::user()->fullname ?? Auth::user()->email }}';
            return name.charAt(0).toUpperCase();
            @else
            return 'U';
            @endif
        }

        // Focus on input when page loads
        messageInput.focus();
    });

    // Function for suggestion chips
    function sendSuggestion(message) {
        document.getElementById('messageInput').value = message;
        document.getElementById('chatForm').dispatchEvent(new Event('submit'));
    }
</script>
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="chatbot-container" wire:ignore>
    <button class="chatbot-button pulse-robot" onclick="toggleChatbot()">
        <i class="fas fa-robot fa-lg"></i>
    </button>
    
    
    

    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">Chat Bot</div>
        <div class="chatbot-body" id="chatbotBody">
            <div class="chat-row bot">
                <div class="chat-message bot">Xin chào! Tôi là Chat Bot. Bạn cần giúp gì?</div>
            </div>
        </div>
        <div class="chatbot-footer">
            <input type="text" id="chatbotInput" placeholder="Nhập tin nhắn..." onkeypress="if(event.keyCode==13) sendMessage()">
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>
</div>

<style>

@keyframes pulse-robot {
    0% {
        transform: scale(1);
        background-color: #4CAF50;
        box-shadow: 0 0 0px rgba(76, 175, 80, 0.6);
    }
    25% {
        transform: scale(1.1);
        background-color: #43a047;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
    }
    50% {
        transform: scale(1);
        background-color: #388e3c;
        box-shadow: 0 0 20px rgba(56, 142, 60, 0.9);
    }
    75% {
        transform: scale(1.1);
        background-color: #43a047;
        box-shadow: 0 0 10px rgba(76, 175, 80, 0.7);
    }
    100% {
        transform: scale(1);
        background-color: #4CAF50;
        box-shadow: 0 0 0px rgba(76, 175, 80, 0.6);
    }
}

.pulse-robot {
    animation: pulse-robot 2s infinite;
    transition: all 0.3s ease-in-out;
}

.shake {
    animation: shake 0.8s infinite;
}

    .chatbot-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .chatbot-button {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        font-size: 24px;
    }

    .chatbot-window {
    display: none;
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 320px; /* 👉 tăng thêm một chút */
    height: 400px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    box-sizing: border-box; /* 👈 quan trọng */
}
    

    .chatbot-header {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        text-align: center;
        font-weight: bold;
    }

    .chatbot-body {
        padding: 10px;
        height: 300px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .chat-row {
        display: flex;
        width: 100%;
    }

    /* Bot bên trái */
    .chat-row.bot {
        justify-content: flex-start;
    }

    /* User bên phải */
    .chat-row.user {
        justify-content: flex-end;
    }

    .chat-message {
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 14px;
        max-width: 75%;
        word-wrap: break-word;
    }

    /* Bot màu xanh lá */
    .chat-message.bot {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
        text-align: left;
    }

    /* Người dùng màu xanh dương */
    .chat-message.user {
        background-color: #e3f2fd;
        color: #1565c0;
        border: 1px solid #90caf9;
        text-align: left;
        border-radius: 12px;
    }

    .chatbot-footer {
        border-top: 1px solid #ddd;
        padding: 10px;
        display: flex;
        align-items: center;
    }

    .chatbot-footer input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-right: 10px;
    }

    .chatbot-footer button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<script>
    window.toggleChatbot = function() {
        const chatbotWindow = document.getElementById('chatbotWindow');
        chatbotWindow.style.display = chatbotWindow.style.display === 'block' ? 'none' : 'block';
    };

    window.sendMessage = function() {
        const input = document.getElementById('chatbotInput');
        const chatbotBody = document.getElementById('chatbotBody');
        const message = input.value.trim();

        if (message === '') return;

        // Tạo chat-row cho tin nhắn người dùng
        const userRow = document.createElement('div');
        userRow.className = 'chat-row user';

        const userMessage = document.createElement('div');
        userMessage.className = 'chat-message user';
        userMessage.textContent = message;
        userRow.appendChild(userMessage);

        chatbotBody.appendChild(userRow);

        input.value = '';
        chatbotBody.scrollTop = chatbotBody.scrollHeight;

        fetch('/api/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ message: message }),
        })
        .then(response => response.json())
        .then(data => {
            // Tạo chat-row cho tin nhắn bot
            const botRow = document.createElement('div');
            botRow.className = 'chat-row bot';

            const botMessage = document.createElement('div');
            botMessage.className = 'chat-message bot';
            botMessage.textContent = data.reply || 'Tôi không hiểu. Bạn có thể hỏi lại không?';
            botRow.appendChild(botMessage);

            chatbotBody.appendChild(botRow);
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        })
        .catch(error => {
            console.error('Error:', error);
            const botRow = document.createElement('div');
            botRow.className = 'chat-row bot';

            const botMessage = document.createElement('div');
            botMessage.className = 'chat-message bot';
            botMessage.textContent = 'Có lỗi xảy ra. Vui lòng thử lại!';
            botRow.appendChild(botMessage);

            chatbotBody.appendChild(botRow);
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        });
    };

    document.addEventListener('livewire:navigated', () => {
        window.toggleChatbot = function() {
            const chatbotWindow = document.getElementById('chatbotWindow');
            chatbotWindow.style.display = chatbotWindow.style.display === 'block' ? 'none' : 'block';
        };

        window.sendMessage = function() {
            const input = document.getElementById('chatbotInput');
            const chatbotBody = document.getElementById('chatbotBody');
            const message = input.value.trim();

            if (message === '') return;

            // Tạo chat-row cho tin nhắn người dùng
            const userRow = document.createElement('div');
            userRow.className = 'chat-row user';

            const userMessage = document.createElement('div');
            userMessage.className = 'chat-message user';
            userMessage.textContent = message;
            userRow.appendChild(userMessage);

            chatbotBody.appendChild(userRow);

            input.value = '';
            chatbotBody.scrollTop = chatbotBody.scrollHeight;

            fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message: message }),
            })
            .then(response => response.json())
            .then(data => {
                // Tạo chat-row cho tin nhắn bot
                const botRow = document.createElement('div');
                botRow.className = 'chat-row bot';

                const botMessage = document.createElement('div');
                botMessage.className = 'chat-message bot';
                botMessage.textContent = data.reply || 'Tôi không hiểu. Bạn có thể hỏi lại không?';
                botRow.appendChild(botMessage);

                chatbotBody.appendChild(botRow);
                chatbotBody.scrollTop = chatbotBody.scrollHeight;
            })
            .catch(error => {
                console.error('Error:', error);
                const botRow = document.createElement('div');
                botRow.className = 'chat-row bot';

                const botMessage = document.createElement('div');
                botMessage.className = 'chat-message bot';
                botMessage.textContent = 'Có lỗi xảy ra. Vui lòng thử lại!';
                botRow.appendChild(botMessage);

                chatbotBody.appendChild(botRow);
                chatbotBody.scrollTop = chatbotBody.scrollHeight;
            });
        };
    });
</script>
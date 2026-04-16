<div id="alert">
     <span id="closebtn">&otimes;</span>
 </div>
 <div class="copy-right">
     <p><a href="index.php">HoaSang Store</a> - All rights reserved © 5 - Designed by
         <span style="color: #eee; font-weight: bold">HoaSang</span>
     </p>
 </div>

<div class="chat-widget" id="chatWidget" style="display: none;">
    <div class="chat-header">
        <div class="avatar"></div>
        <div class="header-text"><strong>Tư vấn Chatbot</strong><br>Tôi có thể giúp gì cho bạn?</div>
        <button class="close-chat" onclick="closeChat()">×</button>
    </div>
    <div class="chat-body" id="chats"></div>
    <div class="chat-input">
        <input type="text" id="myMessage" placeholder="Nhập tin nhắn..." onkeydown="if(event.key === 'Enter') sendMessage()">
        <button class="send-btn" onclick="sendMessage()">📨</button>
    </div>
</div>
<div class="chat-bubble" onclick="openChat()">
    <img src="https://cdn-icons-png.flaticon.com/512/1827/1827392.png" alt="Chat Icon">
    <span>Cần hỗ trợ?</span>
</div>

<script>
    function openChat() { document.getElementById("chatWidget").style.display = "block"; document.querySelector(".chat-bubble").style.display = "none"; }
    function closeChat() { document.getElementById("chatWidget").style.display = "none"; document.querySelector(".chat-bubble").style.display = "block"; }
    
    $(document).ready(function() {
        if ($("#chats").children().length === 0) {
            $("#chats").append(`<div class="received-chats"><div class="received-msg"><div class="received-msg-inbox"><p class="multi-msg">Chào bạn, tôi là AI của HoaSang Store. Tôi có thể giúp gì cho bạn?</p></div></div></div>`);
        }
    });

    function sendMessage() {
        let message = $("#myMessage").val();
        if (!message.trim()) return;
        $("#chats").append(`<div class="outgoing-chats"><div class="outgoing-msg"><p class="multi-msg" style="color: white !important;">${message}</p></div></div>`);
        $("#myMessage").val('');
        
        fetch('chatbot_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: message })
        })
        .then(res => res.json())
        .then(data => {
            $("#chats").append(`<div class="received-chats"><div class="received-msg"><div class="received-msg-inbox"><p class="multi-msg">${data.reply}</p></div></div></div>`);
            document.getElementById('chats').scrollTop = document.getElementById('chats').scrollHeight;
        });
    }
</script>

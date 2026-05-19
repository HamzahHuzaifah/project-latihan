  <footer id="footer" class="footer position-relative light-background">

    <div class="container">
      <div class="copyright text-center ">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">iPortfolio</strong> <span>All Rights Reserved</span></p>
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> | <a href="https://bootstrapmade.com/tools/">DevTools</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.umd.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Chatbot UI -->
  <style>
    #chatbot-box {
      position: fixed;
      bottom: 80px;
      right: 20px;
      width: 350px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      display: none;
      z-index: 1000;
      font-family: inherit;
    }
    #chatbot-header {
      background: #149ddd; /* Warna tema iPortfolio */
      color: #fff;
      padding: 15px;
      border-radius: 10px 10px 0 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    #chatbot-header h5 { margin: 0; font-size: 16px; color: white; }
    #close-chat { cursor: pointer; }
    #chatbot-messages {
      height: 300px;
      padding: 15px;
      overflow-y: auto;
      background: rgb(240, 240, 240);
    }
    .msg-bubble { padding: 10px 15px; border-radius: 15px; margin-bottom: 10px; font-size: 14px; max-width: 80%; word-wrap: break-word; }
    .user-msg { background: #149ddd; color: #fff; margin-left: auto; border-bottom-right-radius: 0; }
    .bot-msg { background: #e9ecef; color: #333; margin-right: auto; border-bottom-left-radius: 0; }
    #chatbot-input-area {
      display: flex;
      padding: 10px;
      border-top: 1px solid #ddd;
      background: #fff;
      border-radius: 0 0 10px 10px;
    }
    #chat-input { flex: 1; border: 1px solid #ddd; border-radius: 20px; padding: 5px 15px; outline: none; }
    #send-cmd { background: #149ddd; color: #fff; border: none; border-radius: 50%; width: 35px; height: 35px; margin-left: 10px; cursor: pointer; display:flex; align-items:center; justify-content:center;}
    
    #chatbot-toggle {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      background: #149ddd;
      color: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      z-index: 1000;
    }
  </style>

  <div id="chatbot-toggle" title="Chat dengan AI"><i class="bi bi-chat-dots-fill"></i></div>

  <div id="chatbot-box">
    <div id="chatbot-header">
      <h5><i class="bi bi-robot"></i> Asisten AI (Gemini)</h5>
      <i class="bi bi-x-lg" id="close-chat"></i>
    </div>
    <div id="chatbot-messages">
      <div class="msg-bubble bot-msg">Halo! Ada yang bisa saya bantu terkait website ini?</div>
    </div>
    <div id="chatbot-input-area">
      <input type="text" id="chat-input" placeholder="Tuliskan pesan..." autocomplete="off">
      <button id="send-cmd"><i class="bi bi-send-fill" style="margin-left:-2px"></i></button>
    </div>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const chatBox = document.getElementById('chatbot-box');
    const closeBtn = document.getElementById('close-chat');
    const sendBtn = document.getElementById('send-cmd');
    const chatInput = document.getElementById('chat-input');
    const messagesArea = document.getElementById('chatbot-messages');

    toggleBtn.addEventListener('click', () => {
      chatBox.style.display = chatBox.style.display === 'none' || chatBox.style.display === '' ? 'block' : 'none';
      if(chatBox.style.display === 'block') chatInput.focus();
    });

    closeBtn.addEventListener('click', () => {
      chatBox.style.display = 'none';
    });

    function appendMessage(text, isUser) {
      const div = document.createElement('div');
      div.className = 'msg-bubble ' + (isUser ? 'user-msg' : 'bot-msg');
      div.textContent = text; 
      messagesArea.appendChild(div);
      messagesArea.scrollTop = messagesArea.scrollHeight;
    }

    sendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', function(e) {
      if(e.key === 'Enter') sendMessage();
    });

    function sendMessage() {
      const msg = chatInput.value.trim();
      if(!msg) return;

      appendMessage(msg, true);
      chatInput.value = '';

      const loadingDiv = document.createElement('div');
      loadingDiv.className = 'msg-bubble bot-msg';
      loadingDiv.id = 'chat-loading';
      loadingDiv.innerHTML = '<em>Mengetik...</em>';
      messagesArea.appendChild(loadingDiv);
      messagesArea.scrollTop = messagesArea.scrollHeight;

      fetch('<?= base_url("chat") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        // x-www-form-urlencoded untuk CodeIgniter request->getPost()
        body: 'message=' + encodeURIComponent(msg)
      })
      .then(res => res.json())
      .then(data => {
        document.getElementById('chat-loading').remove();
        if(data.reply) {
          appendMessage(data.reply, false);
        } else if (data.error) {
          appendMessage("Error: " + data.error, false);
        }
      })
      .catch(err => {
        document.getElementById('chat-loading').remove();
        appendMessage("Gagal terhubung ke server.", false);
      });
    }
  });
  </script>
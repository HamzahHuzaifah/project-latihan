<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'MyBlog' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    
    <!-- Bootstrap CSS (Keep for compatibility with previous components, but Tailwind takes priority for layout) -->
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>" />

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Swup CSS for Page Transitions -->
    <style>
        /* Transition animations */
        .transition-fade {
            transition: 0.4s;
            opacity: 1;
        }
        html.is-animating .transition-fade {
            opacity: 0;
            transform: translateY(10px);
        }
        
        // Glassmorphism utility
        .glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        html.dark .glass {
            background: rgba(30, 30, 30, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Quill Editor Dark Mode fixes */
        html.dark .ql-toolbar { background: #334155; border-color: #475569; }
        html.dark .ql-container { border-color: #475569; }
        html.dark .ql-stroke { stroke: #e2e8f0; }
        html.dark .ql-fill { fill: #e2e8f0; }
        html.dark .ql-picker { color: #e2e8f0; }
        
        /* Fix text visibility in dark mode for generated content */
        html.dark .ql-editor p, html.dark .post-content p { color: #f8fafc; } 
        html.dark .ql-editor h1, html.dark .ql-editor h2, html.dark .ql-editor h3,
        html.dark .post-content h1, html.dark .post-content h2, html.dark .post-content h3 { color: #f8fafc; }
        html.dark .ql-editor *, html.dark .post-content * { color: inherit; }
        
        /* Responsive Video for Quill Editor */
        .ql-editor iframe, .post-content iframe {
            width: 100% !important;
            height: auto !important;
            aspect-ratio: 16/9;
            border-radius: 0.5rem;
        }
    </style>
    
    <!-- Quill CSS (Loaded globally for editor pages) -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-900 transition-colors duration-300 dark:bg-slate-900 dark:text-slate-100">

    <!-- Swup main container -->
    <main id="swup" class="transition-fade">
        <?= $this->include('layouts/navbar') ?>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="mt-20 py-8 border-t border-slate-200 dark:border-slate-800 text-center text-slate-500 text-sm">
        <div class="container mx-auto">
            &copy; <?= Date('Y') ?> MyBlog. Built with CodeIgniter & Tailwind CSS.
        </div>
    </footer>

    <!-- Category Edit Modal -->
    <div id="category-edit-dialog" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900/75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal()"></div>
            <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl">
                <div class="flex flex-col">
                    <h3 class="text-xl font-bold leading-6 text-slate-900 dark:text-white mb-4">Edit Nama Kategori</h3>
                    <input type="text" id="edit-category-input" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button type="button" onclick="closeModal()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-slate-300 dark:border-slate-600 px-6 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700">Batal</button>
                    <button type="button" onclick="submitEditCategory()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Delete Modal -->
    <div id="category-delete-dialog" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900/75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal()"></div>
            <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl">
                <div class="flex flex-col items-center justify-center">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full dark:bg-red-900/30 mb-4">
                        <span class="text-red-600 dark:text-red-400 text-2xl">⚠️</span>
                    </div>
                    <h3 class="text-xl font-bold leading-6 text-slate-900 dark:text-white mb-2">Hapus Kategori?</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 text-center">Yakin ingin menghapus kategori "<span id="delete-category-name" class="font-bold"></span>"?</p>
                </div>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:justify-center">
                    <button type="button" onclick="closeModal()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-slate-300 dark:border-slate-600 px-6 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700">Batal</button>
                    <button type="button" onclick="submitDeleteCategory()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent px-6 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Add Modal -->
    <div id="category-add-dialog" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900/75 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal()"></div>
            <div class="relative inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-800 shadow-xl rounded-2xl">
                <div class="flex flex-col">
                    <h3 class="text-xl font-bold leading-6 text-slate-900 dark:text-white mb-4">Tambah Kategori Baru</h3>
                    <input type="text" id="add-category-input" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" placeholder="Ketik nama kategori baru disini...">
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button type="button" onclick="closeModal()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-slate-300 dark:border-slate-600 px-6 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700">Batal</button>
                    <button type="button" onclick="submitAddCategory()" class="w-full sm:w-auto inline-flex justify-center items-center rounded-xl border border-transparent px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Global Chatbot FAB & Window -->
    <div id="global-chat-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <!-- Chat Window (Hidden by default) -->
        <div id="global-chat-window" class="hidden mb-4 w-80 sm:w-96 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col transition-all transform origin-bottom-right scale-95 opacity-0">
            <!-- Header -->
            <div class="bg-indigo-600 px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <span class="text-xl">🤖</span>
                    <div>
                        <h4 class="text-white font-bold text-sm">MyBlog AI</h4>
                        <p class="text-indigo-200 text-xs">Tanya seputar website ini</p>
                    </div>
                </div>
                <button onclick="toggleGlobalChat()" class="text-white hover:text-indigo-200 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Chat History -->
            <div id="global-chat-history" class="p-4 h-80 overflow-y-auto space-y-3 bg-slate-50 dark:bg-slate-800 text-sm">
                <div class="flex justify-start">
                    <div class="bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100 dark:border-slate-600">
                        Halo! 👋 Saya asisten AI MyBlog. Ada yang bisa saya bantu?
                    </div>
                </div>
            </div>

            <!-- Chat Input Form -->
            <div class="p-3 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700">
                <form id="global-chat-form" class="relative flex items-center">
                    <input type="text" id="global-chat-input" class="w-full pl-4 pr-10 py-2 bg-slate-100 dark:bg-slate-800 border-transparent rounded-full text-sm focus:border-indigo-500 focus:bg-white dark:focus:bg-slate-700 focus:ring-0 text-slate-900 dark:text-white" placeholder="Ketik pesan Anda...">
                    <button type="submit" id="global-chat-submit" class="absolute right-2 p-1.5 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 disabled:opacity-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- FAB Button -->
        <button onclick="toggleGlobalChat()" id="global-chat-fab" class="bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-full shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </button>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Swup JS -->
    <script src="https://unpkg.com/swup@4"></script>
    
    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Initialize Swup
        const swup = new Swup();
        
        // Re-init scripts after Swup page transition
        swup.hooks.on('page:view', () => {
            AOS.init();
            initDarkMode();
            initLikeBtn();
            initQuill();
            initGlobalChat();
        });

        function initDarkMode() {
            const toggleBtn = document.getElementById('darkModeToggle');
            const html = document.documentElement;
            
            if (localStorage.getItem('darkMode') === 'enabled') {
                html.classList.add('dark');
                if(toggleBtn) toggleBtn.textContent = '☀️';
            } else {
                html.classList.remove('dark');
                if(toggleBtn) toggleBtn.textContent = '🌙';
            }

            if(toggleBtn) {
                const newBtn = toggleBtn.cloneNode(true);
                toggleBtn.parentNode.replaceChild(newBtn, toggleBtn);
                
                newBtn.addEventListener('click', () => {
                    html.classList.toggle('dark');
                    if (html.classList.contains('dark')) {
                        localStorage.setItem('darkMode', 'enabled');
                        newBtn.textContent = '☀️';
                    } else {
                        localStorage.setItem('darkMode', 'disabled');
                        newBtn.textContent = '🌙';
                    }
                });
            }
        }
        
        function initLikeBtn() {
            const likeBtn = document.getElementById('likeBtn');
            if (likeBtn) {
                likeBtn.addEventListener('click', function() {
                    const postId = this.dataset.id;
                    const btn = this;
                    btn.disabled = true;
                    
                    fetch('<?= base_url('post/like/') ?>' + postId, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            document.getElementById('likeCount').innerText = data.likes;
                            btn.classList.replace('btn-outline-danger', 'btn-danger');
                        }
                    })
                    .finally(() => {
                        btn.disabled = false;
                    });
                });
            }
        }

        function initQuill() {
            const editorContainer = document.getElementById('editor-container');
            if (editorContainer) {
                if (editorContainer.classList.contains('ql-container')) {
                    return;
                }
                
                const quill = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: {
                        toolbar: {
                            container: [
                                [{ 'header': [1, 2, 3, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'script': 'sub'}, { 'script': 'super' }],
                                [{ 'indent': '-1'}, { 'indent': '+1' }],
                                [{ 'align': [] }],
                                ['link', 'image', 'video'],
                                ['clean']
                            ],
                            handlers: {
                                image: function() {
                                    const input = document.createElement('input');
                                    input.setAttribute('type', 'file');
                                    input.setAttribute('accept', 'image/*');
                                    input.click();

                                    input.onchange = async () => {
                                        const file = input.files[0];
                                        if (/^image\//.test(file.type)) {
                                            const formData = new FormData();
                                            formData.append('image', file);
                                            try {
                                                const response = await fetch('<?= base_url('admin/post/upload-image') ?>', {
                                                    method: 'POST',
                                                    body: formData
                                                });
                                                const result = await response.json();
                                                if(result.status === 'success') {
                                                    const range = quill.getSelection();
                                                    quill.insertEmbed(range.index, 'image', result.url);
                                                } else {
                                                    alert(result.message || 'Gagal unggah gambar.');
                                                }
                                            } catch (e) {
                                                alert('Terjadi kesalahan saat unggah gambar.');
                                            }
                                        } else {
                                            alert('Anda hanya bisa mengunggah file gambar.');
                                        }
                                    };
                                }
                            }
                        }
                    }
                });

                const contentInput = document.getElementById('content');
                if (contentInput) {
                    quill.on('text-change', function() {
                        contentInput.value = quill.root.innerHTML;
                    });
                    contentInput.value = quill.root.innerHTML;
                }
                
                const form = document.getElementById('postForm');
                if (form) {
                    form.addEventListener('submit', function() {
                        if (contentInput) contentInput.value = quill.root.innerHTML;
                    });
                }
            }
        }

        function toggleNewCategory() {
            var select = document.getElementById('category_id');
            if (select && select.value === 'new') {
                // Remove the 'new' selection and reset to default or empty
                select.selectedIndex = 0; 
                document.getElementById("category-add-dialog").classList.remove("hidden");
                document.getElementById("add-category-input").value = '';
                document.getElementById("add-category-input").focus();
            }
        }

        function confirmToDelete(el) {
            document.getElementById("delete-button").setAttribute("href", el.dataset.href);
            document.getElementById("confirm-dialog").classList.remove("hidden");
        }

        function closeModal() {
            var confirmDialog = document.getElementById("confirm-dialog");
            if (confirmDialog) confirmDialog.classList.add("hidden");
            var editDialog = document.getElementById("category-edit-dialog");
            if (editDialog) editDialog.classList.add("hidden");
            var deleteDialog = document.getElementById("category-delete-dialog");
            if (deleteDialog) deleteDialog.classList.add("hidden");
            var addDialog = document.getElementById("category-add-dialog");
            if (addDialog) addDialog.classList.add("hidden");
        }

        async function submitAddCategory() {
            var select = document.getElementById('category_id');
            var newName = document.getElementById('add-category-input').value;
            if(newName && newName.trim() !== '') {
                try {
                    let response = await fetch('<?= base_url('admin/category/store') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ name: newName.trim() })
                    });
                    let result = await response.json();
                    if(result.status === 'success') {
                        // Add new option right before the 'new' option
                        var option = document.createElement("option");
                        option.text = newName.trim();
                        option.value = result.id;
                        select.add(option, select.options[select.options.length - 1]);
                        select.value = result.id; // Select the newly created category
                        closeModal();
                    } else {
                        alert(result.message || 'Gagal menambahkan kategori.');
                    }
                } catch(e) { alert('Terjadi kesalahan.'); }
            }
        }

        function editCategory() {
            var select = document.getElementById('category_id');
            if(!select || select.value === 'new' || select.value === '') return;
            var currentName = select.options[select.selectedIndex].text;
            document.getElementById('edit-category-input').value = currentName;
            document.getElementById('category-edit-dialog').classList.remove('hidden');
        }

        async function submitEditCategory() {
            var select = document.getElementById('category_id');
            var newName = document.getElementById('edit-category-input').value;
            if(newName && newName.trim() !== '') {
                try {
                    let response = await fetch('<?= base_url('admin/category') ?>/' + select.value + '/update', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ name: newName.trim() })
                    });
                    let result = await response.json();
                    if(result.status === 'success') {
                        select.options[select.selectedIndex].text = newName.trim();
                        closeModal();
                    } else {
                        alert('Gagal mengubah kategori.');
                    }
                } catch(e) { alert('Terjadi kesalahan.'); }
            }
        }

        function deleteCategory() {
            var select = document.getElementById('category_id');
            if(!select || select.value === 'new' || select.value === '') return;
            var currentName = select.options[select.selectedIndex].text;
            document.getElementById('delete-category-name').textContent = currentName;
            document.getElementById('category-delete-dialog').classList.remove('hidden');
        }

        async function submitDeleteCategory() {
            var select = document.getElementById('category_id');
            try {
                let response = await fetch('<?= base_url('admin/category') ?>/' + select.value + '/delete', {
                    method: 'POST'
                });
                let result = await response.json();
                if(result.status === 'success') {
                    select.remove(select.selectedIndex);
                    toggleNewCategory();
                    closeModal();
                } else {
                    alert(result.message || 'Gagal menghapus kategori.');
                    closeModal();
                }
            } catch(e) { alert('Terjadi kesalahan.'); }
        }

        // Initial setup
        initDarkMode();
        initLikeBtn();
        initQuill();
        initGlobalChat();

        // Global Chatbot Logic
        function toggleGlobalChat() {
            const chatWindow = document.getElementById('global-chat-window');
            if (chatWindow.classList.contains('hidden')) {
                chatWindow.classList.remove('hidden');
                setTimeout(() => {
                    chatWindow.classList.remove('scale-95', 'opacity-0');
                    chatWindow.classList.add('scale-100', 'opacity-100');
                    document.getElementById('global-chat-input').focus();
                }, 10);
            } else {
                chatWindow.classList.remove('scale-100', 'opacity-100');
                chatWindow.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    chatWindow.classList.add('hidden');
                }, 300);
            }
        }

        function initGlobalChat() {
            const chatForm = document.getElementById('global-chat-form');
            if (!chatForm) return;

            // Remove existing listeners to avoid duplicates when Swup reloads
            const newForm = chatForm.cloneNode(true);
            chatForm.parentNode.replaceChild(newForm, chatForm);

            newForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const input = document.getElementById('global-chat-input');
                const submitBtn = document.getElementById('global-chat-submit');
                const history = document.getElementById('global-chat-history');
                const question = input.value.trim();

                if (!question) return;

                // Add user message
                const userHtml = `
                    <div class="flex justify-end">
                        <div class="bg-indigo-600 text-white px-4 py-2 rounded-2xl rounded-tr-sm max-w-[85%] shadow-sm">
                            ${question.replace(/</g, '&lt;').replace(/>/g, '&gt;')}
                        </div>
                    </div>
                `;
                history.insertAdjacentHTML('beforeend', userHtml);
                history.scrollTop = history.scrollHeight;

                input.value = '';
                submitBtn.disabled = true;

                // Add loading indicator
                const loadingId = 'loading-' + Date.now();
                const loadingHtml = `
                    <div id="${loadingId}" class="flex justify-start">
                        <div class="bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100 dark:border-slate-600 flex items-center space-x-2">
                            <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                `;
                history.insertAdjacentHTML('beforeend', loadingHtml);
                history.scrollTop = history.scrollHeight;

                try {
                    const response = await fetch('<?= base_url('global-chat') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ question: question })
                    });
                    
                    const result = await response.json();
                    document.getElementById(loadingId).remove();

                    if(result.status === 'success') {
                        const botHtml = `
                            <div class="flex justify-start">
                                <div class="bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 px-4 py-2 rounded-2xl rounded-tl-sm shadow-sm border border-slate-100 dark:border-slate-600 max-w-[90%] whitespace-pre-line leading-relaxed">
                                    ${result.answer.replace(/</g, '&lt;').replace(/>/g, '&gt;')}
                                </div>
                            </div>
                        `;
                        history.insertAdjacentHTML('beforeend', botHtml);
                    } else {
                        const errorHtml = `
                            <div class="flex justify-start">
                                <div class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-2xl rounded-tl-sm text-sm">
                                    ⚠️ ${result.message || 'Terjadi kesalahan.'}
                                </div>
                            </div>
                        `;
                        history.insertAdjacentHTML('beforeend', errorHtml);
                    }
                } catch(e) {
                    document.getElementById(loadingId).remove();
                    const errorHtml = `
                        <div class="flex justify-start">
                            <div class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-2xl rounded-tl-sm text-sm">
                                ⚠️ Gagal menghubungi server.
                            </div>
                        </div>
                    `;
                    history.insertAdjacentHTML('beforeend', errorHtml);
                }
                
                submitBtn.disabled = false;
                history.scrollTop = history.scrollHeight;
            });
        }
    </script>
</body>
</html>

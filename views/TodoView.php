<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Aplikasi Todolist</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ============================================
           FONTS & GLOBAL SETTINGS
           ============================================ */
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap');
        
        * {
            font-family: 'Quicksand', sans-serif;
        }

        /* ============================================
           ANIMATIONS
           ============================================ */
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           BODY & BACKGROUND
           ============================================ */
        body {
            background: linear-gradient(135deg, #ffeef8 0%, #ffe0f0 50%, #ffd6eb 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,182,193,0.1) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
            z-index: 0;
        }

        /* ============================================
           CONTAINER & CARD
           ============================================ */
        .container-fluid {
            position: relative;
            z-index: 1;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(255, 105, 180, 0.2);
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out;
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .card-title {
            background: linear-gradient(135deg, #ff69b4, #ff1493);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.5rem;
            margin: 0;
            animation: pulse 2s ease-in-out infinite;
        }

        /* ============================================
           BUTTONS
           ============================================ */
        .btn-primary {
            background: linear-gradient(135deg, #ff69b4, #ff1493);
            border: none;
            border-radius: 15px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 105, 180, 0.5);
            background: linear-gradient(135deg, #ff1493, #ff69b4);
        }
        
        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #d1d1d1, #a8a8a8);
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }
        
        .btn-secondary:hover {
            background: linear-gradient(135deg, #a8a8a8, #d1d1d1);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 2px solid #ff69b4;
            color: #ff69b4;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover,
        .btn-outline-primary.active {
            background: linear-gradient(135deg, #ff69b4, #ff1493);
            border-color: #ff69b4;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.3);
        }

        .btn-outline-secondary {
            border: 2px solid #ff69b4;
            color: #ff69b4;
            border-radius: 0 15px 15px 0;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background: #ff69b4;
            border-color: #ff69b4;
            transform: scale(1.05);
        }

        .btn-info {
            background: linear-gradient(135deg, #ff99cc, #ffb6d9);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-info:hover {
            background: linear-gradient(135deg, #ffb6d9, #ff99cc);
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(255, 153, 204, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffb3d9, #ff8dc7);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #ff8dc7, #ffb3d9);
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(255, 141, 199, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b9d, #ff1493);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #ff1493, #ff6b9d);
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(255, 20, 147, 0.4);
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        /* ============================================
           FORMS
           ============================================ */
        .form-control {
            border: 2px solid #ffb6c1;
            border-radius: 15px;
            padding: 12px 18px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
            transform: scale(1.02);
        }

        .form-select {
            border: 2px solid #ffb6c1;
            border-radius: 15px;
            padding: 12px 18px;
        }
        
        .form-select:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 0 0.2rem rgba(255, 105, 180, 0.25);
        }

        textarea.form-control {
            resize: vertical;
        }

        .input-group .form-control {
            border-radius: 15px 0 0 15px;
        }

        /* ============================================
           TODO ITEMS
           ============================================ */
        .todo-item {
            cursor: grab;
            background: linear-gradient(135deg, #fff 0%, #fff5f9 100%);
            border: 2px solid #ffb6c1;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }
        
        .todo-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 182, 193, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .todo-item:hover::before {
            left: 100%;
        }
        
        .todo-item:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 30px rgba(255, 105, 180, 0.3);
            border-color: #ff69b4;
        }
        
        .todo-item.finished {
            background: linear-gradient(135deg, #f0f0f0 0%, #e9ecef 100%);
            opacity: 0.7;
            border-color: #ddd;
        }
        
        .todo-item.finished h5 {
            text-decoration: line-through;
            color: #999;
        }

        .list-group-item h5 {
            color: #ff1493;
            font-weight: 700;
        }

        .ghost {
            opacity: 0.4;
            background: linear-gradient(135deg, #ffc0cb, #ffb6c1);
            transform: rotate(3deg);
        }

        /* ============================================
           MODALS
           ============================================ */
        .modal-content {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(255, 105, 180, 0.3);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #ff69b4, #ff1493);
            color: white;
            border: none;
            padding: 20px 30px;
        }
        
        .modal-title {
            font-weight: 700;
        }

        /* ============================================
           ALERTS
           ============================================ */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            animation: slideDown 0.5s ease-out;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4f4dd, #bfedd2);
            color: #155724;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #ffd6e7, #ffb3d1);
            color: #721c24;
        }

        /* ============================================
           UTILITIES
           ============================================ */
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ffb6c1, transparent);
            margin: 1.5rem 0;
        }
        
        .badge {
            padding: 8px 15px;
            border-radius: 10px;
            font-weight: 600;
        }
        
        .text-muted {
            color: #ff69b4 !important;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container-fluid p-5">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="card-title">✨ Todo List ✨</h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                    <i class="bi bi-plus-lg"></i> Tambah Todo
                </button>
            </div>
            <hr />

            <?php if (isset($notification)): ?>
                <div class="alert alert-<?= htmlspecialchars($notification['type']) ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($notification['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="GET" action="/" class="row g-3 align-items-center mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="🔍 Cari todo..." value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <div class="btn-group" role="group" aria-label="Filter todo">
                            <a href="?filter=all&search=<?= urlencode($search) ?>" class="btn btn-outline-primary <?= $filter === 'all' ? 'active' : '' ?>">Semua</a>
                            <a href="?filter=unfinished&search=<?= urlencode($search) ?>" class="btn btn-outline-primary <?= $filter === 'unfinished' ? 'active' : '' ?>">Belum Selesai</a>
                            <a href="?filter=finished&search=<?= urlencode($search) ?>" class="btn btn-outline-primary <?= $filter === 'finished' ? 'active' : '' ?>">Selesai</a>
                        </div>
                    </div>
                </div>
            </form>

            <div id="todo-list" class="list-group">
                <?php if (!empty($todos)): ?>
                    <?php foreach ($todos as $todo): ?>
                        <div class="list-group-item list-group-item-action todo-item <?= ($todo['is_finished'] === 't' || $todo['is_finished'] === true) ? 'finished' : '' ?>" data-id="<?= $todo['id'] ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?= htmlspecialchars($todo['title']) ?></h5>
                                <small class="text-muted"><?= date('d M Y', strtotime($todo['created_at'])) ?></small>
                            </div>
                            <p class="mb-1 text-truncate"><?= htmlspecialchars($todo['description'] ?: 'Tidak ada deskripsi.') ?></p>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-info" onclick="showViewModal(<?= $todo['id'] ?>)">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="showEditModal(<?= $todo['id'] ?>)">
                                    <i class="bi bi-pencil"></i> Ubah
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="showDeleteModal(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center text-muted p-3">
                        <p style="font-size: 1.2rem;">💖 Belum ada data tersedia! 💖</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD TODO -->
<div class="modal fade" id="addTodoModal" tabindex="-1" aria-labelledby="addTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoModalLabel">Tambah Data Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Contoh: Belajar PHP MVC" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" id="inputDescription" rows="3" placeholder="Contoh: Membuat aplikasi sederhana dengan konsep MVC..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL VIEW TODO -->
<div class="modal fade" id="viewTodoModal" tabindex="-1" aria-labelledby="viewTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTodoModalLabel">Detail Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="viewTitle"></h5>
                <p><small class="text-muted">Dibuat: <span id="viewCreatedAt"></span> | Diperbarui: <span id="viewUpdatedAt"></span></small></p>
                <p id="viewDescription"></p>
                <p><strong>Status:</strong> <span id="viewStatus"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT TODO -->
<div class="modal fade" id="editTodoModal" tabindex="-1" aria-labelledby="editTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTodoModalLabel">Ubah Data Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=update" method="POST">
                <input name="id" type="hidden" id="editTodoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" id="editTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" id="editDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" name="is_finished" id="editStatus">
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE TODO -->
<div class="modal fade" id="deleteTodoModal" tabindex="-1" aria-labelledby="deleteTodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTodoModalLabel">Hapus Data Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Kamu akan menghapus todo <strong class="text-danger" id="deleteTodoTitle"></strong>. Apakah kamu yakin?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="?page=delete" method="POST" class="d-inline">
                    <input type="hidden" name="id" id="deleteTodoId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    const viewTodoModal = new bootstrap.Modal(document.getElementById('viewTodoModal'));
    const editTodoModal = new bootstrap.Modal(document.getElementById('editTodoModal'));
    const deleteTodoModal = new bootstrap.Modal(document.getElementById('deleteTodoModal'));

    function fetchTodoData(id) {
        return fetch(`?page=show&id=${id}`).then(response => response.json());
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    async function showViewModal(id) {
        const todo = await fetchTodoData(id);
        document.getElementById('viewTitle').innerText = todo.title;
        document.getElementById('viewDescription').innerText = todo.description || 'Tidak ada deskripsi.';
        document.getElementById('viewCreatedAt').innerText = formatDate(todo.created_at);
        document.getElementById('viewUpdatedAt').innerText = formatDate(todo.updated_at);
        const statusBadge = todo.is_finished === 't'
            ? '<span class="badge bg-success">Selesai</span>'
            : '<span class="badge bg-danger">Belum Selesai</span>';
        document.getElementById('viewStatus').innerHTML = statusBadge;
        viewTodoModal.show();
    }

    async function showEditModal(id) {
        const todo = await fetchTodoData(id);
        document.getElementById('editTodoId').value = todo.id;
        document.getElementById('editTitle').value = todo.title;
        document.getElementById('editDescription').value = todo.description;
        document.getElementById('editStatus').value = todo.is_finished === 't' ? '1' : '0';
        editTodoModal.show();
    }

    function showDeleteModal(id, title) {
        document.getElementById('deleteTodoTitle').textContent = title;
        document.getElementById('deleteTodoId').value = id;
        deleteTodoModal.show();
    }

    // SortableJS
    const todoListEl = document.getElementById('todo-list');
    if (todoListEl) {
        new Sortable(todoListEl, {
            animation: 150,
            ghostClass: 'ghost',
            onEnd: function (evt) {
                const todoIds = Array.from(evt.to.children).map(item => item.dataset.id);
                
                const formData = new FormData();
                todoIds.forEach(id => formData.append('order[]', id));

                fetch('?page=sort', {
                    method: 'POST',
                    body: formData
                }).catch(error => console.error('Error saving sort order:', error));
            },
        });
    }
</script>
</body>
</html>
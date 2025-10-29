<?php

class TodoController
{
    public function index()
    {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $todoModel = new TodoModel();
        $todos = $todoModel->getAllTodos($filter, $search);

        $notification = null;
        if (isset($_SESSION['notification'])) {
            $notification = $_SESSION['notification'];
            unset($_SESSION['notification']);
        }

        include (__DIR__ . '/../views/TodoView.php');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);

            $todoModel = new TodoModel();
            if ($todoModel->isTitleExists($title)) {
                $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal! Judul todo sudah ada.'];
            } else {
                if ($todoModel->createTodo($title, $description)) {
                    $_SESSION['notification'] = ['type' => 'success', 'message' => 'Todo berhasil ditambahkan!'];
                } else {
                    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menambahkan todo.'];
                }
            }
        }
        header('Location: /');
        exit();
    }

    public function show()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $todoModel = new TodoModel();
            $todo = $todoModel->getTodoById($id);
            if ($todo) {
                header('Content-Type: application/json');
                echo json_encode($todo);
                return;
            }
        }
        http_response_code(404);
        echo json_encode(['error' => 'Todo not found']);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $is_finished = $_POST['is_finished'];

            $todoModel = new TodoModel();
            if ($todoModel->isTitleExists($title, $id)) {
                $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal! Judul todo sudah ada.'];
            } else {
                if ($todoModel->updateTodo($id, $title, $description, $is_finished)) {
                    $_SESSION['notification'] = ['type' => 'success', 'message' => 'Todo berhasil diperbarui!'];
                } else {
                    $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal memperbarui todo.'];
                }
            }
        }
        header('Location: /');
        exit();
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $todoModel = new TodoModel();
            if ($todoModel->deleteTodo($id)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Todo berhasil dihapus!'];
            } else {
                $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menghapus todo.'];
            }
        }
        header('Location: /');
        exit();
    }

    public function sort() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $todoIds = $_POST['order'];
            $todoModel = new TodoModel();
            $todoModel->updateOrder($todoIds);
            // No need to send a response back for this simple case
        }
    }
}
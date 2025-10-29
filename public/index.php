<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/TodoModel.php';
require_once __DIR__ . '/../controllers/TodoController.php';

// This is a simple router.
// It will serve static files if they exist, otherwise it will run the application.
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (preg_match('/\.(?:png|jpg|jpeg|gif|ico|css|js)$/', $request_uri)) {
    if (file_exists(__DIR__ . $request_uri)) {
        // For static files that exist, let the server handle it.
        // This block is mainly for the built-in PHP server.
        return false;
    } else {
        // For static files that do not exist, return a 404.
        http_response_code(404);
        // You can optionally include a body for the 404 response
        // echo "404 Not Found: " . htmlspecialchars($request_uri);
        exit();
    }
}

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'index';
}

try {
    $todoController = new TodoController();
    switch ($page) {
        case 'index':
            $todoController->index();
            break;
        case 'create':
            $todoController->create();
            break;
        case 'show':
            $todoController->show();
            break;
        case 'update':
            $todoController->update();
            break;
        case 'delete':
            $todoController->delete();
            break;
        case 'sort':
            $todoController->sort();
            break;
        default:
            http_response_code(404);
            echo "<h1>404 Not Found</h1><p>Halaman tidak ditemukan.</p>";
    }
} catch (RuntimeException $e) {
    http_response_code(500);
    // Anda bisa membuat halaman error yang lebih bagus di sini
    echo "<h1>Terjadi Kesalahan Server</h1><p>Tidak dapat terhubung ke database. Silakan coba lagi nanti.</p>";
}
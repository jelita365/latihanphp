
<?php

class TodoModel
{
    private $conn;

    public function __construct()
    {
        // Inisialisasi koneksi database PostgreSQL
        $conn_string = 'host=' . DB_HOST . ' port=' . DB_PORT . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASSWORD;
        // Gunakan @ untuk menekan warning default PHP agar bisa ditangani secara manual
        $connection = @pg_connect($conn_string); 

        if (!$connection) {
            // Jika koneksi gagal, lempar exception tanpa memanggil fungsi pg_* lainnya
            throw new RuntimeException('Koneksi database gagal. Periksa konfigurasi dan pastikan server PostgreSQL berjalan.');
        }
        $this->conn = $connection;
    }

    public function getAllTodos($filter = 'all', $search = '')
    {
        $query = 'SELECT * FROM todo WHERE 1=1';
        $params = [];
        $paramIndex = 1;

        if ($filter === 'finished') {
            $query .= ' AND is_finished = true';
        } elseif ($filter === 'unfinished') {
            $query .= ' AND is_finished = false';
        }

        if (!empty($search)) {
            $query .= ' AND title ILIKE $' . $paramIndex;
            $params[] = '%' . $search . '%';
            $paramIndex++;
        }

        $query .= ' ORDER BY sort_order ASC, created_at DESC';

        $result = pg_query_params($this->conn, $query, $params);
        $todos = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $todos[] = $row;
            }
        }
        return $todos;
    }

    public function getTodoById($id)
    {
        $query = 'SELECT * FROM todo WHERE id = $1';
        $result = pg_query_params($this->conn, $query, [$id]);
        return pg_fetch_assoc($result);
    }

    public function isTitleExists($title, $excludeId = null)
    {
        $query = 'SELECT id FROM todo WHERE title = $1';
        $params = [$title];
        if ($excludeId !== null) {
            $query .= ' AND id != $2';
            $params[] = $excludeId;
        }
        $result = pg_query_params($this->conn, $query, $params);
        if ($result) {
            return pg_num_rows($result) > 0;
        } else {
            return false; // Atau throw exception, tergantung kebutuhan Anda
        }
    }

    public function createTodo($title, $description)
    {
        // Get the highest sort_order and add 1
        $maxOrderQuery = 'SELECT MAX(sort_order) as max_order FROM todo';
        $maxOrderResult = @pg_query($this->conn, $maxOrderQuery);
        
        // Safely fetch the result and handle potential query failure
        $maxOrderRow = $maxOrderResult ? pg_fetch_assoc($maxOrderResult) : null;
        $maxOrder = $maxOrderRow ? $maxOrderRow['max_order'] : null;

        $newOrder = ($maxOrder === null) ? 1 : $maxOrder + 1;

        // Memasukkan nilai untuk semua kolom yang relevan, termasuk created_at dan updated_at
        // dengan waktu saat ini menggunakan NOW().
        $query = 'INSERT INTO todo (title, description, sort_order, created_at, updated_at) VALUES ($1, $2, $3, NOW(), NOW())';
        $result = pg_query_params($this->conn, $query, [$title, $description, $newOrder]);
        return $result !== false;
    }

    public function updateTodo($id, $title, $description, $is_finished)
    {
        $query = 'UPDATE todo SET title=$1, description=$2, is_finished=$3, updated_at=NOW() WHERE id=$4';
        $result = pg_query_params($this->conn, $query, [$title, $description, $is_finished, $id]);
        return $result !== false;
    }

    public function deleteTodo($id)
    {
        $query = 'DELETE FROM todo WHERE id=$1';
        $result = pg_query_params($this->conn, $query, [$id]);
        return $result !== false;
    }

    public function updateOrder($todoIds)
    {
        pg_query($this->conn, 'BEGIN');
        try {
            foreach ($todoIds as $index => $id) {
                $order = $index + 1;
                $query = 'UPDATE todo SET sort_order = $1 WHERE id = $2';
                $result = pg_query_params($this->conn, $query, [$order, $id]);
                if (!$result) {
                    throw new Exception(pg_last_error($this->conn));
                }
            }
            pg_query($this->conn, 'COMMIT');
            return true;
        } catch (Exception $e) {
            pg_query($this->conn, 'ROLLBACK');
            // Log the error if needed
            return false;
        }
    }
}
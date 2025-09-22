<?php
require_once "../config/config.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID задачи не указан");
}

try {
    $delete_query = "DELETE FROM tasks WHERE id = ?";
    $delete_stmt = mysqli_prepare($connect, $delete_query);
    
    if (!$delete_stmt) {
        die("Ошибка подготовки запроса: " . mysqli_error($connect));
    }
    
    mysqli_stmt_bind_param($delete_stmt, 'i', $id);
    
    if (mysqli_stmt_execute($delete_stmt)) {
        header("Location: /");
        exit();
    } else {
        $errors[] = 'Ошибка при удалении задачи: ' . mysqli_error($connect);
    }
    
} catch (Exception $e) {
    $errors[] = 'Ошибка при удалении задачи: ' . $e->getMessage();
}
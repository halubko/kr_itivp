<?php
    require_once "../config/config.php";

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("ID задачи не указан");
    }

    $query = "SELECT * FROM tasks WHERE id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_assoc($result);

    if (!$task) {
        die("Задача не найдена");
    }

    try {

        if($task['status'] == "не выполнена"){
            $status = "выполнена";
        } else {
            $status = "не выполнена";
        }

        $update_query = "UPDATE tasks SET status = ? WHERE id = ?";
        $update_stmt = mysqli_prepare($connect, $update_query);
        mysqli_stmt_bind_param($update_stmt, 'si', $status, $id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            header("Location: /");
            exit();
        } else {
            $errors[] = 'Ошибка при обновлении задачи: ' . mysqli_error($connect);
        }
        
    } catch (Exception $e) {
        $errors[] = 'Ошибка при обновлении задачи: ' . $e->getMessage();
    }

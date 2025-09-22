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

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? '';
    $priority = $_POST['priority'] ?? '';
    $due_date = $_POST['due_date'] ?? null;

    // Валидация данных
    if (empty($title)) {
        $errors[] = 'Название задачи обязательно для заполнения';
    }
    
    if (strlen($title) > 255) {
        $errors[] = 'Название задачи не должно превышать 255 символов';
    }
    
    if (empty($errors)) {
        try {
            $update_query = "UPDATE tasks SET title = ?, description = ?, status = ?, priority = ?, due_date = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($connect, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'sssssi', $title, $description, $status, $priority, $due_date, $id);
            
            if (mysqli_stmt_execute($update_stmt)) {
                header("Location: /");
                exit();
            } else {
                $errors[] = 'Ошибка при обновлении задачи: ' . mysqli_error($connect);
            }
            
        } catch (Exception $e) {
            $errors[] = 'Ошибка при обновлении задачи: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование задачи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/add.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Редактирование задачи #<?php echo htmlspecialchars($task['id']); ?></h1>
                
                <div class="mb-3">
                    <a href="/" class="btn btn-secondary">Назад к списку задач</a>
                </div>
                
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <h5>Ошибки:</h5>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="edit.php?id=<?php echo htmlspecialchars($task['id']); ?>">
                    <div class="form-group">
                        <label for="title" class="form-label">Название задачи *</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($task['title']); ?>" 
                               required maxlength="255">
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">Описание задачи</label>
                        <textarea class="form-control" id="description" name="description" rows="5"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($task['description']); ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Статус</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Не выполнена" <?php echo ((isset($_POST['status']) ? $_POST['status'] : $task['status']) === 'Не выполнена') ? 'selected' : ''; ?>>Не выполнена</option>
                                    <option value="Выполнена" <?php echo ((isset($_POST['status']) ? $_POST['status'] : $task['status']) === 'Выполнена') ? 'selected' : ''; ?>>Выполнена</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="due_date" class="form-label">Срок выполнения</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" 
                                value="<?php echo isset($_POST['due_date']) ? htmlspecialchars($_POST['due_date']) : htmlspecialchars($task['due_date']); ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="priority" class="form-label">Приоритет</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="низкий" <?php echo ((isset($_POST['priority']) ? $_POST['priority'] : $task['priority']) === 'низкий') ? 'selected' : ''; ?>>Низкий</option>
                                    <option value="средний" <?php echo ((isset($_POST['priority']) ? $_POST['priority'] : $task['priority']) === 'средний') ? 'selected' : ''; ?>>Средний</option>
                                    <option value="высокий" <?php echo ((isset($_POST['priority']) ? $_POST['priority'] : $task['priority']) === 'высокий') ? 'selected' : ''; ?>>Высокий</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        <a href="/" class="btn btn-secondary">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
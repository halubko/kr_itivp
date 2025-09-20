<?php
    require_once "./config/config.php";
    $tasks = mysqli_query($connect, "SELECT * FROM `tasks`");
    $tasks = mysqli_fetch_all($tasks);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список задач</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/main.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Список задач</h1>
        
        <table class="table table-striped table-hover rounded">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Статус</th>
                    <th>Приоритет</th>
                    <th>Срок выполнения</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <?php 
                    list($id, $title, $description, $status, $priority, $due_date, $created_at) = $task;
                    $isCompleted = $status === 'выполнена';
                    ?>
                    <tr class="<?php echo $isCompleted ? 'completed' : ''; ?>">
                        <td><?php echo htmlspecialchars($id); ?></td>
                        <td><?php echo htmlspecialchars($title); ?></td>
                        <td><?php echo htmlspecialchars($description ?: '—'); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $isCompleted ? 'success' : 'warning'; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </td>
                        <td>
                            <span class="priority-<?php 
                                echo $priority === 'низкий' ? 'low' : 
                                     ($priority === 'средний' ? 'medium' : 'high'); 
                            ?>">
                                <?php echo htmlspecialchars($priority); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($due_date); ?></td>
                        <td><?php echo htmlspecialchars($created_at); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="./CRUD/edit.php" class="btn btn-primary btn-sm">
                                    Редактировать
                                </a>
                                
                                <form action="delete.php" method="DELETE">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Удалить задачу?')">
                                        Удалить
                                    </button>
                                </form>
                                
                                <?php if (!$isCompleted): ?>
                                    <form action="update_status.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            Поменять статус
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-danger btn-sm">
                                        Поменять статус
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="add.php" class="btn btn-primary">Добавить новую задачу</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
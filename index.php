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
        <h1 class="mb-4">Список дел (To-Do List)</h1>
        
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
                                <a href="./CRUD/edit.php?id=<?php echo $task[0]; ?>" class="btn btn-primary btn-sm">
                                    Редактировать
                                </a>
                                
                                <a href="./CRUD/delete.php?id=<?php echo $task[0]; ?>" class="btn btn-danger btn-sm">
                                    Удалить
                                </a>
                                
                                <a href="./CRUD/update_status.php?id=<?php echo $task[0]; ?>" class="btn btn-success btn-sm">
                                    Поменять статус
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="./CRUD/add.php" class="btn btn-primary">Добавить новую задачу</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
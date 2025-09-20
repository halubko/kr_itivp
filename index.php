<?php
    require_once "./config/config.php";
    $tasks = mysqli_query($connect, "SELECT * FROM `tasks`");
    $tasks = mysqli_fetch_all($tasks);
    echo'<pre>';
    print_r($tasks);
    echo'</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
                <div class="mb-3">
                    <a href="./CRUD/add.php" class="btn btn-secondary">← Создать задачу</a>
                </div>
</body>
</html>
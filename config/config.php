<?php
    try{
        $connect = mysqli_connect('localhost','root', 'admin123', 'task_manager', 3306);

        $query = "CREATE TABLE tasks (
                id INT PRIMARY KEY AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                description TEXT NULL,
                status ENUM('не выполнена', 'выполнена') NOT NULL DEFAULT 'не выполнена',
                priority ENUM('низкий', 'средний', 'высокий') NOT NULL DEFAULT 'средний',
                due_date DATE NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );";

        mysqli_query($connect, $query);

        echo("Table 'tasks' created");
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1050) {
            echo "Table 'tasks' already exists";
        } else {
            echo "Connection error to MySQL: " . $e->getMessage();
        }
    }
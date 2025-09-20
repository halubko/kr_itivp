<?php
    $connect = mysqli_connect('localhost','root', 'admin123', 'task_manager', 3306);

    if(!$connect){
        die('Fail connect to db');
    }

    echo('Connected to db');
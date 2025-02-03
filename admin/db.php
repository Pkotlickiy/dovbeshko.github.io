<?php
// Подключение к базе данных
$servername = "localhost";
$username = "u2995143_root"; // Имя пользователя базы данных
$password = "Pasha2te2u"; // Пароль базы данных
$dbname = "u2995143_lawyer_db";
try {
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
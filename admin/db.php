<?php
$servername = "server39.hosting.reg.ru";
$username = "u2995143_root"; // Имя пользователя базы данных
$password = "Pasha2te2u"; // Пароль базы данных
$dbname = "lawyer_db";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

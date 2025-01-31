<?php
$servername = "localhost";
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "lawyer_db";

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
session_start();

// Подключение к базе данных
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Хеширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Вставка пользователя в базу данных
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $hashed_password);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Регистрация успешна.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>
<?php
session_start();

// Подключение к базе данных
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Поиск пользователя в базе данных
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Пользователь найден, авторизация успешна
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        // Пользователь не найден или неверный пароль
        echo "Неверный логин или пароль.";
    }

    $stmt->close();
}
$conn->close();
?>
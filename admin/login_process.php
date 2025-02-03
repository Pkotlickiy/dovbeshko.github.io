<?php
session_start();

// Подключение к базе данных
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Поиск пользователя в базе данных
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Проверка пароля
        if (password_verify($password, $user['password'])) {
            // Авторизация успешна
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username']; // Сохраняем имя пользователя в сессии
            header("Location: dashboard.php");
            exit;
        } else {
            // Неверный пароль
            echo "<p style='color: red;'>Неверный логин или пароль.</p>";
        }
    } else {
        // Пользователь не найден
        echo "<p style='color: red;'>Неверный логин или пароль.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $author = trim($_POST['author']);
    $text = trim($_POST['text']);

    // Подготовленный запрос для вставки отзыва
    $query = "INSERT INTO reviews (author, text) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $author, $text);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Отзыв успешно добавлен.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить отзыв</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Меню</h2>
            <ul>
                <li><a href="edit_stats.php">Редактировать статистику</a></li>
                <li><a href="add_review.php">Добавить отзыв</a></li>
                <li><a href="edit_articles.php">Управление статьями</a></li>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </aside>
        <main class="content">
            <header class="header">
                <h1>Добавить отзыв</h1>
            </header>
            <form method="POST" class="card">
                <label for="author">Автор:</label>
                <input type="text" id="author" name="author" placeholder="Имя автора" required>
                <label for="text">Текст отзыва:</label>
                <textarea id="text" name="text" placeholder="Текст отзыва" required></textarea>
                <button type="submit">Добавить</button>
            </form>
        </main>
    </div>
</body>
</html>
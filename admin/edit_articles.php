<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

// Обработка POST-запроса (добавление статьи)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $title = trim($_POST['title']);
    $excerpt = trim($_POST['excerpt']);
    $image = trim($_POST['image']);
    $link = trim($_POST['link']);

    // Подготовленный запрос для вставки статьи
    $query = "INSERT INTO articles (title, excerpt, image, link) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $title, $excerpt, $image, $link);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Статья успешно добавлена.</p>";
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
    <title>Добавить статью</title>
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
                <h1>Добавить статью</h1>
            </header>
            <form method="POST" class="card">
                <label for="title">Заголовок:</label>
                <input type="text" id="title" name="title" placeholder="Введите заголовок" required>

                <label for="excerpt">Краткое описание:</label>
                <textarea id="excerpt" name="excerpt" placeholder="Введите краткое описание" required></textarea>

                <label for="image">Ссылка на изображение:</label>
                <input type="text" id="image" name="image" placeholder="Введите ссылку на изображение" required>

                <label for="link">Ссылка на статью:</label>
                <input type="text" id="link" name="link" placeholder="Введите ссылку на статью" required>

                <button type="submit" class="btn">Добавить</button>
            </form>
        </main>
    </div>
</body>
</html>
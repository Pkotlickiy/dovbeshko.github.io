<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!-- Шапка админ-панели -->
    <header class="admin-header">
        <h1>Админ-панель</h1>
        <a href="../index.php" class="btn">На главную</a>
        <a href="logout.php" class="logout">Выйти</a>
    </header>

    <!-- Боковое меню -->
    <aside class="sidebar">
        <ul>
            <li><a href="stats.php"><i class="fas fa-chart-bar"></i> Статистика</a></li>
            <li><a href="services.php"><i class="fas fa-briefcase"></i> Услуги</a></li>
            <li><a href="reviews.php"><i class="fas fa-comments"></i> Отзывы</a></li>
            <li><a href="articles.php"><i class="fas fa-newspaper"></i> Статьи</a></li>
        </ul>
    </aside>

    <!-- Основное содержимое -->
    <main class="main-content">
        <h2>Добро пожаловать в админ-панель</h2>
        <p>Здесь вы можете управлять контентом сайта:</p>
        <ul>
            <li><strong>Статистика:</strong> Редактирование счетчиков успехов.</li>
            <li><strong>Услуги:</strong> Добавление, редактирование и удаление услуг.</li>
            <li><strong>Отзывы:</strong> Управление отзывами клиентов.</li>
            <li><strong>Статьи:</strong> Добавление и редактирование статей.</li>
        </ul>
    </main>

    <script src="../js/scripts.js"></script>
</body>
</html>
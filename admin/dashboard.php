<?php
session_start();
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
    <title>Админ панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <!-- Сайдбар -->
        <aside class="sidebar">
            <h2>Меню</h2>
            <ul>
                <li><a href="edit_stats.php">Редактировать статистику</a></li>
                <li><a href="add_review.php">Добавить отзыв</a></li>
                <li><a href="edit_articles.php">Управление статьями</a></li>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </aside>

        <!-- Основное содержимое -->
        <main class="content">
            <header class="header">
                <h1>Добро пожаловать в админ-панель</h1>
            </header>

            <section class="dashboard">
                <div class="dashboard-content">
                    <p>Выберите раздел для управления контентом.</p>
                </div>

                <div class="quick-links">
                    <h2>Быстрые ссылки</h2>
                    <div class="quick-link">
                        <a href="edit_stats.php">
                            <i class="fas fa-chart-line"></i>
                            <span>Редактировать статистику</span>
                        </a>
                    </div>
                    <div class="quick-link">
                        <a href="add_review.php">
                            <i class="fas fa-comments"></i>
                            <span>Добавить отзыв</span>
                        </a>
                    </div>
                    <div class="quick-link">
                        <a href="edit_articles.php">
                            <i class="fas fa-newspaper"></i>
                            <span>Управление статьями</span>
                        </a>
                    </div>
                    <div class="quick-link">
                        <a href="logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Выйти</span>
                        </a>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Подключение скриптов -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>
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
    <title>Административная панель</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Административная панель</h2>
        <a href="logout.php" class="btn">Выйти</a>
        <div class="admin-links">
            <a href="about.php" class="btn">Обо мне</a>
            <a href="certificates.php" class="btn">Сертификаты и награды</a>
            <a href="services.php" class="btn">Услуги</a>
            <a href="reviews.php" class="btn">Отзывы клиентов</a>
            <a href="contact.php" class="btn">Контакты</a>
        </div>
    </div>
</body>
</html>
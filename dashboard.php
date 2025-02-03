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
    <title>Админ панель</title>
</head>
<body>
    <h1>Добро пожаловать в админ-панель</h1>
    <p>Здесь вы можете управлять контентом сайта.</p>
</body>
</html>
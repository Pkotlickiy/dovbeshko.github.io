<?php
session_start();
include '../db.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Простая проверка логина и пароля (замените на более безопасный метод)
if ($username === "admin" && $password === "admin") {
    $_SESSION['loggedin'] = true;
    header("Location: dashboard.php");
    exit;
} else {
    echo "Неверный логин или пароль.";
    header("Location: login.php");
    exit;
}
?>
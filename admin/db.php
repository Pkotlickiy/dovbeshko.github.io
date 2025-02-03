<?php
// Подключение к базе данных
$servername = "server39.hosting.reg.ru";
$username = "u2995143_root"; // Имя пользователя базы данных
$password = "Pasha2te2u"; // Пароль базы данных
$dbname = "lawyer_db";

// Убедитесь, что переменная $host определена
$host = $servername;

// Создаем соединение
$conn = new mysqli($host, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Хэширование пароля
$hashed_password = password_hash('secure_password', PASSWORD_DEFAULT);

// Подготовленный запрос для вставки пользователя
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", 'admin', $hashed_password);

if ($stmt->execute()) {
    echo "Пользователь успешно добавлен.";
} else {
    echo "Ошибка: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
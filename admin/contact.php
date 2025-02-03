<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

// Обработка POST-запроса (обновление)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $phone = trim($_POST['phone']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Очистка email
    $address = trim($_POST['address']);

    // Подготовленный запрос для обновления
    $sql = "UPDATE contact SET phone = ?, email = ?, address = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $phone, $email, $address);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно обновлены.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Получение текущих данных контактов
$result = $conn->query("SELECT * FROM contact WHERE id = 1");

if ($result->num_rows === 0) {
    echo "<p style='color: red;'>Контактная информация не найдена.</p>";
    exit;
}

$row = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление "Контакты"</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Управление "Контакты"</h2>
        <a href="dashboard.php" class="btn">Назад</a>

        <!-- Форма редактирования -->
        <form action="contact.php" method="post" class="card">
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" id="phone" name="phone" placeholder="Телефон" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <textarea id="address" name="address" placeholder="Адрес" required><?php echo htmlspecialchars($row['address']); ?></textarea>
            </div>
            <button type="submit" class="btn">Обновить</button>
        </form>
    </div>
</body>
</html>
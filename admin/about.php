<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $text = $_POST['text'];
    $image = $_POST['image'];

    // Подготовленный запрос для обновления данных
    $sql = "UPDATE about SET text = ?, image = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $text, $image);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно обновлены.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Получение данных для отображения формы
$result = $conn->query("SELECT * FROM about WHERE id = 1");
$row = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление "Обо мне"</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Управление "Обо мне"</h2>
        <a href="dashboard.php" class="btn">Назад</a>
        <form action="about.php" method="post">
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="text" name="text" placeholder="Текст" required><?php echo htmlspecialchars($row['text']); ?></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-image"></i>
                <input type="text" id="image" name="image" placeholder="URL изображения" value="<?php echo htmlspecialchars($row['image']); ?>" required>
            </div>
            <button type="submit" class="btn">Обновить</button>
        </form>
    </div>
</body>
</html>
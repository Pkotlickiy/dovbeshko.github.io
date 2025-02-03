<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

// Получение текущей статистики
$query = "SELECT * FROM stats WHERE id = 1";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    echo "<p style='color: red;'>Статистика не найдена.</p>";
    exit;
}

$stats = $result->fetch_assoc();

// Обработка POST-запроса (обновление статистики)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $successful_cases = intval($_POST['successful_cases']);
    $experience_years = intval($_POST['experience_years']);
    $satisfied_clients = intval($_POST['satisfied_clients']);

    // Подготовленный запрос для обновления
    $update_query = "UPDATE stats SET successful_cases = ?, experience_years = ?, satisfied_clients = ? WHERE id = 1";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('iii', $successful_cases, $experience_years, $satisfied_clients);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Статистика успешно обновлена.</p>";
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
    <title>Редактирование статистики</title>
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
                <h1>Редактирование статистики</h1>
            </header>
            <form method="POST" class="card">
                <label for="successful_cases">Успешных дел:</label>
                <input type="number" id="successful_cases" name="successful_cases" value="<?php echo htmlspecialchars($stats['successful_cases']); ?>" required>

                <label for="experience_years">Лет опыта:</label>
                <input type="number" id="experience_years" name="experience_years" value="<?php echo htmlspecialchars($stats['experience_years']); ?>" required>

                <label for="satisfied_clients">Довольных клиентов (%):</label>
                <input type="number" id="satisfied_clients" name="satisfied_clients" value="<?php echo htmlspecialchars($stats['satisfied_clients']); ?>" required>

                <button type="submit" class="btn">Сохранить</button>
            </form>
        </main>
    </div>
</body>
</html>
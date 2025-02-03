<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include 'db.php'; // Подключение к базе данных

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $successful_cases = trim($_POST['successful_cases']);
    $experience_years = trim($_POST['experience_years']);
    $satisfied_clients = trim($_POST['satisfied_clients']);

    // Обновление данных в базе данных
    $query = "UPDATE stats SET 
                successful_cases = ?, 
                experience_years = ?, 
                satisfied_clients = ? 
              WHERE id = 1";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $successful_cases, $experience_years, $satisfied_clients);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Статистика успешно обновлена.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении статистики: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Получение текущих данных статистики
$query_stats = "SELECT * FROM stats WHERE id = 1";
$result_stats = $conn->query($query_stats);
$stats = $result_stats->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование статистики</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
        <h2>Редактирование статистики</h2>

        <form action="" method="post" class="consultation-form card">
            <div class="input-group">
                <label for="successful_cases">Успешных дел:</label>
                <input type="text" id="successful_cases" name="successful_cases" value="<?php echo htmlspecialchars($stats['successful_cases']); ?>" required>
            </div>
            <div class="input-group">
                <label for="experience_years">Лет опыта:</label>
                <input type="text" id="experience_years" name="experience_years" value="<?php echo htmlspecialchars($stats['experience_years']); ?>" required>
            </div>
            <div class="input-group">
                <label for="satisfied_clients">Довольных клиентов (%):</label>
                <input type="text" id="satisfied_clients" name="satisfied_clients" value="<?php echo htmlspecialchars($stats['satisfied_clients']); ?>" required>
            </div>
            <button type="submit" class="btn">Сохранить изменения</button>
        </form>
    </main>
</body>
</html>
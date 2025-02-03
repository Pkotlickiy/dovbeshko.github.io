<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

// Получение ID услуги из GET-параметра
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='color: red;'>Неверный ID услуги.</p>";
    exit;
}

$id = intval($_GET['id']); // Защита от некорректных данных

// Получение данных услуги из базы данных
$sql = "SELECT * FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='color: red;'>Услуга не найдена.</p>";
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();

// Обработка POST-запроса (обновление)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $icon = trim($_POST['icon']);

    // Подготовленный запрос для обновления
    $sql = "UPDATE services SET title = ?, description = ?, icon = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $icon, $id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно обновлены.</p>";
        header("Location: services.php"); // Перенаправление после успешного обновления
        exit;
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении данных: " . $stmt->error . "</p>";
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
    <title>Редактирование услуги</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Редактирование услуги</h2>
        <a href="dashboard.php" class="btn">Назад</a>

        <!-- Форма редактирования -->
        <form action="services_edit.php?id=<?php echo htmlspecialchars($id); ?>" method="post" class="card">
            <div class="input-group">
                <i class="fas fa-heading"></i>
                <input type="text" id="title" name="title" placeholder="Название услуги" value="<?php echo htmlspecialchars($row['title']); ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="description" name="description" placeholder="Описание услуги" required><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-icons"></i>
                <input type="text" id="icon" name="icon" placeholder="Иконка (например, fas fa-users)" value="<?php echo htmlspecialchars($row['icon']); ?>" required>
            </div>
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit" class="btn">Обновить</button>
        </form>
    </div>
</body>
</html>
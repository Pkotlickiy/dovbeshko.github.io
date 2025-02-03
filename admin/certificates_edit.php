<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

// Проверка наличия ID в GET-запросе
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p style='color: red;'>Неверный ID.</p>";
    exit;
}

$id = intval($_GET['id']); // Защита от некорректных данных

// Получение данных сертификата
$sql = "SELECT * FROM certificates WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='color: red;'>Сертификат не найден.</p>";
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();

// Обработка POST-запроса (обновление)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);

    // Подготовленный запрос для обновления
    $sql = "UPDATE certificates SET title = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $image, $id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно обновлены.</p>";
        header("Location: certificates.php");
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
    <title>Редактирование сертификата</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Редактирование сертификата</h2>
        <a href="dashboard.php" class="btn">Назад</a>

        <!-- Форма редактирования -->
        <form action="certificates_edit.php?id=<?php echo htmlspecialchars($id); ?>" method="post" class="card">
            <div class="input-group">
                <i class="fas fa-certificate"></i>
                <input type="text" id="title" name="title" placeholder="Название" value="<?php echo htmlspecialchars($row['title']); ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="description" name="description" placeholder="Описание" required><?php echo htmlspecialchars($row['description']); ?></textarea>
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
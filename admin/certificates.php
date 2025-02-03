<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Подключение к базе данных
include '../db.php';

// Обработка POST-запроса (добавление/редактирование)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image = trim($_POST['image']);

    if (isset($_POST['edit_id'])) {
        // Редактирование существующего сертификата
        $edit_id = intval($_POST['edit_id']); // Защита от некорректных данных
        $sql = "UPDATE certificates SET title = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $description, $image, $edit_id);
        $action_message = "Сертификат успешно обновлен.";
    } else {
        // Добавление нового сертификата
        $sql = "INSERT INTO certificates (title, description, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $description, $image);
        $action_message = "Сертификат успешно добавлен.";
    }

    if ($stmt->execute()) {
        echo "<p style='color: green;'>$action_message</p>";
    } else {
        echo "<p style='color: red;'>Ошибка: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Обработка GET-запроса (удаление)
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Защита от некорректных данных
    $sql = "DELETE FROM certificates WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Сертификат успешно удален.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при удалении: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Получение всех сертификатов для отображения
$result = $conn->query("SELECT * FROM certificates");
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление "Сертификаты и награды"</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Управление "Сертификаты и награды"</h2>
        <a href="dashboard.php" class="btn">Назад</a>

        <!-- Форма добавления/редактирования -->
        <form action="certificates.php" method="post" class="card">
            <h3><?php echo isset($_POST['edit_id']) ? 'Редактировать сертификат' : 'Добавить сертификат'; ?></h3>
            <?php if (isset($_POST['edit_id'])) : ?>
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($_POST['edit_id']); ?>">
            <?php endif; ?>

            <div class="input-group">
                <i class="fas fa-certificate"></i>
                <input type="text" id="title" name="title" placeholder="Название" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="description" name="description" placeholder="Описание" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-image"></i>
                <input type="text" id="image" name="image" placeholder="URL изображения" value="<?php echo isset($_POST['image']) ? htmlspecialchars($_POST['image']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn"><?php echo isset($_POST['edit_id']) ? 'Обновить' : 'Добавить'; ?></button>
        </form>

        <!-- Список существующих сертификатов -->
        <h3>Существующие сертификаты и награды</h3>
        <div class="certificates-grid grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="certificate-item card">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" loading="lazy">
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <a href="certificates_edit.php?id=<?php echo $row['id']; ?>" class="btn">Редактировать</a>
                    <a href="certificates.php?delete_id=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Вы уверены, что хотите удалить этот сертификат?')">Удалить</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
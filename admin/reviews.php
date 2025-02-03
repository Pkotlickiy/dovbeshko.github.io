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
    $author = trim($_POST['author']);
    $text = trim($_POST['text']);
    $image = trim($_POST['image']);

    if (isset($_POST['edit_id'])) {
        // Редактирование существующего отзыва
        $edit_id = intval($_POST['edit_id']); // Защита от некорректных данных
        $sql = "UPDATE reviews SET author = ?, text = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $author, $text, $image, $edit_id);
        $action_message = "Отзыв успешно обновлен.";
    } else {
        // Добавление нового отзыва
        $sql = "INSERT INTO reviews (author, text, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $author, $text, $image);
        $action_message = "Отзыв успешно добавлен.";
    }

    if ($stmt->execute()) {
        echo "<p style='color: green;'>$action_message</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Обработка GET-запроса (удаление)
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Защита от некорректных данных
    $sql = "DELETE FROM reviews WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Отзыв успешно удален.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при удалении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Получение всех отзывов для отображения
$result = $conn->query("SELECT * FROM reviews");
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление "Отзывы клиентов"</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Управление "Отзывы клиентов"</h2>
        <a href="dashboard.php" class="btn">Назад</a>

        <!-- Форма добавления/редактирования -->
        <form action="reviews.php" method="post" class="card">
            <?php if (isset($_POST['edit_id'])) : ?>
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($_POST['edit_id']); ?>">
            <?php endif; ?>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="author" name="author" placeholder="Автор" value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="text" name="text" placeholder="Текст отзыва" required><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-image"></i>
                <input type="text" id="image" name="image" placeholder="URL изображения" value="<?php echo isset($_POST['image']) ? htmlspecialchars($_POST['image']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn"><?php echo isset($_POST['edit_id']) ? 'Обновить' : 'Добавить'; ?></button>
        </form>

        <h3>Существующие отзывы</h3>
        <div class="reviews-grid grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="review-item card">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['author']); ?>" loading="lazy">
                    <p><?php echo htmlspecialchars($row['text']); ?></p>
                    <p><strong><?php echo htmlspecialchars($row['author']); ?></strong></p>
                    <a href="reviews_edit.php?id=<?php echo $row['id']; ?>" class="btn">Редактировать</a>
                    <a href="reviews.php?delete_id=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Вы уверены, что хотите удалить этот отзыв?')">Удалить</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
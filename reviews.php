<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = $_POST['author'];
    $text = $_POST['text'];
    $image = $_POST['image'];

    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $sql = "UPDATE reviews SET author = ?, text = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $author, $text, $image, $edit_id);
    } else {
        $sql = "INSERT INTO reviews (author, text, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $author, $text, $image);
    }

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно обновлены.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM reviews WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно удалены.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при удалении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$result = $conn->query("SELECT * FROM reviews");
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
        <form action="reviews.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="author" name="author" placeholder="Автор" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="text" name="text" placeholder="Текст отзыва" required></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-image"></i>
                <input type="text" id="image" name="image" placeholder="URL изображения" required>
            </div>
            <button type="submit" class="btn">Добавить</button>
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
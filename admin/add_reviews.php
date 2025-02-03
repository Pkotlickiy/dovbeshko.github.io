<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
include '../db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM reviews WHERE id = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = $_POST['author'];
    $text = $_POST['text'];
    $image = $_POST['image'];

    $sql = "UPDATE reviews SET author = ?, text = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $author, $text, $image, $id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно обновлены.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
    header("Location: reviews.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование отзыва</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Редактирование отзыва</h2>
        <a href="dashboard.php" class="btn">Назад</a>
        <form action="reviews_edit.php?id=<?php echo $id; ?>" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="author" name="author" placeholder="Автор" value="<?php echo htmlspecialchars($row['author']); ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="text" name="text" placeholder="Текст отзыва" required><?php echo htmlspecialchars($row['text']); ?></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-image"></i>
                <input type="text" id="image" name="image" placeholder="URL изображения" value="<?php echo htmlspecialchars($row['image']); ?>" required>
            </div>
            <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
            <button type="submit" class="btn">Обновить</button>
        </form>
    </div>
</body>
</html>
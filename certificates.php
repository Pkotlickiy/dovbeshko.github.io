<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $sql = "UPDATE certificates SET title = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $description, $image, $edit_id);
    } else {
        $sql = "INSERT INTO certificates (title, description, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $description, $image);
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
    $sql = "DELETE FROM certificates WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно удалены.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при удалении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$result = $conn->query("SELECT * FROM certificates");
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
        <form action="certificates.php" method="post">
            <div class="input-group">
                <i class="fas fa-certificate"></i>
                <input type="text" id="title" name="title" placeholder="Название" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="description" name="description" placeholder="Описание" required></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-image"></i>
                <input type="text" id="image" name="image" placeholder="URL изображения" required>
            </div>
            <button type="submit" class="btn">Добавить</button>
        </form>

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
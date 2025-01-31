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
    $icon = $_POST['icon'];

    if (isset($_POST['edit_id'])) {
        $edit_id = $_POST['edit_id'];
        $sql = "UPDATE services SET title = ?, description = ?, icon = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $description, $icon, $edit_id);
    } else {
        $sql = "INSERT INTO services (title, description, icon) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $description, $icon);
    }

    if ($stmt->execute()) {
        echo "Данные успешно обновлены.";
    } else {
        echo "Ошибка при обновлении данных: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "Данные успешно удалены.";
    } else {
        echo "Ошибка при удалении данных: " . $stmt->error;
    }

    $stmt->close();
}

$result = $conn->query("SELECT * FROM services");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление "Услуги"</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Управление "Услуги"</h2>
        <a href="dashboard.php" class="btn">Назад</a>
        <form action="services.php" method="post">
            <div class="input-group">
                <i class="fas fa-heading"></i>
                <input type="text" id="title" name="title" placeholder="Название услуги" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="description" name="description" placeholder="Описание услуги" required></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-icons"></i>
                <input type="text" id="icon" name="icon" placeholder="Иконка (например, fas fa-users)" required>
            </div>
            <button type="submit" class="btn">Добавить</button>
        </form>

        <h3>Существующие услуги</h3>
        <div class="services-grid grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="service-item card">
                    <i class="<?php echo htmlspecialchars($row['icon']); ?>"></i>
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <a href="services_edit.php?id=<?php echo $row['id']; ?>" class="btn">Редактировать</a>
                    <a href="services.php?delete_id=<?php echo $row['id']; ?>" class="btn" onclick="return confirm('Вы уверены, что хотите удалить эту услугу?')">Удалить</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
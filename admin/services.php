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
    $icon = trim($_POST['icon']);

    if (isset($_POST['edit_id'])) {
        // Редактирование существующей услуги
        $edit_id = intval($_POST['edit_id']); // Защита от некорректных данных
        $sql = "UPDATE services SET title = ?, description = ?, icon = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $description, $icon, $edit_id);
        $action_message = "Услуга успешно обновлена.";
    } else {
        // Добавление новой услуги
        $sql = "INSERT INTO services (title, description, icon) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $description, $icon);
        $action_message = "Услуга успешно добавлена.";
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
    $sql = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Услуга успешно удалена.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при удалении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Получение всех услуг для отображения
$result = $conn->query("SELECT * FROM services");
$conn->close();
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

        <!-- Форма добавления/редактирования -->
        <form action="services.php" method="post" class="card">
            <?php if (isset($_POST['edit_id'])) : ?>
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($_POST['edit_id']); ?>">
            <?php endif; ?>

            <div class="input-group">
                <i class="fas fa-heading"></i>
                <input type="text" id="title" name="title" placeholder="Название услуги" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-align-left"></i>
                <textarea id="description" name="description" placeholder="Описание услуги" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>
            <div class="input-group">
                <i class="fas fa-icons"></i>
                <input type="text" id="icon" name="icon" placeholder="Иконка (например, fas fa-users)" value="<?php echo isset($_POST['icon']) ? htmlspecialchars($_POST['icon']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn"><?php echo isset($_POST['edit_id']) ? 'Обновить' : 'Добавить'; ?></button>
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
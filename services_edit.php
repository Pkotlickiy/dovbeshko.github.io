<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
include '../db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM services WHERE id = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];

    $sql = "UPDATE services SET title = ?, description = ?, icon = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $icon, $id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Данные успешно обновлены.</p>";
    } else {
        echo "<p style='color: red;'>Ошибка при обновлении данных: " . $stmt->error . "</p>";
    }

    $stmt->close();
    header("Location: services.php");
    exit;
}
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
        <form action="services_edit.php?id=<?php echo $id; ?>" method="post">
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
            <input type="hidden" name="edit_id" value="<?php echo $id; ?>">
            <button type="submit" class="btn">Обновить</button>
        </form>
    </div>
</body>
</html>
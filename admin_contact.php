<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "UPDATE contact SET phone = ?, email = ?, address = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $phone, $email, $address);

    if ($stmt->execute()) {
        echo "Данные успешно обновлены.";
    } else {
        echo "Ошибка при обновлении данных: " . $stmt->error;
    }

    $stmt->close();
}

$result = $conn->query("SELECT * FROM contact WHERE id = 1");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление "Контакты"</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Управление "Контакты"</h2>
        <a href="dashboard.php" class="btn">Назад</a>
        <form action="contact.php" method="post">
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" id="phone" name="phone" placeholder="Телефон" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>
            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <textarea id="address" name="address" placeholder="Адрес" required><?php echo htmlspecialchars($row['address']); ?></textarea>
            </div>
            <button type="submit" class="btn">Обновить</button>
        </form>
    </div>
</body>
</html>
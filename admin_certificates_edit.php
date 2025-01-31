<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
include '../db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM certificates WHERE id = $id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $sql = "UPDATE certificates SET title = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $image, $id);

    if ($stmt->execute()) {
        echo "Данные успешно обновлены.";
    } else {
        echo "Ошибка при обновлении данных: " . $stmt->error;
    }

    $stmt->close();
    header("Location: certificates.php");
    exit;
}
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
        <form action="certificates_edit.php?id=<?php echo $id; ?>" method="post">
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
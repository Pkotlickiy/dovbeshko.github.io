<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Вход в административную панель</h2>
        <form action="login_process.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Логин" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Пароль" required>
            </div>
            <button type="submit" class="btn">Войти</button>
        </form>
    </div>
</body>
</html>
// Подключение к базе данных
$servername = "server39.hosting.reg.ru";
$username = "u2995143_root"; // Имя пользователя базы данных
$password = "Pasha2te2u"; // Пароль базы данных
$dbname = "lawyer_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Хэширование пароля
$hashed_password = password_hash('secure_password', PASSWORD_DEFAULT);

// Вставка пользователя с хэшированным паролем
$sql = "INSERT INTO users (username, password) VALUES ('admin', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "Пользователь успешно добавлен.";
} else {
    echo "Ошибка: " . $conn->error;
}

$conn->close();
?>
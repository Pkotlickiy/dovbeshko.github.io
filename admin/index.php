<?php
// Подключение к базе данных
include 'db.php';

// Получение данных из базы данных
$query_stats = "SELECT * FROM stats WHERE id = 1"; // Убедитесь, что ID существует
$result_stats = $conn->query($query_stats);

if ($result_stats->num_rows === 0) {
    echo "<p style='color: red;'>Статистика не найдена.</p>";
    exit;
}

$stats = $result_stats->fetch_assoc();

$query_reviews = "SELECT * FROM reviews";
$result_reviews = $conn->query($query_reviews);

$query_articles = "SELECT * FROM articles LIMIT 2"; // Ограничение до 2 статей
$result_articles = $conn->query($query_articles);

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Профессиональная юридическая помощь от опытного адвоката. Защита ваших прав и интересов.">
    <meta property="og:title" content="Адвокат Довбешко Светлана Юрьевна">
    <meta property="og:description" content="Профессиональная юридическая помощь от опытного адвоката. Защита ваших прав и интересов.">
    <meta property="og:image" content="images/lawyer-profile.jpg">
    <title>Адвокат Довбешко Светлана Юрьевна</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Мобильное меню -->
    <div class="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Шапка сайта -->
    <header>
        <div class="container">
            <div class="logo">
                <h1>Адвокат Довбешко Светлана Юрьевна</h1>
            </div>
            <nav class="desktop-nav">
                <ul>
                    <li><a href="#home">Главная</a></li>
                    <li><a href="#about">Обо мне</a></li>
                    <li>
                        <a href="#services">Услуги</a>
                        <ul class="dropdown">
                            <li><a href="#family-law">Семейное право</a></li>
                            <li><a href="#civil-law">Гражданское право</a></li>
                            <li><a href="#criminal-law">Уголовное право</a></li>
                            <li><a href="#business-law">Бизнес-право</a></li>
                        </ul>
                    </li>
                    <li><a href="#contact">Контакты</a></li>
                </ul>
            </nav>
            <nav class="mobile-nav">
                <ul>
                    <li><a href="#home">Главная</a></li>
                    <li><a href="#about">Обо мне</a></li>
                    <li><a href="#services">Услуги</a></li>
                    <li><a href="#contact">Контакты</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Главная страница -->
        <section id="home" class="hero">
            <div class="container grid">
                <div class="hero-content">
                    <h2>Профессиональная юридическая помощь</h2>
                    <p>Защита ваших прав и интересов — мой приоритет.</p>
                    <a href="#consultation" class="btn">Получить консультацию</a>
                </div>
                <div class="hero-image">
                    <img src="images/lawyer.svg" alt="Адвокат Довбешко Светлана Юрьевна" loading="lazy">
                </div>
            </div>
        </section>

        <!-- Счетчик успехов -->
        <section id="success-counter" class="success-counter">
            <div class="container grid">
                <div class="counter-item">
                    <span class="number"><?php echo htmlspecialchars($stats['successful_cases']); ?>+</span>
                    <p>Успешных дел</p>
                </div>
                <div class="counter-item">
                    <span class="number"><?php echo htmlspecialchars($stats['experience_years']); ?>+</span>
                    <p>Лет опыта</p>
                </div>
                <div class="counter-item">
                    <span class="number"><?php echo htmlspecialchars($stats['satisfied_clients']); ?>%</span>
                    <p>Довольных клиентов</p>
                </div>
            </div>
        </section>

        <!-- Почему выбирают нас -->
        <section id="why-us" class="why-us">
            <div class="container">
                <h2>Почему выбирают нас?</h2>
                <div class="features grid">
                    <div class="feature card">
                        <i class="fas fa-balance-scale"></i>
                        <h3>Профессионализм</h3>
                        <p>Более 10 лет успешной практики в различных областях права.</p>
                    </div>
                    <div class="feature card">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Защита интересов</h3>
                        <p>Мы защищаем ваши права в любой ситуации, будь то суд или переговоры.</p>
                    </div>
                    <div class="feature card">
                        <i class="fas fa-handshake"></i>
                        <h3>Индивидуальный подход</h3>
                        <p>Каждый клиент получает персональное внимание и стратегию решения проблемы.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Отзывы клиентов -->
        <section id="reviews" class="reviews">
            <div class="container">
                <h2>Отзывы клиентов</h2>
                <div class="review-slider grid">
                    <?php if ($result_reviews->num_rows > 0): ?>
                        <?php while ($review = $result_reviews->fetch_assoc()): ?>
                            <div class="review-card card">
                                <p>"<?php echo htmlspecialchars($review['text']); ?>"</p>
                                <p><strong><?php echo htmlspecialchars($review['author']); ?></strong></p>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Отзывы пока отсутствуют.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Последние статьи -->
        <section id="blog" class="blog">
            <div class="container">
                <h2>Последние статьи</h2>
                <div class="blog-posts grid">
                    <?php if ($result_articles->num_rows > 0): ?>
                        <?php while ($article = $result_articles->fetch_assoc()): ?>
                            <article class="post card">
                                <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" loading="lazy">
                                <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                                <p><?php echo htmlspecialchars($article['excerpt']); ?></p>
                                <a href="<?php echo htmlspecialchars($article['link']); ?>" class="btn">Читать далее</a>
                            </article>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Статьи пока отсутствуют.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Форма консультации -->
        <section id="consultation" class="consultation">
            <div class="container">
                <h2>Получите бесплатную консультацию</h2>
                <form action="/submit-consultation" method="post" class="consultation-form card">
                    <div class="input-group">
                        <label for="name" class="visually-hidden">Имя:</label>
                        <i class="fas fa-user"></i>
                        <input type="text" id="name" name="name" placeholder="Ваше имя" required>
                    </div>
                    <div class="input-group">
                        <label for="phone" class="visually-hidden">Телефон:</label>
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="phone" name="phone" placeholder="Телефон" pattern="+7 ([0-9]{3}) [0-9]{3}-[0-9]{2}-[0-9]{2}" required>
                    </div>
                    <div class="input-group">
                        <label for="message" class="visually-hidden">Сообщение:</label>
                        <i class="fas fa-envelope"></i>
                        <textarea id="message" name="message" placeholder="Сообщение" required></textarea>
                    </div>
                    <button type="submit" class="btn">Отправить</button>
                </form>
            </div>
        </section>
    </main>

    <!-- Футер -->
    <footer>
        <div class="container">
            <p>&copy; 2023 Адвокат Довбешко Светлана Юрьевна. Все права защищены.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-vk"></i></a>
                <a href="#"><i class="fab fa-telegram"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>
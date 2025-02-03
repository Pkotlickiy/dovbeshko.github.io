/* Общие настройки */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f9f9f9;
    color: #333333;
    line-height: 1.6;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.admin-container {
    display: grid;
    grid-template-columns: 250px 1fr; /* Сайдбар + основное содержимое */
    grid-template-rows: auto 1fr auto; /* Заголовок, контент, футер */
    height: 100vh;
}

/* Сайдбар */
.sidebar {
    background: linear-gradient(to bottom, #4A2A1E, #61361B);
    color: #FFB81C;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow-y: auto; /* Прокрутка при переполнении */
}

.sidebar h2 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.sidebar ul {
    list-style: none;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    color: #FFB81C;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
    font-size: 1.4rem;
}

.sidebar ul li a:hover {
    color: #FFD700;
}

/* Основное содержимое */
.content {
    display: grid;
    grid-template-rows: auto 1fr auto; /* Заголовок, контент, футер */
    padding: 20px;
    background-color: #FFFFFF;
    overflow-y: auto;
    scroll-behavior: smooth; /* Плавная прокрутка */
}

.header {
    background: linear-gradient(to right, #FFB81C, #FFD700);
    color: #333333;
    padding: 20px;
    text-align: center;
    border-radius: 5px;
    margin-bottom: 20px;
    word-wrap: break-word; /* Предотвращение переполнения текста */
}

.header h1 {
    font-size: 2.4rem;
    font-weight: bold;
}

.dashboard {
    padding: 20px;
}

.dashboard-content {
    padding: 20px;
    background: #f1f1f1;
    border-radius: 5px;
    margin-bottom: 20px;
}

.quick-links {
    background: #FFFFFF;
    padding: 20px;
    border-radius: 5px;
}

.quick-links h2 {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.quick-link {
    background: #FFB81C;
    color: #FFFFFF;
    padding: 15px;
    border-radius: 5px;
    text-align: center;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.quick-link a {
    color: #FFFFFF;
    text-decoration: none;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.quick-link a:hover {
    transform: scale(1.05);
}

.quick-link i {
    font-size: 2rem;
}

/* Футер */
.footer {
    text-align: center;
    padding: 10px;
    background: #f9f9f9;
    border-top: 1px solid #ddd;
    font-size: 1.4rem;
}

/* Адаптивность */
@media (max-width: 768px) {
    .admin-container {
        grid-template-columns: 1fr; /* Только один столбец на маленьких экранах */
    }

    .sidebar {
        display: none; /* Скрываем сайдбар на мобильных устройствах */
    }

    .header h1 {
        font-size: 2rem; /* Уменьшаем размер заголовка */
    }

    .dashboard-content {
        padding: 15px; /* Уменьшаем отступы в контенте */
    }

    .quick-links {
        padding: 15px;
    }

    .quick-link {
        padding: 10px;
    }
}

@media (max-width: 480px) {
    .header h1 {
        font-size: 1.6rem; /* Дальнейшее уменьшение заголовка */
    }

    .dashboard-content {
        padding: 10px; /* Еще меньше отступов */
    }

    .quick-links {
        padding: 10px;
    }

    .quick-link {
        padding: 10px;
    }
}
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta property="og:title" content="<?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/lawyer-profile.jpg">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Мобильное меню -->
    <div class="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Шапка сайта -->
    <header>
        <div class="container">
            <div class="logo">
                <?php the_custom_logo(); ?>
                <h1><?php bloginfo('name'); ?></h1>
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
                    <li><a href="admin/login.php" class="btn">Админ панель</a></li>
                </ul>
            </nav>
            <nav class="mobile-nav">
                <ul>
                    <li><a href="#home">Главная</a></li>
                    <li><a href="#about">Обо мне</a></li>
                    <li><a href="#services">Услуги</a></li>
                    <li><a href="#contact">Контакты</a></li>
                    <li><a href="admin/login.php" class="btn">Админ панель</a></li>
                </ul>
            </nav>
        </div>
    </header>
// Мобильное меню
document.querySelector('.mobile-menu').addEventListener('click', function () {
    const mobileNav = document.querySelector('.mobile-nav');
    mobileNav.style.display = mobileNav.style.display === 'block' ? 'none' : 'block';
});

// Валидация формы
document.getElementById('consultation').addEventListener('submit', function (event) {
    const name = document.getElementById('name');
    const phone = document.getElementById('phone');
    const message = document.getElementById('message');

    if (!name.value.trim()) {
        alert('Пожалуйста, заполните поле "Имя".');
        event.preventDefault();
    } else if (!phone.value.match(/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/)) {
        alert('Пожалуйста, введите корректный телефон (например, +7 (999) 123-45-67).');
        event.preventDefault();
    } else if (!message.value.trim()) {
        alert('Пожалуйста, заполните поле "Сообщение".');
        event.preventDefault();
    }
});
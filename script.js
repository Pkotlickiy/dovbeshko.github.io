// Мобильное меню
document.querySelector('.mobile-menu').addEventListener('click', function() {
    const mobileNav = document.querySelector('.mobile-nav');
    mobileNav.style.display = mobileNav.style.display === 'block' ? 'none' : 'block';
});

// Слайдер отзывов
let currentSlide = 0;
const slides = document.querySelectorAll('.review-card');
const totalSlides = slides.length;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.transform = `translateX(${(i - index) * 100}%)`;
    });
}

document.querySelector('.next-btn').addEventListener('click', () => {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
});

document.querySelector('.prev-btn').addEventListener('click', () => {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
});

// Инициализация
showSlide(currentSlide);

// Валидация формы
document.getElementById('consultation').addEventListener('submit', function(event) {
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
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
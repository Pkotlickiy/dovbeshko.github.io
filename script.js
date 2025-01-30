document.getElementById('uploadForm').addEventListener('submit', function(event) {
    const name = document.getElementById('name');
    const email = document.getElementById('email');

    if (!name.value || !email.value) {
        alert('Пожалуйста, заполните все поля.');
        event.preventDefault();
    } else if (!validateEmail(email.value)) {
        alert('Пожалуйста, введите корректный email.');
        event.preventDefault();
    }
});

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
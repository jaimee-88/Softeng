const loginButton = document.getElementById('loginButton');
const loginForm = document.getElementById('login');

document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.querySelector('.wrapper select');
    
    selectElement.addEventListener('click', function() {
        if (selectElement.classList.contains('rotate')) {
            selectElement.classList.remove('rotate');
            selectElement.classList.add('rotate-back');
        } else {
            selectElement.classList.remove('rotate-back');
            selectElement.classList.add('rotate');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('department-select');
    const labelElement = document.getElementById('department-label');

    selectElement.addEventListener('change', function() {
        if (selectElement.value) {
            labelElement.classList.add('valid');
        } else {
            labelElement.classList.remove('valid');
        }
    });
});
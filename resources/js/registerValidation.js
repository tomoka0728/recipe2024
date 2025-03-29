document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('name');
    const nameErrorElement = document.getElementById('name-error');
    const nicknameInput = document.getElementById('nickname');
    const nicknameErrorElement = document.getElementById('nickname-error');
    const emailInput = document.getElementById('email');
    const emailErrorElement = document.getElementById('email-error');
    const passwordInput = document.getElementById('password');
    const passwordErrorElement = document.getElementById('password-error');
    const checkbox = document.getElementById('link-checkbox');
    const errorElement = document.getElementById('terms-error');

    checkbox.addEventListener('change', function () {
        if (checkbox.checked) {
            errorElement.style.display = 'none';
            checkboxInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            errorElement.style.display = 'block';
            checkboxInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    nameInput.addEventListener('input', function () {
        if (nameInput.value.trim() !== '') {
            nameErrorElement.style.display = 'none';
            nameInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            nameErrorElement.style.display = 'block';
            nameInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    nicknameInput.addEventListener('input', function () {
        if (nicknameInput.value.trim() !== '') {
            nicknameErrorElement.style.display = 'none';
            nicknameInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            nicknameErrorElement.style.display = 'block';
            nicknameInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    emailInput.addEventListener('input', function () {
        if (emailInput.value.trim() !== '') {
            emailErrorElement.style.display = 'none';
            emailInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            emailErrorElement.style.display = 'block';
            emailInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    passwordInput.addEventListener('input', function () {
        if (passwordInput.value.trim() !== '') {
            passwordErrorElement.style.display = 'none';
            passwordInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            passwordErrorElement.style.display = 'block';
            passwordInput.classList.add('border-red-500', 'bg-red-100');
        }
    });
});
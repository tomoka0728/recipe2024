document.addEventListener('DOMContentLoaded', function () {
    const zipcodeInput = document.getElementById('zipcode');
    const zipcodeErrorElement = document.getElementById('zipcode-error');
    const prefecturesInput = document.getElementById('prefectures');
    const prefecturesErrorElement = document.getElementById('prefectures-error');
    const cityInput = document.getElementById('city');
    const cityErrorElement = document.getElementById('city-error');
    const addressInput = document.getElementById('address');
    const addressErrorElement = document.getElementById('address-error');
    const phoneInput = document.getElementById('phone');
    const phoneErrorElement = document.getElementById('phone-error');

    zipcodeInput.addEventListener('input', function () {
        if (/^\d{7}$/.test(zipcodeInput.value.trim())) {
            zipcodeErrorElement.style.display = 'none';
            zipcodeInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            zipcodeErrorElement.style.display = 'block';
            zipcodeInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    prefecturesInput.addEventListener('change', function () {
        if (prefecturesInput.value.trim() !== '') {
            prefecturesErrorElement.style.display = 'none';
            prefecturesInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            prefecturesErrorElement.style.display = 'block';
            prefecturesInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    cityInput.addEventListener('input', function () {
        if (cityInput.value.trim() !== '') {
            cityErrorElement.style.display = 'none';
            cityInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            cityErrorElement.style.display = 'block';
            cityInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    addressInput.addEventListener('input', function () {
        if (addressInput.value.trim() !== '') {
            addressErrorElement.style.display = 'none';
            addressInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            addressErrorElement.style.display = 'block';
            addressInput.classList.add('border-red-500', 'bg-red-100');
        }
    });

    phoneInput.addEventListener('input', function () {
        if (/^\d{10,11}$/.test(phoneInput.value.trim())) {
            phoneErrorElement.style.display = 'none';
            phoneInput.classList.remove('border-red-500', 'bg-red-100');
        } else {
            phoneErrorElement.style.display = 'block';
            phoneInput.classList.add('border-red-500', 'bg-red-100');
        }
    });
});

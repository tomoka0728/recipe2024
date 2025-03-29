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

    function validateInput(input, errorElement, condition) {
        if (condition(input.value.trim())) {
            errorElement.style.display = 'none';
            input.classList.remove('border-red-500', 'bg-red-100');
        } else {
            errorElement.style.display = 'block';
            input.classList.add('border-red-500', 'bg-red-100');
        }
    }

    zipcodeInput.addEventListener('input', function () {
        validateInput(zipcodeInput, zipcodeErrorElement, value => value !== '');
    });

    prefecturesInput.addEventListener('change', function () {
        validateInput(prefecturesInput, prefecturesErrorElement, value => value !== '');
    });

    cityInput.addEventListener('input', function () {
        validateInput(cityInput, cityErrorElement, value => value !== '');
    });

    addressInput.addEventListener('input', function () {
        validateInput(addressInput, addressErrorElement, value => value !== '');
    });

    phoneInput.addEventListener('input', function () {
        validateInput(phoneInput, phoneErrorElement, value => /^\d{10,11}$/.test(value));
    });
});

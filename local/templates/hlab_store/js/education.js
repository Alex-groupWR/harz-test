document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('educationForm');
    const successMessage = document.querySelector('.education__success-message');
    const errorMessage = document.querySelector('.education__error-message');
    const errorTitle = document.querySelector('.education__error-message h3');
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
        if (field.type !== 'checkbox') {
            field.addEventListener('input', function() {
                validateField(this);
            });
            field.addEventListener('blur', function() {
                validateField(this);
            });
        }
        else {
            field.addEventListener('change', function() {
                validateField(this);
            });
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        resetAllErrors();

        let isValid = true;

        requiredFields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });

        if (isValid) {
            sendFormToBitrix24(form);
        }

        return false;
    });

    function resetAllErrors() {
        requiredFields.forEach(field => {
            const errorElement = getErrorElement(field);
            hideError(field, errorElement);
        });
    }

    function validateField(field) {
        const errorElement = getErrorElement(field);
        let isValid = false;

        if (field.type === 'checkbox') {
            isValid = field.checked;
        } else {
            isValid = field.value.trim() !== '' && field.checkValidity();
        }

        if (!isValid) {
            showError(field, errorElement);
            return false;
        }

        hideError(field, errorElement);
        return true;
    }

    function getErrorElement(field) {
        if (field.type === 'checkbox') {
            return field.closest('.education__agree').querySelector('.education__error');
        }
        return field.closest('.education__field').querySelector('.education__error');
    }

    function showError(field, errorElement) {
        errorElement.textContent = getErrorMessage(field);
        errorElement.style.display = 'block';

        if (field.type === 'checkbox') {
            field.closest('.education__checkbox-label').classList.add('invalid');
        } else {
            field.classList.add('invalid');
        }
    }

    function hideError(field, errorElement) {
        errorElement.style.display = 'none';

        if (field.type === 'checkbox') {
            field.closest('.education__checkbox-label').classList.remove('invalid');
        } else {
            field.classList.remove('invalid');
        }
    }

    function getErrorMessage(field) {
        if (field.type === 'checkbox' && !field.checked) {
            return 'Это поле обязательно для заполнения';
        }
        if (field.value.trim() === '') {
            return 'Это поле обязательно для заполнения';
        }
        if (field.validity.typeMismatch && field.type === 'email') {
            return 'Введите корректный email';
        }
        return 'Неверное значение';
    }

    function sendFormToBitrix24(form) {
        const formData = new FormData(form);

        fetch('/local/scripts/send_lead_2cifra.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (!data || data.status !== 'success') {
                    throw new Error(data.message || 'Ошибка сервера');
                }

                form.style.display = 'none';
                successMessage.style.display = 'block';
            })
            .catch(error => {
                form.style.display = 'none';
                errorTitle.textContent = error.message;
                errorMessage.style.display = 'block';
                console.error('Error:', error);
            });
    }
});
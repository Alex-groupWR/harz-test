jQuery(document).ready(function($) {
    const dt = new DataTransfer();

    // Функции для создания модальных окон (теперь создаются при каждом вызове)
    function createCouponModal(couponCode) {
        const modalId = 'couponModal_' + Date.now();

        $('body').append(`
            <div id="${modalId}" class="rate-us__modal">
                <div class="rate-us__modal-overlay"></div>
                <div class="rate-us__modal-content">
                    <div class="rate-us__modal-body">
                        <h2 class="rate-us__main-title">Thank you!</h2>
                        <p class="rate-us__subtitle">Personal promo code for a 5% discount  Valid for one-time use only</p>
                        <p class="rate-us__coupon-instruction">Click on it to copy</p>

                        <div class="rate-us__coupon-container">
                            <div class="rate-us__coupon-code">${couponCode}</div>
                            <div class="rate-us__copied-message">
                              <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 0C2.23857 0 0 2.23857 0 5C0 7.76143 2.23857 10 5 10C7.76143 10 10 7.76143 10 5C10 2.23857 7.76143 0 5 0ZM7.14538 2.34192L8.18419 3.38073L4.93958 6.62598L3.90686 7.65808L2.86804 6.61927L1.81579 5.5664L2.8479 4.53429L3.90015 5.58715L7.14538 2.34192Z" fill="#3ADA3F"/>
                              </svg>
                              сopied!
                            </div>
                        </div>
                        <button class="rate__btn rate__btn--close">Сlose</button>
                    </div>
                </div>
            </div>
        `);

        // Обработчики для этой конкретной модалки
        $(`#${modalId} .rate__btn--close, #${modalId} .rate-us__modal-overlay`).on('click', function() {
            removeModal(modalId);
        });

        // Обработчик копирования для этой модалки
        $(`#${modalId} .rate-us__coupon-code`).on('click', function() {
            const couponCode = $(this).text();
            const copiedMessage = $(this).siblings('.rate-us__copied-message');

            navigator.clipboard.writeText(couponCode).then(() => {
                copiedMessage.addClass('show');
            }).catch(err => {
                console.error('Ошибка копирования: ', err);
            });
        });

        // Закрытие по ESC
        $(document).on('keydown.modal' + modalId, function(e) {
            if (e.key === 'Escape') {
                removeModal(modalId);
            }
        });

        return modalId;
    }

    function createRepeatCouponModal(couponCode) {
        const modalId = 'repeatCouponModal_' + Date.now();

        $('body').append(`
            <div id="${modalId}" class="rate-us__modal">
                <div class="rate-us__modal-overlay"></div>
                <div class="rate-us__modal-content">
                    <div class="rate-us__modal-body">
                        <p class="rate-us__subtitle">The promo code has already been received</p>
                        <p class="rate-us__coupon-instruction">Click on it to copy</p>

                        <div class="rate-us__coupon-container">
                            <div class="rate-us__coupon-code">${couponCode}</div>
                            <div class="rate-us__copied-message">
                              <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 0C2.23857 0 0 2.23857 0 5C0 7.76143 2.23857 10 5 10C7.76143 10 10 7.76143 10 5C10 2.23857 7.76143 0 5 0ZM7.14538 2.34192L8.18419 3.38073L4.93958 6.62598L3.90686 7.65808L2.86804 6.61927L1.81579 5.5664L2.8479 4.53429L3.90015 5.58715L7.14538 2.34192Z" fill="#3ADA3F"/>
                              </svg>
                              сopied!
                            </div>
                        </div>
                        <button class="rate__btn rate__btn--close">Сlose</button>
                    </div>
                </div>
            </div>
        `);

        // Обработчики для этой конкретной модалки
        $(`#${modalId} .rate__btn--close, #${modalId} .rate-us__modal-overlay`).on('click', function() {
            removeModal(modalId);
        });

        // Обработчик копирования для этой модалки
        $(`#${modalId} .rate-us__coupon-code`).on('click', function() {
            const couponCode = $(this).text();
            const copiedMessage = $(this).siblings('.rate-us__copied-message');

            navigator.clipboard.writeText(couponCode).then(() => {
                copiedMessage.addClass('show');
            }).catch(err => {
                console.error('Ошибка копирования: ', err);
            });
        });

        // Закрытие по ESC
        $(document).on('keydown.modal' + modalId, function(e) {
            if (e.key === 'Escape') {
                removeModal(modalId);
            }
        });

        return modalId;
    }

    function createThanksModal() {
        const modalId = 'thanksModal_' + Date.now();

        $('body').append(`
            <!-- Модальное окно для благодарности (без купона) -->
            <div id="${modalId}" class="rate-us__modal">
                <div class="rate-us__modal-overlay"></div>
                <div class="rate-us__modal-content">
                    <div class="rate-us__modal-body">
                        <p class="rate-us__subtitle">The promo code is no longer valid</p>
                        <button class="rate__btn rate__btn--close">Сlose</button>
                    </div>        
                </div>
            </div>
        `);

        // Обработчики для этой конкретной модалки
        $(`#${modalId} .rate__btn--close, #${modalId} .rate-us__modal-overlay`).on('click', function() {
            removeModal(modalId);
        });

        // Закрытие по ESC
        $(document).on('keydown.modal' + modalId, function(e) {
            if (e.key === 'Escape') {
                removeModal(modalId);
            }
        });

        return modalId;
    }

    function createErrorModal(errorMessage) {
        const modalId = 'errorModal_' + Date.now();

        $('body').append(`
            <!-- Модальное окно для ошибки -->
            <div id="${modalId}" class="rate-us__modal">
                <div class="rate-us__modal-overlay"></div>
                <div class="rate-us__modal-content">
                    <div class="rate-us__modal-body">
                        <h2 class="rate-us__main-title-error">Error</h2>
                        <p class="rate-us__subtitle">The order number and email do not match.<br>Please check the information you entered</p>
                        <p class="rate-us__coupon-instruction">Please enter the email address used for this order. If <br>you have any questions, contact us at<br>info@harzlabs.com.</p>
                        <button class="rate__btn rate__btn--close">Сlose</button>
                    </div>        
                </div>
            </div>
        `);

        // Обработчики для этой конкретной модалки
        $(`#${modalId} .rate__btn--close, #${modalId} .rate-us__modal-overlay`).on('click', function() {
            removeModal(modalId);
        });

        // Закрытие по ESC
        $(document).on('keydown.modal' + modalId, function(e) {
            if (e.key === 'Escape') {
                removeModal(modalId);
            }
        });

        return modalId;
    }

    // Функция для удаления модального окна
    function removeModal(modalId) {
        const $modal = $('#' + modalId);
        if ($modal.length) {
            // Удаляем обработчики событий
            $(document).off('keydown.modal' + modalId);
            // Удаляем модалку из DOM
            $modal.remove();
            // Восстанавливаем скролл
            $('body').css('overflow', '');
        }
    }

    // Функции для показа модальных окон
    function showCouponModal(couponCode) {
        const modalId = createCouponModal(couponCode);
        $('#' + modalId).show();
        $('body').css('overflow', 'hidden');
    }

    function showRepeatCouponModal(couponCode) {
        const modalId = createRepeatCouponModal(couponCode);
        $('#' + modalId).show();
        $('body').css('overflow', 'hidden');
    }

    function showThanksModal() {
        const modalId = createThanksModal();
        $('#' + modalId).show();
        $('body').css('overflow', 'hidden');
    }

    function showErrorModal(errorMessage) {
        const modalId = createErrorModal(errorMessage);
        $('#' + modalId).show();
        $('body').css('overflow', 'hidden');
    }

    // Существующий код работы с файлами
    $('.input-file input[type=file]').on('change', function () {
        let $files_list = $(this).closest('.input-file').find('.rate-us__file-list');
        $files_list.empty();

        // Очищаем предыдущие файлы
        dt.items.clear();

        for (var i = 0; i < this.files.length; i++) {
            let new_file_input = '' +
                '<span class="input-file-list-name">' + this.files.item(i).name + '</span>' +
                '';
            $files_list.append(new_file_input);
            dt.items.add(this.files.item(i));
        }

        this.files = dt.files;
    });

    // Существующая логика отображения/скрытия блоков
    $('input[type=radio][name=material]').on('change', function() {
        const materialVal = $(this).val();
        if (materialVal > 8 ) {
            $('.rate-us__problems').css('display', 'none')
        } else {
            $('.rate-us__problems').css('display', 'block')
        }
    });

    $('input[type=checkbox][name=problem]').each(function(i, input) {
        $(input).on('change', function() {
            const problemVal = $(this).val();
            const problemChecked =  $(this).is(':checked')
            $('input[type=checkbox][name=problem]').each(function(i) {
                if ($(this).val() !== problemVal) {
                    $(this).prop('checked', false);
                }
            })

            if (problemVal == 'no' && problemChecked) {
                $('.rate-us__problem--no').css('display', 'block')
            } else {
                $('.rate-us__problem--no').css('display', 'none')
            }

            if (problemVal == 'yes' && problemChecked) {
                $('#tech').css('display', 'block')
            } else {
                $('#tech').css('display', 'none')
            }
        });
    })

    // Функция для преобразования файла в base64 (БЕЗ ПРЕФИКСА)
    function fileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                // Убираем префикс "data:image/png;base64," и оставляем только чистый base64
                const base64WithPrefix = reader.result;
                const base64Clean = base64WithPrefix.split(',')[1];
                resolve(base64Clean);
            };
            reader.onerror = error => reject(error);
        });
    }

    // Функция для подготовки файлов в формате массива объектов
    async function prepareFilesData(files) {
        const filesData = [];

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            try {
                const base64Data = await fileToBase64(file);
                // Создаем объект с полями name и base64 (чистый base64 без префикса)
                filesData.push({
                    name: file.name,
                    base64: base64Data
                });
            } catch (error) {
                console.error('Ошибка при преобразовании файла в base64:', error);
                // В случае ошибки все равно добавляем файл, но с пустыми данными
                filesData.push({
                    name: file.name,
                    base64: ''
                });
            }
        }

        return filesData;
    }

    // ОБНОВЛЕННЫЙ обработчик отправки формы
    $( ".rate-us__form" ).on( "submit", async function( event ) {
        event.preventDefault();
        const material = $('input[type=radio][name=material]:checked').val()
        const materialCh = $('input[type=radio][name=material]').is(':checked')
        const materialProblem = $('input[type=checkbox][name=problem]:checked').val()
        const techSupport = $('input[type=radio][name=technicalSupport]:checked').val()
        const techSupportCh = $('input[type=radio][name=technicalSupport]').is(':checked')
        const sales = $('input[type=radio][name=sales]:checked').val()
        const delivery = $('input[type=radio][name=delivery]:checked').val()
        const deliveryCh = $('input[type=radio][name=delivery]').is(':checked')
        const comment = $('textarea[name="comment"]').val();
        const errorsRate = $('.rate-us__errors_rates')
        const errorsFields = $('.rate-us__errors_fields')
        const errorsTextRate = errorsRate.find('span')
        const errorsTextFields = errorsFields.find('span')
        const lang = $('[data-lang]').attr('data-lang')
        const files = $('.rate-us__file')[0].files
        const order = $('input[name=order]').val()
        const email = $('input[name=email]').val()
        const phone = $('input[name=phone]').val()

        const errorsForRate = []
        const errorsForFields = []
        errorsTextRate.text('')
        errorsTextFields.text('')
        errorsRate.css('display', 'none')
        errorsFields.css('display', 'none')

        if (!materialCh) {
            errorsForRate.push(
                $('input[type=radio][name=material]').closest('.rate-us__mini-section').find('h2').text()
            )
        }

        if (material < 10 && materialCh && materialProblem == 'yes' && !techSupportCh) {
            errorsForRate.push(
                $('input[type=radio][name=technicalSupport]').closest('.rate-us__mini-section').find('h2').text()
            )
        }

        if (!deliveryCh) {
            errorsForRate.push(
                $('input[type=radio][name=delivery]').closest('.rate-us__mini-section').find('h2').text()
            )
        }

        // ПРОВЕРКА НОМЕРА ЗАКАЗА
        if (!order) {
            errorsForFields.push('Order number')
        }

        // ПРОВЕРКА EMAIL
        if (!email) {
            errorsForFields.push('Email')
        } else if (!isValidEmail(email)) {
            errorsForFields.push('Correct email')
        }

        if (errorsForRate.length || errorsForFields.length) {
            if (errorsForRate.length){
                errorsRate.css('display', 'block')
                let text = '';
                errorsForRate.map((err, i) => {
                    let nextSep = i == errorsForRate.length - 1 ? '' : ', '
                    text += '"' + err + '"' + nextSep
                })
                errorsTextRate.text(text)
            }
            if (errorsForFields.length){
                errorsFields.css('display', 'block')
                let text = '';
                errorsForFields.map((err, i) => {
                    let nextSep = i == errorsForFields.length - 1 ? '' : ', '
                    text += '"' + err + '"' + nextSep
                })
                errorsTextFields.text(text)
            }

        } else {
            errorsRate.css('display', 'none')
            errorsFields.css('display', 'none')

            // Показываем индикатор загрузки
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.text('Отправка...').prop('disabled', true);

            try {
                // Подготавливаем файлы в формате массива объектов
                const filesData = await prepareFilesData(files);

                // Подготавливаем данные для нового обработчика
                const formData = new FormData();
                formData.append('order', order);
                formData.append('email', email);
                formData.append('phone', phone);
                formData.append('material', material || '');
                formData.append('technicalSupport', techSupport || '');
                formData.append('sales', sales || '');
                formData.append('delivery', delivery || '');
                formData.append('comment', comment || '');
                formData.append('problem', materialProblem || '');
                formData.append('lang', lang);

                // Добавляем файлы как массив объектов
                filesData.forEach((fileObj, index) => {
                    formData.append(`files[${index}][name]`, fileObj.name);
                    formData.append(`files[${index}][base64]`, fileObj.base64);
                });

                console.log('Отправляемые данные files:', filesData);
                console.log('Количество файлов:', filesData.length);
                console.log('Пример base64 (первые 50 символов):', filesData[0]?.base64?.substring(0, 50) + '...');

                // Отправляем на обработчик для проверки заказа и генерации купона
                $.ajax({
                    type: 'POST',
                    url: '/support/rate-us/ajax.php',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(result){
                        console.log('Результат от нового обработчика:', result);

                        // Восстанавливаем кнопку
                        submitBtn.text(originalText).prop('disabled', false);

                        // Обрабатываем ответ в зависимости от результата
                        if (result.success) {
                            if (result.has_coupon && result.coupon && !result.repeatReq) {
                                // Первый запрос - показываем обычное модальное окно с купоном
                                showCouponModal(result.coupon);
                            }
                            else if (result.has_coupon && result.coupon && result.repeatReq) {
                                // Повторный запрос - показываем специальное модальное окно с купоном
                                showRepeatCouponModal(result.coupon);
                            }
                            else {
                                // Нет купона - показываем модальное окно с благодарностью
                                showThanksModal();
                            }
                        } else {
                            // Ошибка - показываем модальное окно с ошибкой
                            showErrorModal(result.message);
                        }
                    },
                    error: function(xhr, status, error){
                        console.error('Ошибка AJAX:', error);

                        // Восстанавливаем кнопку
                        submitBtn.text(originalText).prop('disabled', false);

                        // Показываем модальное окно с ошибкой
                        showErrorModal('Произошла ошибка при отправке формы. Пожалуйста, попробуйте позже.');
                    }
                });

            } catch (error) {
                console.error('Ошибка при подготовке файлов:', error);
                submitBtn.text(originalText).prop('disabled', false);
                showErrorModal('Ошибка при обработке файлов. Пожалуйста, попробуйте еще раз.');
            }
        }
    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
<?php
// Включаем отображение ошибок для отладки (удалите эти 2 строки, когда всё заработает)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Подтверждение согласия");

use Bitrix\Main\Context;
use Bitrix\Main\Loader;

// Безопасное подключение модулей
if (!Loader::includeModule('crm') || !Loader::includeModule('bizproc')) {
    $error = "Ошибка системы: не удалось подключить необходимые модули CRM/Bizproc.";
}

$request = Context::getCurrent()->getRequest();

// Проверяем ID сделки в GET и POST
$dealId = intval($request->getQuery("deal_id"));
if ($dealId <= 0) {
    $dealId = intval($request->getPost("deal_id"));
}

$success = false;
if (!isset($error)) {
    $error = "";
}

if ($request->isPost() && check_bitrix_sessid() && empty($error)) {
    $dealIdPost = intval($request->getPost("deal_id"));

    if ($request->getPost("accept_privacy") === "Y" && $dealIdPost > 0) {

        $templateId = 692; // ID вашего БП
        $documentId = ['crm', 'CCrmDocumentDeal', 'DEAL_' . $dealIdPost];
        $bpResultSuccess = false;

        // ПРОВЕРКА: Поддерживает ли ваша коробка новый API D7?
        if (class_exists('\Bitrix\Bizproc\Workflow\StartWorkflowService')) {
            // Современный метод D7
            $service = \Bitrix\Bizproc\Workflow\StartWorkflowService::getInstance();
            $bpResult = $service->startWorkflow($templateId, $documentId, []);
            
            if ($bpResult->isSuccess()) {
                $bpResultSuccess = true;
            } else {
                $error = "Ошибка запуска БП (D7): " . implode(', ', $bpResult->getErrorMessages());
            }
        } else {
            // Старый альтернативный метод для старых версий коробки
            $arErrorsTmp = [];
            $wfId = CBPDocument::StartWorkflow(
                $templateId,
                $documentId,
                array_merge([], ["TargetUser" => "author"]),
                $arErrorsTmp
            );

            if (empty($arErrorsTmp)) {
                $bpResultSuccess = true;
            } else {
                $error = "Ошибка запуска БП (Legacy): " . implode(', ', $arErrorsTmp);
            }
        }

        // Если БП успешно стартовал
        if ($bpResultSuccess) {
            $success = true;
        }

    } else {
        $error = "Необходимо принять условия конфиденциальности.";
    }
}
?>


    <!-- Обертка для решения проблемы с футером (растягивает блок на 60% высоты экрана и центрирует) -->
    <div style="min-height: 60vh; display: flex; align-items: center; justify-content: center; padding: 40px 15px; background-color: #fafafa;">

        <!-- Карточка с контентом -->
        <div style="width: 100%; max-width: 500px; padding: 40px; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center;">

            <?php if ($success): ?>
                <!-- Экран успеха (после нажатия кнопки) -->
                <h3 style="color: #27ae60; margin-top: 0; font-size: 24px;">Спасибо!</h3>
                <p style="color: #333; line-height: 1.5; margin-bottom: 0; font-size: 16px;">
                    Согласие подтверждено.<br>
                    Счет будет отправлен на вашу электронную почту в течение нескольких минут.<br><br>
                    Вы можете закрыть эту страницу.
                </p>

            <?php elseif ($dealId > 0): ?>
                <!-- Экран формы (при переходе из письма) -->
                <h2 style="color: #6c4098; margin-top: 0; margin-bottom: 20px;">Получение счета</h2>

                <p style="color: #555; font-size: 15px; margin-bottom: 25px;">
                    Для получения счета, пожалуйста, подтвердите согласие на обработку данных.
                </p>

            <?php if (!empty($error)): ?>
                <p style="color: #d9534f; background: #fdf7f7; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                    <?= $error ?>
                </p>
            <?php endif; ?>

                <!-- Пустой action заставит браузер отправить форму точно на этот же URL с сохранением параметров -->
                <form method="POST" action="">
                    <!-- Системная защита Битрикс от подделки запросов -->
                    <?= bitrix_sessid_post() ?>

                    <!-- Скрытое поле с ID сделки -->
                    <input type="hidden" name="deal_id" value="<?= $dealId ?>">

                    <div style="text-align: left; margin-bottom: 25px;">
                        <label style="cursor: pointer; display: flex; align-items: flex-start; line-height: 1.4;">
                            <input type="checkbox" name="accept_privacy" value="Y" required
                                   style="margin-top: 3px; margin-right: 10px; width: 16px; height: 16px;">
                            <span style="font-size: 14px; color: #333;">
                            Я даю согласие на <a href="/about/152-fz.php" target="_blank"
                                                 style="color: #6c4098; text-decoration: underline;">обработку персональных данных</a>
                        </span>
                        </label>
                    </div>

                    <button type="submit" id="submit_btn"
                            style="width: 100%; background: #6c4098; color: #fff; padding: 15px; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; transition: opacity 0.3s;">
                        Подтвердить и отправить счет
                    </button>
                </form>

                <!-- Скрипт для визуальной блокировки кнопки до нажатия галочки -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var checkbox = document.querySelector('input[name="accept_privacy"]');
                        var button = document.getElementById('submit_btn');

                        function toggleButton() {
                            if (checkbox && checkbox.checked) {
                                button.style.opacity = '1';
                                button.style.cursor = 'pointer';
                            } else if (button) {
                                button.style.opacity = '0.5';
                                button.style.cursor = 'not-allowed';
                            }
                        }

                        if (checkbox && button) {
                            toggleButton();
                            checkbox.addEventListener('change', toggleButton);
                        }
                    });
                </script>

            <?php else: ?>
                <!-- Экран ошибки (если перешли без deal_id в ссылке) -->
                <h3 style="color: #d9534f; margin-top: 0;">Ошибка доступа</h3>
                <p style="color: #333; margin-bottom: 0;">
                    Счет не найден. Пожалуйста, перейдите по корректной ссылке из вашего письма.
                </p>
            <?php endif; ?>

        </div>
    </div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>

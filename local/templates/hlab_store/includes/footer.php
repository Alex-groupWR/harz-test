<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<div class="footer">
    <div class="footer__wrapper">
        <div class="footer__top">
            <div class="footer__inner footer__inner--top">
                <div class="footer__logo">
                    <a href="/">
                        <img class="" src="<?= SITE_TEMPLATE_PATH ?>/images/harzlabs1.svg" alt="">
                    </a>
                </div>
                <div class="footer__box">
                    <span class="footer__desc footer__desc--arrow js-toggle-footer-list">
                        <?= Loc::getMessage('Company') ?>
                    </span>
                    <ul class="list list--toggle">
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "footer_items", Array(
                            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                            "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                            "DELAY" => "Y",	// Откладывать выполнение шаблона меню
                            "MAX_LEVEL" => "1",	// Уровень вложенности меню
                            "MENU_CACHE_GET_VARS" => array(	// Значимые переменные запроса
                                0 => "",
                            ),
                            "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                            "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                            "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                            "ROOT_MENU_TYPE" => "top".SITE_LANG,	// Тип меню для первого уровня
                            "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                        ),
                            false
                        );?>
                    </ul>
                </div>

                <div class="footer__box">
                    <span class="footer__desc footer__desc--arrow js-toggle-footer-list">
                        <?= Loc::getMessage('Products') ?>
                    </span>
                    <?$APPLICATION->IncludeComponent("bitrix:news.list", "footer_toinfo1", Array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"ADD_SECTIONS_CHAIN" => "Y",	// Включать раздел в цепочку навигации
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DISPLAY_DATE" => "Y",	// Выводить дату элемента
		"DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
		"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"FIELD_CODE" => array(	// Поля
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "",
		),
		"FILTER_NAME" => "topSections",	// Фильтр
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"IBLOCK_ID" => "36",	// Код информационного блока
		"IBLOCK_TYPE" => "-",	// Тип информационного блока (используется только для проверки)
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",	// Включать инфоблок в цепочку навигации
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"NEWS_COUNT" => "20",	// Количество новостей на странице
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PARENT_SECTION" => "",	// ID раздела
		"PARENT_SECTION_CODE" => "",	// Код раздела
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
		"PROPERTY_CODE" => array(	// Свойства
			0 => "NAME_RU",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "Y",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "Y",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "Y",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
		"COMPONENT_TEMPLATE" => "footer_toinfo"
	),
	false
);?>
                </div>

                <div class="footer__box">
                    <a href="tel:<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", Array(), Array("MODE" => "text")); ?>"
                       class="footer__desc">
                        <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/phone.php", Array(), Array("MODE" => "text")); ?>
                    </a>
                    <ul class="list">
                        <li class="list__item list__item--icon">
                            <a href="mailto:<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/email.php", Array(), Array("MODE" => "text")); ?>"
                               class="list__link list__link--info">
                                <span class="list__icon">
                                    <img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/footer_mail.svg" alt="">
                                </span>
                                <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/email.php", Array(), Array("MODE" => "text")); ?>
                            </a>
                        </li>
                        <li class="list__item list__item--icon">
                            <a href="" class="list__link list__link--info js-show-modal" data-modal="modal--dealer" data-fog="fog--dealer">
                                 <span class="list__icon">
                                    <img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/footer_dealer.svg" alt="">
                                </span>
                                <?= Loc::getMessage('Become a reseller') ?>
                            </a>
                        </li>
                        <!--li class="list__item list__item--icon list__item--language">
                            <a href="" class="list__link list__link--info js-show-modal" data-modal="modal--lang" data-fog="fog--dealer">
                                <span class="list__icon">
                                    <img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/footer_language.svg" alt="">
                                </span>
                                <?= $GLOBALS['languages'][SITE_LANG]?>
                            </a>
                        </li-->
                    </ul>
                </div>

                <div class="footer__box footer__box--input">
                    <?$APPLICATION->IncludeComponent("bitrix:sender.subscribe", "subscribe", Array(
                        "AJAX_MODE" => "N",	// Включить режим AJAX
                        "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
                        "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
                        "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
                        "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
                        "CACHE_TIME" => "3600",	// Время кеширования (сек.)
                        "CACHE_TYPE" => "A",	// Тип кеширования
                        "CONFIRMATION" => "N",	// Запрашивать подтверждение подписки по email
                        "HIDE_MAILINGS" => "Y",	// Скрыть список рассылок, и подписывать на все
                        "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                        "SHOW_HIDDEN" => "N",	// Показать скрытые рассылки для подписки
                        "USER_CONSENT" => "N",	// Запрашивать согласие
                        "USER_CONSENT_ID" => "0",	// Соглашение
                        "USER_CONSENT_IS_CHECKED" => "Y",	// Галка по умолчанию проставлена
                        "USER_CONSENT_IS_LOADED" => "N",	// Загружать текст сразу
                        "USE_PERSONALIZATION" => "Y",	// Определять подписку текущего пользователя
                    ),
                        false
                    );?>
                    <div class="footer__desc footer__desc--input">
                        <?= Loc::getMessage('POLICY') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bot">
            <div class="footer__inner footer__inner--bot">
                <div class="footer__info">
                    &#169; <?= date('Y') ?>, Harzlabs. <?= Loc::getMessage('All Rights Reserved') ?>.
                </div>
                <ul class="footer__list">
                    <!--li class="footer__point">
                        <a href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/yutb.php", Array(), Array("MODE" => "text")); ?>" target="_blank" class="footer__link">
                            Youtube
                        </a>
                    </li-->
                    <!--li class="footer__point">
                        <a href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/twt.php", Array(), Array("MODE" => "text")); ?>" target="_blank" class="footer__link">
                            Twitter
                        </a>
                    </li-->
                    <li class="footer__point">
                        <a href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/vk.php", Array(), Array("MODE" => "text")); ?>" target="_blank" class="footer__link">
                            Vkontakte
                        </a>
                    </li>
                    <li class="footer__point">
                        <a href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/fcb.php", Array(), Array("MODE" => "text")); ?>" target="_blank" class="footer__link">
                            Facebook
                        </a>
                    </li>
                    <!--li class="footer__point">
                        <a href="<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/inst.php", Array(), Array("MODE" => "text")); ?>" target="_blank" class="footer__link">
                            Instagram
                        </a>
                    </li-->
                </ul>
                <div class="footer__rules">
                    <!--a href="" class="footer__link footer__link--rules">
                        <?= Loc::getMessage('Terms of Service') ?>
                    </a-->
                    <a href="/policy/" class="footer__link footer__link--rules">
                        <?= Loc::getMessage('Privacy Policy') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

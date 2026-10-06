<?php

use Bitrix\Main\Localization\Loc;
CModule::IncludeModule("sale");

Loc::loadMessages(__FILE__);
$compareCount = 0;
if (isset($_SESSION['CATALOG_COMPARE_LIST'][6]['ITEMS'])) {
    $compareCount = count($_SESSION['CATALOG_COMPARE_LIST'][6]['ITEMS']);
}

/*
$cntBasketItems = CSaleBasket::GetList(
    array(),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL"
    ),
    array()
);
*/

$cntBasketItems = getCountItemsInBasket();

?>
<input type="hidden" value="<?= LANGUAGE_ID; ?>" id="cookieLang">
<div class="header">
    <div class="header__wrapper">

        <a href="" class="burger"><span></span></a>

        <a href="/" class="header__logo"><img src="<?= SITE_TEMPLATE_PATH ?>/images/harzlabs.svg" alt=""></a>

        <div class="header__navigation">
            <nav class="nav">
                <? $GLOBALS['topSections'] = array('ID' => array(118, 73, 74, 75)); ?>
                <? $APPLICATION->IncludeComponent("bitrix:news.list", "header_filter", Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",    // Формат показа даты
                    "ADD_SECTIONS_CHAIN" => "Y",    // Включать раздел в цепочку навигации
                    "AJAX_MODE" => "N",    // Включить режим AJAX
                    "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
                    "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
                    "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
                    "AJAX_OPTION_STYLE" => "Y",    // Включить подгрузку стилей
                    "CACHE_FILTER" => "N",    // Кешировать при установленном фильтре
                    "CACHE_GROUPS" => "Y",    // Учитывать права доступа
                    "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
                    "CACHE_TYPE" => "A",    // Тип кеширования
                    "CHECK_DATES" => "Y",    // Показывать только активные на данный момент элементы
                    "DETAIL_URL" => "",    // URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                    "DISPLAY_BOTTOM_PAGER" => "Y",    // Выводить под списком
                    "DISPLAY_DATE" => "Y",    // Выводить дату элемента
                    "DISPLAY_NAME" => "Y",    // Выводить название элемента
                    "DISPLAY_PICTURE" => "Y",    // Выводить изображение для анонса
                    "DISPLAY_PREVIEW_TEXT" => "Y",    // Выводить текст анонса
                    "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
                    "FIELD_CODE" => array(    // Поля
                        0 => "NAME",
                        1 => "",
                    ),
                    "FILTER_NAME" => "topSections",    // Фильтр
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",    // Скрывать ссылку, если нет детального описания
                    "IBLOCK_ID" => "5",    // Код информационного блока
                    "IBLOCK_TYPE" => "reference",    // Тип информационного блока (используется только для проверки)
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",    // Включать инфоблок в цепочку навигации
                    "INCLUDE_SUBSECTIONS" => "Y",    // Показывать элементы подразделов раздела
                    "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
                    "NEWS_COUNT" => "20",    // Количество новостей на странице
                    "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
                    "PAGER_DESC_NUMBERING" => "N",    // Использовать обратную навигацию
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",    // Время кеширования страниц для обратной навигации
                    "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
                    "PAGER_SHOW_ALWAYS" => "N",    // Выводить всегда
                    "PAGER_TEMPLATE" => ".default",    // Шаблон постраничной навигации
                    "PAGER_TITLE" => "Новости",    // Название категорий
                    "PARENT_SECTION" => "",    // ID раздела
                    "PARENT_SECTION_CODE" => "",    // Код раздела
                    "PREVIEW_TRUNCATE_LEN" => "",    // Максимальная длина анонса для вывода (только для типа текст)
                    "PROPERTY_CODE" => array(    // Свойства
                        0 => "NAME_RU",
                        1 => "",
                    ),
                    "SET_BROWSER_TITLE" => "Y",    // Устанавливать заголовок окна браузера
                    "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
                    "SET_META_DESCRIPTION" => "Y",    // Устанавливать описание страницы
                    "SET_META_KEYWORDS" => "Y",    // Устанавливать ключевые слова страницы
                    "SET_STATUS_404" => "N",    // Устанавливать статус 404
                    "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                    "SHOW_404" => "N",    // Показ специальной страницы
                    "SORT_BY1" => "SORT",    // Поле для первой сортировки новостей
                    "SORT_BY2" => "SORT",    // Поле для второй сортировки новостей
                    "SORT_ORDER1" => "ASC",    // Направление для первой сортировки новостей
                    "SORT_ORDER2" => "ASC",    // Направление для второй сортировки новостей
                    "STRICT_SECTION_CHECK" => "N",    // Строгая проверка раздела для показа списка
                ),
                    false
                ); ?>
            </nav>
            <a href class="header__logo header__logo--mobile">
                <img src="<?= SITE_TEMPLATE_PATH ?>/images/logo/logo-dark.png" alt="">
            </a>
        </div>

        <div class="header__icons">
            <div class="header__icon">
                <a href="" class="header__button js-toggle-search">
                    <img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/icon-search.svg" alt="">
                </a>
            </div>
            <div class="header__icon">
                <a href="/compare/" class="header__button">
                    <img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/icon-comparison.svg" alt="">
                </a>
                <?php if ($compareCount) { ?>
                    <div class="header__circle"><?= $compareCount ?></div>
                <? } ?>
            </div>
            <div class="header__icon">
                <a href="/personal/cart/" class="header__button">
                    <img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/icon-basket.svg" alt="">
                </a>
                <?php if ($cntBasketItems) { ?>
                    <div class="header__circle"><?= $cntBasketItems ?></div>
                <? } ?>
            </div>
            <div class="header__icon">
				<?php global $USER;
					if($USER->IsAuthorized()) { ?> 
					<a href="/personal/" class="header__button">
                    	<img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/icon-profile.svg" alt="">
                	</a>
				<?php } else { ?> 
					<a href="#" class="header__button js-show-modal" data-modal="modal--auth">
						<img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/icon-profile.svg" alt="">
					</a>
				<?php } ?>
            </div>
        </div>
        <div class="header__languages">
			<a href="?lang=<?= (SITE_LANG == 'ru' ? 'en' : 'ru') ?>" class="header__language" data-modal="modal--lang"><?= (SITE_LANG == 'ru' ? 'EN' : 'RU') ?></a>
        </div>
    </div>
</div>
<div class="search">
    <div class="width width--1400">
        <div class="search__body">
            <div class="search__input">
                <!-- <input type="text" placeholder="Search the store"> -->
                <!--<span class="search__icon"></span>-->
                <? $APPLICATION->IncludeComponent(
                    "bitrix:search.form",
                    "serach_form",
                    Array(
                        "PAGE" => "#SITE_DIR#search/index.php",
                        "USE_SUGGEST" => "N"
                    )
                ); ?>
                <a href="" class="search__delete js-close-search"></a>
            </div>
        </div>
    </div>
</div>
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("Обучение - HARZ Labs");
$APPLICATION->SetPageProperty('title', "Обучение - HARZ Labs");

\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/vendor/swiper/swiper-bundle.min.js");
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/vendor/swiper/swiper-bundle.min.css");
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/education.css");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/education.js");
?>
<?
$APPLICATION->IncludeComponent(
	"bitrix:advertising.banner", 
	"banner_custaom2", 
	[
		"COMPONENT_TEMPLATE" => "banner_custaom2",
		"TYPE" => "REK",
		"NOINDEX" => "N",
		"QUANTITY" => "1",
		"DEFAULT_TEMPLATE" => "-",
		"BS_EFFECT" => "fade",
		"BS_CYCLING" => "N",
		"BS_WRAP" => "Y",
		"BS_KEYBOARD" => "Y",
		"BS_ARROW_NAV" => "Y",
		"BS_BULLET_NAV" => "Y",
		"BS_HIDE_FOR_TABLETS" => "N",
		"BS_HIDE_FOR_PHONES" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => ""
	],
	false
);?>

<div class="container">
    <div class="page-section education-page education recol" style="padding-top: 180px;">
        <main class="rerow education__main section">
            <img src="<?=SITE_TEMPLATE_PATH . "/img/education/education.png"?>" class="education__main-img" >
            <div class="education__main-col">
                <h1 class="title title--h1 education__main-title">HARZ Labs <br>и Цифра Цифра</h1>
                <div class="text text--middle education__main-text recol">
                    <p>Мы – HARZ Labs, являемся ведущим экспертом в области профессиональной фотополимерной 3D-печати в России.</p>
                    <p>Помогаем бизнесу, клиникам, лабораториям, производствам, и всем желающим повысить уровень своих компетенций по работе с LCD, DLP и SLA технологиями печати.</p>
                    <p>Чтобы обучение было максимально эффективным мы объединили усилия вместе с нашим образовательным партнёром – Академией аддитивных технологий «Цифра Цифра».</p>
                    <p>Учебный центр обладает государственной лицензией на осуществление образовательной деятельности номер: Л035-01255-50/00634721 от 29.12.2022.</p>
                    <p><b>Присоединяйтесь к нашему инновационному проекту!</b></p>
                </div>
            </div>
        </main>

        <div id="courses">
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "section_slider",
                array(
                    "IBLOCK_TYPE" => "content",
                    "IBLOCK_ID" => "75",
                    "SECTION_ID" => "6544",
                    "NEWS_COUNT" => "10",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_PICTURE",
                        2 => "DATE_CREATE",
                        3 => "",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "LINK",
                        1 => "",
                    ),
                    "SET_TITLE" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "COMPONENT_TEMPLATE" => "section_slider",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_LAST_MODIFIED" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "6544",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "STRICT_SECTION_CHECK" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Курсы",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    'SHOW_TITLE' => 'Y'
                ),
                $component
            );?>
        </div>

        <div id="webinars">
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "section_slider",
                array(
                    "IBLOCK_TYPE" => "content",
                    "IBLOCK_ID" => "75",
                    "SECTION_ID" => "6543",
                    "NEWS_COUNT" => "10",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_PICTURE",
                        2 => "DATE_CREATE",
                        3 => "",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "LINK",
                        1 => "",
                    ),
                    "SET_TITLE" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "COMPONENT_TEMPLATE" => "section_slider",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "6543",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "STRICT_SECTION_CHECK" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Вебинары",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "SET_STATUS_404" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    'SHOW_TITLE' => 'N'
                ),
                $component
            );?>
        </div>


        <div class="education__banner" style="background-image: url(<?=SITE_TEMPLATE_PATH . "/img/education/banner.png"?>);">
            <div class="education__banner-wrapper">
                <h2 class="title title--h2 education__banner-title">Не нашли подходящий курс?</h2>
                <p class="text education__banner-text">Ещё больше курсов на сайте <br>Академии аддитивных технологий «Цифра цифра»</p>
                <a href="https://2cifra.ru/courses/" target="_blank" class="button button--fill education__button-banner">Перейти на сайт</a>
            </div>
        </div>

        <div class="education__quests rerow">
            <div class="education__quests-col recol">
                <h2 class="title title--h2 education__quests-title">Остались вопросы?</h2>
                <p class="text education__quests-text">Напишите нам в мессенджере или задайте вопрос в форме — пришлём ответ на почту</p>
                <div class="education__quests-btns rerow">
                    <a href="https://t.me/cifra2academy" tasrget="_blank" class="button button--with-icon education__quests-btn">
                        <span>Наш Telegram</span>
                        <img src="<?=SITE_TEMPLATE_PATH . "/img/education/tg.svg"?>" class="button__icon">
                    </a>
                    <a href="https://wa.me/+79912568206" tasrget="_blank" class="button button--with-icon education__quests-btn">
                        <span>Наш Whatsapp</span>
                        <img src="<?=SITE_TEMPLATE_PATH . "/img/education/wp.svg"?>" class="button__icon">
                    </a>
                </div>
            </div>

            <div class="education__form-wrapper">
                <form id="educationForm" class="education__form">
                    <div class="education__row">
                        <div class="education__field">
                            <label class="education__floating-label">
                                <input type="text" name="name" placeholder=" " class="education__input" required>
                                <span class="education__label-text">Имя<span class="education__required-star">*</span></span>
                            </label>
                            <span class="education__error"></span>
                        </div>
                        <div class="education__field">
                            <label class="education__floating-label">
                                <input type="email" name="email" placeholder=" " class="education__input" required>
                                <span class="education__label-text">E-mail для ответа<span class="education__required-star">*</span></span>
                            </label>
                            <span class="education__error"></span>
                        </div>
                    </div>

                    <div class="education__field">
                        <label class="education__floating-label">
                            <textarea name="question" placeholder=" " class="education__textarea" required></textarea>
                            <span class="education__label-text">Текст вопроса<span class="education__required-star">*</span></span>
                        </label>
                        <span class="education__error"></span>
                    </div>

                    <div class="education__agree">
                        <label class="education__checkbox-label">
                            <input type="checkbox" name="agree" class="education__checkbox" required>
                            <span class="education__checkbox-custom"></span>
                            <span class="education__agree-text">Согласие на обработку персональных данных</span>
                        </label>
                        <span class="education__error"></span>
                    </div>

                    <button type="submit" class="education__submit-button button button--fill">Отправить</button>
                </form>

                <div class="education__success-message text" style="display: none;">
                    <h3 class="title title--h3 education__success-title">Спасибо за ваш вопрос!</h3>
                    <p>Мы получили ваше сообщение и скоро свяжемся с вами.</p>
                </div>
                <div class="education__error-message" style="display: none;">
                    <h3 class="title title--h3 education__success-title"></h3>
                </div>
            </div>
        </div>

    </div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>


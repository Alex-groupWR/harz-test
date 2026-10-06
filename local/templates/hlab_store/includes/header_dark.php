<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<input type="hidden" value="<?= LANGUAGE_ID; ?>" id="cookieLang">
<div class="header header--dark">
    <div class="header__wrapper">
        <a href="" class="burger burger--mobile js-open-mobile-nav"><span></span></a>
        <a href="/" class="logo logo--dark">
            <img class="logo__image svg" src="<?= SITE_TEMPLATE_PATH ?>/images/header/harzlabs.svg" alt="">
            <?php /*<img class="logo__image logo__image&#45;&#45;dark" src="images/logo/logo-dark.png" alt="">*/?>
        </a>

        <div class="header__navigation">
            <?$APPLICATION->IncludeComponent("bitrix:menu", "main_menu_dark", Array(
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
        </div>
        <a href="" class="join join--dark js-show-modal" data-modal="modal--dealer" data-fog="fog--dealer">
            <span class="join__icon">
                <img class="svg" src="<?= SITE_TEMPLATE_PATH ?>/images/icons/footer_dealer.svg" alt="">
            </span>
            <span class="join__text"><?= Loc::getMessage('Become a reseller') ?></span>
        </a>
        <!--a href="" class="language language--dark language--button js-show-modal" data-modal="modal--lang" data-fog="fog--dealer">
            <span class="language__index"><?= SITE_LANG ?></span>
        </a-->
    </div>
</div>
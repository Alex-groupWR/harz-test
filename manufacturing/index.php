<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Products");

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(SITE_TEMPLATE_PATH . "index.php");

?>
<? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/preloader.php", Array(), Array("MODE" => "html")); ?>

    <!-- Slider main container -->
    <div class="swiper-container js-block-slider">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="manufacturing__screen manufacturing__screen--typeB swiper-slide">
                <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/header.php", Array(), Array("MODE" => "php")); ?>
                <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/popup_items.php", Array(), Array("MODE" => "php")); ?>
                <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/modals.php", Array(), Array("MODE" => "php")); ?>
                <div class="inner">
                    <div class="inner__video video__masked">
                        <video muted="muted" autoplay loop preload="auto" width="1280" height="720">
                            <source type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' src="<?= SITE_TEMPLATE_PATH ?>/video/manuf.mp4">
                            <source type='video/webm; codecs="vp8, vorbis"' src="<?= SITE_TEMPLATE_PATH ?>/video/manuf.webm">
                            <source type='video/ogg; codecs="theora, vorbis"' src="<?= SITE_TEMPLATE_PATH ?>/video/manuf.ogv">
                        </video>
                    </div>
                    <a href="" class="scroll js-swipe-to-slide" data-slide="1"></a>
                </div>
            </div>

            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "slide",
                array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_DATE" => "N",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array(
                        0 => "CODE",
                        1 => "NAME",
                        2 => "PREVIEW_PICTURE",
                        3 => "DETAIL_PICTURE",
                        4 => "",
                    ),
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "3",
                    "IBLOCK_TYPE" => "content",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "20",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Новости",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PROPERTY_CODE" => array(
                        0 => "EN_DETAIL_TEXT",
                        1 => "RU_DETAIL_TEXT",
                        2 => "EN_NAME",
                        3 => "RU_NAME",
                        4 => "NAME_RU",
                        5 => "",
                    ),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "SORT",
                    "SORT_BY2" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "ASC",
                    "SORT_ORDER2" => "DESC",
                    "STRICT_SECTION_CHECK" => "N",
                    "COMPONENT_TEMPLATE" => "slide"
                ),
                false
            ); ?>

        </div>

        <div class="swiper-scrollbar">
            <div class="swiper-scrollbar-drag"></div>
        </div>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/support.css");

$APPLICATION->SetTitle("Документация - HARZ Labs");
?>
    <div class="container eifu__container">
        <div class="page-section text-page support-page eifu__page">
            <div class="main right-col eifu__main">
                <div class="support-block eifu__block" style="margin-bottom: 64px;">
                    <div class="section-instructions eifu__instructions">
                        <div class="service-container eifu__service-container">

                            <?$APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "eifu",
                                array(
                                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                    "ADD_SECTIONS_CHAIN" => "Y",
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
                                    "DISPLAY_BOTTOM_PAGER" => "Y",
                                    "DISPLAY_DATE" => "Y",
                                    "DISPLAY_NAME" => "Y",
                                    "DISPLAY_PICTURE" => "Y",
                                    "DISPLAY_PREVIEW_TEXT" => "Y",
                                    "DISPLAY_TOP_PAGER" => "N",
                                    "FIELD_CODE" => array(
                                        0 => "",
                                        1 => "",
                                    ),
                                    "FILTER_NAME" => "",
                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                    "IBLOCK_ID" => "64",
                                    "IBLOCK_TYPE" => "content",
                                    "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
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
                                        0 => "",
                                        1 => "FILE",
                                    ),
                                    "SET_BROWSER_TITLE" => "Y",
                                    "SET_LAST_MODIFIED" => "N",
                                    "SET_META_DESCRIPTION" => "Y",
                                    "SET_META_KEYWORDS" => "Y",
                                    "SET_STATUS_404" => "N",
                                    "SET_TITLE" => "Y",
                                    "SHOW_404" => "N",
                                    "SORT_BY1" => "SORT",
                                    "SORT_BY2" => "SORT",
                                    "SORT_ORDER1" => "ASC",
                                    "SORT_ORDER2" => "ASC",
                                    "STRICT_SECTION_CHECK" => "N",
                                    "COMPONENT_TEMPLATE" => "eifu"
                                ),
                                false
                            );?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--								<ul class="nav nav-print-settings">-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV-Ceramic-Binder-N-Type-V10.pdf" download>UV Ceramic Binder N-Type V10</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder N-Type V20.pdf" download>UV Ceramic Binder N-Type V20</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder N-Type V50.pdf" download>UV Ceramic Binder N-Type V50</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder N-Type V100.pdf" download>UV Ceramic Binder N-Type V100</a>-->
<!--									</li>-->
<!---->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Ox-Type V10.pdf" download>UV Ceramic Binder Ox-Type V10</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Ox-Type V20.pdf" download>UV Ceramic Binder Ox-Type V20</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Ox-Type V50.pdf" download>UV Ceramic Binder Ox-Type V50</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Ox-Type V100.pdf" download>UV Ceramic Binder Ox-Type V100</a>-->
<!--									</li>-->
<!---->
<!---->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Si-Type V10.pdf" download>UV Ceramic Binder Si-Type V10</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Si-Type V20.pdf" download>UV Ceramic Binder Si-Type V20</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Si-Type V50.pdf" download>UV Ceramic Binder Si-Type V50</a>-->
<!--									</li>-->
<!--									<li class="nav-item">-->
<!--										<a class="nav-link" href="/eifu/binder/UV Ceramic Binder Si-Type V100.pdf" download>UV Ceramic Binder Si-Type V100</a>-->
<!--									</li>-->
<!--									-->
<!--								</ul>-->
<br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
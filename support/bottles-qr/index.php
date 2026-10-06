<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Помоги нам стать лучше");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/qr.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/qr.css");
?>

    <div class="container qr">
        <div class="page-section page-print-support qr__support">
            <div class="left-sidenav qr__left" id="leftSidenav">

            </div>

            <div class="main right-col qr__right">
                <div class="qr__main-section">
                    <div class="qr__main-col qr__main-col--left">
                        <h1 class="qr__main-title">Помоги нам стать лучше</h1>
                        <p class="qr__main-descr">Оцени качество нашей работы и материала</p>
                        <a href="/support/rate-us/" class="qr__main-link">Оставить отзыв</a>
                    </div>

                    <div class="qr__main-col qr__main-col--right">
                        <a href="/support/#print-settings" class="qr__link-section">Настройки</br><span>печати</span></a>
                        <a href="/support/finishing/how-long-do-i-post-cure-my-prints/" class="qr__link-section">Таблица</br><span>постобработки</span></a>
                        <a href="/support/test-program/about-program/" class="qr__link-section">Программа</br><span>тестирования</span></a>
                    </div>
                </div>

                <div class="qr__bottom">
                    <div class="qr__bot">
                        <div class="qr__bot-header">
                            <h2 class="qr__bot-title">
                                <img src="<?=SITE_TEMPLATE_PATH . '/img/qr/tg-title.svg'?>" class="qr__img-title">
                                Чат HARZ Labs
                            </h2>
                            <p class="qr__bot-descr">Официальный чат для пользователей фотополимеров HARZ Labs</p>
                            <a target="_blank" href="https://t.me/harzlabsacademy" class="qr__bot-link">Перейти в чат</a>
                        </div>
                        <div class="qr__bot-middle">
                            <h2 class="qr__bot-middle-title">
                                Подписывайся
                            </h2>
                            <div class="qr__socials">
                                <a target="_blank" href="https://t.me/harzlabs" class="qr__social"><img src="<?=SITE_TEMPLATE_PATH . '/img/qr/tg.svg'?>" class="qr__img-social"></a>
                                <a target="_blank" href="https://vk.com/harzlabs" class="qr__social"><img src="<?=SITE_TEMPLATE_PATH . '/img/qr/vk.svg'?>" class="qr__img-social"></a>
                                <a target="_blank" href="https://www.instagram.com/harzlabs/" class="qr__social"><img src="<?=SITE_TEMPLATE_PATH . '/img/qr/inst.svg'?>" class="qr__img-social"></a>
                                <a target="_blank" href="https://www.youtube.com/c/HarzLabs" class="qr__social"><img src="<?=SITE_TEMPLATE_PATH . '/img/qr/yt.svg'?>" class="qr__img-social"></a>
                            </div>
                        </div>

                        <div class="qr__bot-bottom">
                            <p class="qr__bottom-descr">Проблемы с печатью? Пиши:
                                </br><a class="qr__bottom-link" href="mailto:support@harzlabs.ru">support@harzlabs.ru</a></p>
                        </div>
                    </div>

                    <div class="qr__acordeon">
                         <?
//                        $cache = Bitrix\Main\Data\Cache::createInstance();
//                        if ($cache->initCache(7200, 'accordeon'))
//                        {
//                            $result = $cache->getVars();
//                            $arAccordeon = $result['accordeon'];
//                        }
//                        elseif ($cache->startDataCache())
//                        {
                            $result = array();
                            \Bitrix\Main\Loader::includeModule('iblock');
                            $res = CIBlockElement::GetList(
                                ["SORT"=>"ASC"],
                                ['IBLOCK_ID' => 62],
                                false,
                                array(),
                                ['ID', 'SORT', 'IBLOCK_ID', 'NAME', 'PROPERTY_DESCR_RU']
                            );

                            while ($row = $res->Fetch()) {
                                $result['accordeon'][] = $row;
                            }

                            $arAccordeon = $result['accordeon'];

//                            $cache->endDataCache($result);
//                        }
                        $i = 0;

                         foreach ($arAccordeon as $arRow)
                        {
                            ?>
                            <div class="qr__accordeon-row <?= $i==0 ? 'qr__accordeon-row--open' : ''?>">
                                <div class="qr__accordeon-title">
                                    <span><?=$arRow['NAME']?></span>
                                    <img src="<?=SITE_TEMPLATE_PATH . '/img/qr/arr.svg'?>" class="qr__accordeon-arr">
                                </div>
                                <div class="qr__accordeon-body">
                                    <?=$arRow["PROPERTY_DESCR_RU_VALUE"]["TEXT"]?>
                                </div>
                            </div>
                            <?
                            $i++;
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<div class="map">
    <div class="map__wrapper">
        <div class="map__content">
            <div class="map__title">
                <? $APPLICATION->IncludeFile(INCLUDES . "main_map_title.php", Array(), Array("MODE" => "html")); ?>
            </div>
            <div class="map__row">
                <div class="map__button">
                    <a href="" class="button button--dealer button--dark button--big js-show-modal"
                       data-modal="modal--dealer"
                       data-fog="fog--dealer">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/images/icons/footer_dealer.svg" class="svg button__icon"
                             alt="">
                        <span class="button__text"><?= Loc::getMessage('Become a reseller') ?></span>
                    </a>
                </div>
                <!--div class="map__search">
                    <label class="search search--light">
                        <input type="search" class="search__item search__item--light search__item--map"
                               placeholder="<?= Loc::getMessage('Search by city') ?>">
                        <span class="bxhtmled-surrogate-inner">
                            <span class="bxhtmled-right-side-item-icon"></span>
                            <span class="bxhtmled-comp-lable" unselectable="on" spellcheck="false"></span>
                        </span>
                    </label>
                </div-->
            </div>
        </div>
        <div class="map__item">
            <img src="/local/templates/hlab/images/map/map2.svg" class="svg" alt="">
        </div>
    </div>
</div>
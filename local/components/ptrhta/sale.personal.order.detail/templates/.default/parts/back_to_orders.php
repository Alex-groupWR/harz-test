<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>

<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

?>
<div class="intec-ui-m-t-15 intec-ui-m-b-15">
    <?= Html::beginTag('div', [
        'class' => [
            'intec-grid' => [
                '',
                'wrap',
                'a-h-between',
                'a-v-center'
            ]
        ]
    ]) ?>
        <div class="intec-grid-item-auto">
            <?= Html::beginTag('a', [
                'class' => [
                    'sale-personal-order-detail-return',
                    'intec-grid' => [
                        '',
                        'nowrap',
                        'a-v-center',
                        'i-h-4'
                    ],
                    'intec-cl-text' => [
                        '',
                        'light-hover'
                    ]
                ],
                'href' => Html::encode($arResult['URL_TO_LIST'])
            ]) ?>
                <span class="intec-grid-item-auto intec-ui-picture intec-cl-svg-path-stroke">
                    <?= $arSvg['RETURN'] ?>
                </span>
                <span class="intec-grid-item-auto">
                    <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BUTTONS_RETURN') ?>
                </span>
            <?= Html::endTag('a') ?>
        </div>
        <div class="intec-grid-item-auto">
            <div class="intec-grid intec-grid-wrap intec-grid-a-h-end intec-grid-a-v-center intec-grid-i-8">
                <?php if (!empty($arResult['CAN_CANCEL']) && $arResult['CAN_CANCEL'] === 'Y' && !empty($arResult['URL_TO_CANCEL'])) { ?>
                    <div class="intec-grid-item-auto">
                        <?= Html::tag('a', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BUTTONS_CANCEL'), [
                            'class' => [
                                'sale-personal-order-detail-button',
                                'intec-ui' => [
                                    '',
                                    'control-button',
                                    'mod-round-2',
                                    'scheme-current'
                                ]
                            ],
                            'href' => Html::encode($arResult['URL_TO_CANCEL']),
                            'onclick' => "return confirm('" . htmlspecialcharsbx(Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BUTTONS_CANCEL')) . "???')",
                            'style' => 'color: #fff; text-decoration: none;'
                        ]) ?>
                    </div>
                <?php } ?>
                <?php if (!empty($arResult['URL_TO_COPY'])) { ?>
                    <div class="intec-grid-item-auto">
                        <?= Html::tag('a', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BUTTONS_REPEAT'), [
                            'class' => [
                                'sale-personal-order-detail-button',
                                'intec-ui' => [
                                    '',
                                    'control-button',
                                    'mod-round-2',
                                    'scheme-current'
                                ]
                            ],
                            'href' => Html::encode($arResult['URL_TO_COPY']),
                            'style' => 'color: #fff; text-decoration: none;'
                        ]) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?= Html::endTag('div') ?>
</div>

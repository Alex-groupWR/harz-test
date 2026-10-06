<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\core\helpers\Html;
use intec\core\helpers\StringHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CBitrixComponent $component
 */

?>
<div class="sale-personal-order-detail-block" data-role="block" data-block="payment">
    <div class="sale-personal-order-detail-block-title">
        <div class="intec-grid intec-grid-wrap intec-grid-a-h-between intec-grid-a-v-center intec-grid-i-8">
            <div class="intec-grid-item-auto">
                <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_TITLE') ?>
            </div>
            <div class="intec-grid-item-auto">
                <div class="sale-personal-order-detail-block-button intec-cl-svg-path-stroke intec-cl-svg-rect-stroke intec-ui-picture" data-role="collapse" data-state="true">
                    <?= $arSvg['BLOCK_TOGGLE'] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="sale-personal-order-detail-block-content" data-role="content">
        <div class="sale-personal-order-detail-block-payments">
            <?php foreach ($arResult['PAYMENT'] as $arPayment) { ?>
                <?php
                $sState = 'unpaid';

                if ($arPayment['PAID'] === 'Y') {
                    $sState = 'paid';
                } else if ($arResult['IS_ALLOW_PAY'] !== 'Y') {
                    $sState = 'restricted';
                }

                $arPaymentData[$arPayment['ACCOUNT_NUMBER']] = [
                    'payment' => $arPayment['ACCOUNT_NUMBER'],
                    'order' => $arPayment['ORDER_ID'],
                    'allow_inner' => $arParams['ALLOW_INNER'],
                    'only_inner_full' => $arParams['ONLY_INNER_FULL'],
                    'refresh_prices' => $arParams['REFRESH_PRICES'],
                    'path_to_payment' => $arParams['PATH_TO_PAYMENT']
                ];


                ?>
                <div class="sale-personal-order-detail-block-payment">
                    <div class="sale-personal-order-detail-block-payment-common">
                        <div class="intec-grid intec-grid-nowrap intec-grid-450-wrap intec-grid-a-v-center intec-grid-i-h-20 intec-grid-i-v-10">
                            <!--                            <div class="intec-grid-item">-->
                            <!--                                <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">-->
                            <!--                                    --><?//= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_TRACK') ?>
                            <!--                                </div>-->
                            <!--                                <div class="sale-personal-order-detail-block-payment-title sale-personal-order-detail-block-information-field-text">-->
                            <!--                                    --><?php
                            //                                    echo Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_NAME_1', [
                            //                                        '#NUMBER#'=> $arPayment['ACCOUNT_NUMBER']
                            //                                    ]);
                            //
                            //                                    if (!empty($arPayment['DATE_BILL'])) {
                            //                                        echo ' ';
                            //                                        echo Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_NAME_2', [
                            //                                            '#DATE#' => $arPayment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT'])
                            //                                        ]);
                            //                                    }
                            //
                            //                                    echo Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_NAME_3', [
                            //                                        '#PAY_SYSTEM#'=> $arPayment['PAY_SYSTEM_NAME']
                            //                                    ]);
                            //                                    ?>
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <!--                            <div class="intec-grid-item-auto intec-grid-item-450-1">-->
                            <!--                                <div class="sale-personal-order-detail-block-payment-state" data-state="--><?//= $sState ?><!--">-->
                            <!--                                    --><?//= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_STATE_'.StringHelper::toUpperCase($sState)) ?>
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                        <br>
                        <div class="sale-personal-order-detail-block-information">
                            <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                    <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_METHOD') ?>
                                </div>
                                <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                    <?php
                                    echo Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_NAME_1', [
                                        '#NUMBER#'=> $arPayment['ACCOUNT_NUMBER']
                                    ]);

                                    if (!empty($arPayment['DATE_BILL'])) {
                                        echo ' ';
                                        echo Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_NAME_2', [
                                            '#DATE#' => $arPayment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT'])
                                        ]);
                                    }

                                    echo Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_NAME_3', [
                                        '#PAY_SYSTEM#'=> $arPayment['PAY_SYSTEM_NAME']
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="sale-personal-order-detail-block-information">
                            <? if ($arResult['TRACK']) { ?>
                                <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                    <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_TRACK') ?>
                                    </div>
                                    <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                        <?=$arResult['TRACK']?>
                                    </div>
                                </div>
                            <? } ?>
                            <? if ($arResult['STAGE']) { ?>
                                <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                    <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_STATUS') ?>
                                    </div>
                                    <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                        <?=$arResult['STAGE']?>
                                    </div>
                                </div>
                            <? } ?>
                            <? if ($arResult['ADDRESS']) { ?>
                                <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                    <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_ADDRESS') ?>
                                    </div>
                                    <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                        <?=$arResult['ADDRESS']?>
                                    </div>
                                </div>
                            <? } ?>
                            <? if ($arResult['ADDRESS_TERMINAL']) { ?>
                                <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                    <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_ADDRESS') ?>
                                    </div>
                                    <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                        <?=$arResult['ADDRESS_TERMINAL']?>
                                    </div>
                                </div>
                            <? } ?>
                            <? if ($arResult['UPD'] && $arResult['UPD']["link"]) { ?>
                                <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                    <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_UPD_TITLE') ?>
                                    </div>
                                    <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_UPD', [
                                            '#LINK#' => $arResult['UPD']["link"],
                                            '#TITLE#' => $arResult['UPD']["title"]
                                        ]) ?>
                                    </div>
                                </div>
                            <? } ?>
                            <? if ($arResult['INVOICE_LINK'] && $arResult['INVOICE_LINK']["link"]) { ?>
                                <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                    <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_INVOICE_TITLE') ?>
                                    </div>
                                    <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_INVOICE', [
                                            '#LINK#' => $arResult['INVOICE_LINK']["link"],
                                            '#TITLE#' => $arResult['INVOICE_LINK']["title"]
                                        ]) ?>
                                    </div>
                                </div>
                            <? } ?>
                            <? if ($arResult['USER_DESCRIPTION']) { ?>
                                <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                    <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_COMMENT') ?>
                                    </div>
                                    <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                        <?=$arResult['USER_DESCRIPTION']?>
                                    </div>
                                </div>
                            <? } ?>
                            <div class="sale-personal-order-detail-block-information-field intec-grid intec-grid-wrap intec-grid-a-h-start intec-grid-a-v-start intec-grid-i-8">
                                <div class="sale-personal-order-detail-block-information-field-header intec-grid-item-1 intec-grid-item-425-2">
                                    <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_SUM_2') ?>
                                </div>
                                <div class="sale-personal-order-detail-block-information-field-text intec-grid-item-1 intec-grid-item-425-2">
                                    <?=$arPayment['PRICE_FORMATED']?>
                                </div>
                            </div>
                        </div>

                        <!--                        <div class="sale-personal-order-detail-block-payment-sum">-->
                        <!--                            --><?//= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_SUM', [
                        //                                '#SUM#' => $arPayment['PRICE_FORMATED']
                        //                            ]) ?>
                        <!--                        </div>-->
                        <?php if (!empty($arPayment['CHECK_DATA'])) { ?>
                            <?php
                            $arChecks = [];

                            foreach ($arPayment['CHECK_DATA'] as $arCheck) {
                                if (empty($arCheck['LINK']))
                                    continue;

                                $arChecks[] = Html::tag(
                                    'div',
                                    Html::tag('a', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_CHECKS_ITEM', [
                                        '#NUMBER#' => $arCheck['ID'],
                                        '#TYPE#' => Html::encode($arCheck['TYPE_NAME'])
                                    ]), [
                                        'href' => $arCheck['LINK']
                                    ]), [
                                    'class' => 'sale-personal-order-detail-block-payment-checks-item'
                                ]);
                            }
                            ?>
                            <?php if (!empty($arChecks)) { ?>
                                <div class="sale-personal-order-detail-block-payment-checks">
                                    <div class="sale-personal-order-detail-block-payment-checks-title">
                                        <?= Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_CHECKS_TITLE') ?>:
                                    </div>
                                    <div class="sale-personal-order-detail-block-payment-checks-items">
                                        <?= implode('', $arChecks) ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
<!--                    <div class="sale-personal-order-detail-block-payment-buttons">-->
<!--                        <div class="intec-grid intec-grid-wrap intec-grid-a-v-center">-->
<!--                            --><?php //if ($arPayment['PAY_SYSTEM']['IS_CASH'] !== 'Y' && $arPayment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash') { ?>
<!--                                <div class="intec-grid-item-auto">-->
<!--                                    --><?php //if ($arPayment['PAY_SYSTEM']['PSA_NEW_WINDOW'] === 'Y' && $arResult['IS_ALLOW_PAY'] === 'Y') { ?>
<!--                                        --><?//= Html::tag('a', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_BUTTON_PAY'), [
//                                            'href' => Html::encode($arPayment['PAY_SYSTEM']['PSA_ACTION_FILE']),
//                                            'target' => '_blank',
//                                            'class' => [
//                                                'sale-personal-order-detail-block-payment-button',
//                                                'sale-personal-order-detail-block-payment-button-pay',
//                                                'intec-ui' => [
//                                                    '',
//                                                    'control-button',
//                                                    'mod-transparent',
//                                                    'mod-round-2',
//                                                    'scheme-current'
//                                                ]
//                                            ]
//                                        ]) ?>
<!--                                    --><?php //} else {
//                                        if ($arPayment['PAID'] === 'Y' || $arResult['CANCELED'] === 'Y' || $arResult['IS_ALLOW_PAY'] === 'N') { ?>
<!--                                            --><?//= Html::tag('div', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_BUTTON_PAYED'), [
//                                                'class' => [
//                                                    'sale-personal-order-detail-block-payment-button',
//                                                    'sale-personal-order-detail-block-payment-button-pay',
//                                                    'intec-ui' => [
//                                                        '',
//                                                        'control-button',
//                                                        'mod-transparent',
//                                                        'mod-round-2',
//                                                        'state-disabled',
//                                                        'scheme-current'
//                                                    ]
//                                                ]
//                                            ]) ?>
<!--                                        --><?php //} else if (!empty($arPayment['BUFFERED_OUTPUT'])) { ?>
<!--                                            --><?//= Html::tag('div', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_BUTTON_PAY'), [
//                                                'class' => [
//                                                    'sale-personal-order-detail-block-payment-button',
//                                                    'sale-personal-order-detail-block-payment-button-pay',
//                                                    'sale-personal-order-detail-block-payment-switch',
//                                                    'sale-personal-order-detail-block-payment--sber',
//                                                    'intec-ui' => [
//                                                        '',
//                                                        'control-button',
//                                                        'mod-transparent',
//                                                        'mod-round-2',
//                                                        'scheme-current'
//                                                    ]
//                                                ]
//                                            ]) ?>
<!--                                        --><?php //} ?>
<!--                                    --><?php //} ?>
<!--                                </div>-->
<!--                            --><?php //} ?>
<!--                            <!--                            --><?php ////if (
//                            //                                $arPayment['PAID'] !== 'Y' &&
//                            //                                $arResult['CANCELED'] !== 'Y' &&
//                            //                                $arParams['GUEST_MODE'] !== 'Y' &&
//                            //                                $arResult['LOCK_CHANGE_PAYSYSTEM'] !== 'Y'
//                            //                            ) { ?>
<!--                            <!--                                <div class="intec-grid-item-auto">-->
<!--                            <!--                                    --><?////= Html::tag('div', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_BUTTON_CHANGE'), [
//                            //                                        'id' => $arPayment['ACCOUNT_NUMBER'],
//                            //                                        'class' => [
//                            //                                            'sale-personal-order-detail-block-payment-button',
//                            //                                            'sale-personal-order-detail-block-payment-change',
//                            //                                            'intec-ui' => [
//                            //                                                '',
//                            //                                                'control-button',
//                            //                                                'mod-transparent',
//                            //                                                'mod-round-2',
//                            //                                                'scheme-current'
//                            //                                            ]
//                            //                                        ]
//                            //                                    ]) ?>
<!--                            <!--                                </div>-->
<!--                            <!--                            --><?php ////} ?>
<!--                            --><?php //if ($arResult['IS_ALLOW_PAY'] !== 'Y' && $arPayment['PAID'] !== 'Y') { ?>
<!--                                <div class="intec-grid-item-auto">-->
<!--                                    --><?//= Html::tag('div', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_RESTRICTED_MESSAGE'), [
//                                        'class' => [
//                                            'sale-personal-order-detail-block-payment-button',
//                                            'intec-ui' => [
//                                                '',
//                                                'control-button',
//                                                'mod-transparent',
//                                                'mod-round-2',
//                                                'scheme-current'
//                                            ]
//                                        ]
//                                    ]) ?>
<!--                                </div>-->
<!--                            --><?php //} ?>
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="sale-personal-order-detail-block-payment-cancel" style="display: none;">-->
<!--                        --><?//= Html::tag('div', Loc::getMessage('C_SALE_PERSONAL_ORDER_DETAIL_TEMPLATE_1_TEMPLATE_BLOCKS_PAYMENT_BUTTON_CANCEL'), [
//                            'class' => [
//                                'sale-personal-order-detail-block-payment-button',
//                                'intec-ui' => [
//                                    '',
//                                    'control-button',
//                                    'mod-transparent',
//                                    'mod-round-2',
//                                    'scheme-current'
//                                ]
//                            ]
//                        ]) ?>
<!--                    </div>-->
<!--                    --><?php //if (
//                        $arPayment['PAID'] !== 'Y' &&
//                        $arPayment['PAY_SYSTEM']['IS_CASH'] !== 'Y' &&
//                        $arPayment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y' &&
//                        $arResult['CANCELED'] !== 'Y' &&
//                        $arResult['IS_ALLOW_PAY'] !== 'N'
//                    ) { ?>
<!--                        <div class="sale-personal-order-detail-block-payment-form-container">-->
<!--                            <div class="sale-personal-order-detail-block-payment-form intec-ui-m-t-20">-->
<!--                                <div class="sale-personal-order-detail-block-payment-close sale-personal-order-detail-block-payment-switch">-->
<!--                                    <i class="fa fa-times"></i>-->
<!--                                </div>-->
<!--                                <div class="sale-personal-order-detail-block-payment-form-content">-->
<!--                                    --><?//= $arPayment['BUFFERED_OUTPUT'] ?>
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //} ?>
                </div>
                <?php unset($sState) ?>
            <?php } ?>
            <?php unset($arPayment) ?>
        </div>
    </div>
</div>
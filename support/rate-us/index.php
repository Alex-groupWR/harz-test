<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оцените качество нашего сервиса");

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/rate.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/rate.css");
?>
    <div class="container rate-us">
        <div class="page-section page-print-support rate-us__support">
            <div class="left-sidenav rate-us__left" id="leftSidenav">

            </div>

            <div class="main right-col rate-us__right">
                <h1 data-lang="<?=LANGUAGE_ID?>" class="title rate-us__title">Оцените качество нашего сервиса</h1>
                <p class="descr rate-us__descr">Ваша оценка и комментарий помогут нам стать лучше!</p>

                <form action="" class="rate-us__form" enctype="multipart/form-data" id="rateForm">
                    <div class="rate-us__mini-section rate-us__mini-section-input">
                        <div class="rate-us__input-wrap">
                            <label class="rate-us__form-control rate-us__form-control-input">
                                <span class="rate-us__label rate-us__label-input">Номер заказа</span>
                                <input class="rate-us__input" type="text" name="order" value="<?= $_GET['ORDER_NUMBER']??null ?>" />
                            </label>
                        </div>
                        <div class="rate-us__input-wrap">
                            <label class="rate-us__form-control rate-us__form-control-input">
                                <span class="rate-us__label rate-us__label-input">Email</span>
                                <input class="rate-us__input" type="email" name="email"  />
                            </label>
                        </div>
                    </div>

                    <div class="rate-us__mini-section">
                        <h2 class="rate-us__mini-title">Качество материала</h2>

                        <div class="rate-us__radio-buttons">
                            <? $i = 0;?>
                            <? while ($i < 10) { ?>
                                <? $i++;?>
                                <label class="rate-us__form-control">
                                    <span class="rate-us__label"><?=$i;?></span>
                                    <input type="radio" name="material" value="<?=$i?>" />
                                </label>
                            <? } ?>
                        </div>


                        <div class="rate-us__problems">
                            <p class="rate-us__problem rate-us__problem--quest">Проблемы с печатью? Обращались ли вы в техподдержку?</p>

                            <div class="rate-us__checkbox-row">
                                <label class="custom-checkbox rate-us__checkbox">
                                    <input type="checkbox" name="problem" value="yes">
                                    <span>Да</span>
                                </label>

                                <label class="custom-checkbox rate-us__checkbox">
                                    <input type="checkbox" name="problem" value="no">
                                    <span>Нет</span>
                                </label>
                            </div>
                            <p class=" rate-us__problem rate-us__problem--no">
                                Опишите проблему и сделайте фото. Также прикрепите фото с оборота бутылки (где виден номер партии, дата производства и срок годности). Отправьте на <a href="mailto:support@harzlabs.ru">support@harzlabs.ru</a>.
                            </p>
                        </div>
                    </div>

                    <div id="tech" class="rate-us__mini-section">
                        <h2 class="rate-us__mini-title">Общение с отделом техподдержки</h2>

                        <div class="rate-us__radio-buttons">
                            <? $i = 0;?>
                            <? while ($i < 10) { ?>
                                <? $i++;?>
                                <label class="rate-us__form-control">
                                    <span class="rate-us__label"><?=$i;?></span>
                                    <input type="radio" name="technicalSupport" value="<?=$i?>" />
                                </label>
                            <? } ?>
                        </div>
                    </div>

                    <div class="rate-us__mini-section">
                        <h2 class="rate-us__mini-title">Общение с отделом продаж</h2>

                        <div class="rate-us__radio-buttons">
                            <? $i = 0;?>
                            <? while ($i < 10) { ?>
                                <? $i++;?>
                                <label class="rate-us__form-control">
                                    <span class="rate-us__label"><?=$i;?></span>
                                    <input type="radio" name="sales" value="<?=$i?>"  />
                                </label>
                            <? } ?>
                        </div>
                    </div>

                    <div class="rate-us__mini-section">
                        <h2 class="rate-us__mini-title">Доставка</h2>

                        <div class="rate-us__radio-buttons">
                            <? $i = 0;?>
                            <? while ($i < 10) { ?>
                                <? $i++;?>
                                <label class="rate-us__form-control">
                                    <span class="rate-us__label"><?=$i;?></span>
                                    <input type="radio" name="delivery" value="<?=$i?>"  />
                                </label>
                            <? } ?>
                        </div>
                    </div>

                    <div class="rate-us__mini-section rate-us__mini-section--without-border">
                        <h2 class="rate-us__mini-title rate-us__mini-title--last">Поделитесь своим впечатлением о заказе</h2>
                        <p class="rate-us__mini-descr">Расскажите что понравилось, а с чем возникли проблемы.</p>

                        <textarea placeholder="Комментарий по заказу" class="rate-us__textarea" name="comment"></textarea>

                        <div class="input-file-row rate-us__file-row">
                            <label class="input-file">
                                <input type="file" accept="image/*" class="rate-us__file" name="file[]" multiple>
                                <span class="rate-us__file-title">Прикрепить фото</span>
                                <div class="input-file-list1 rate-us__file-list"></div>
                            </label>
                            <p class=" rate-us__file-descr">Для выбора нескольких фото, выбирайте, удерживая клавишу Ctrl</p>
                        </div>
                    </div>

                    <div class="errors rate-us__errors_fields">Вы не заполнили поле: <span></span></div>
                    <div class="errors rate-us__errors_rates">Вы не поставили оценку в поле: <span></span></div>
                    <button class="rate-us__btn" data-success="Отзыв отправлен">Отправить отзыв</button>
                </form>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
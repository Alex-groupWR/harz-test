<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString(
    '<script src="https://www.google.com/recaptcha/api.js?render=6LdYikErAAAAALPf0KlcQQ9grE3FIJZM3WvpVvzP"></script>'
);
?>
    <div data-lang="<?=LANGUAGE_ID?>" class="rate-web__popup">
        <h2 class="rate-web__title-wrapper">
            <span class="rate-web__title"><?= Loc::GetMessage("TITLE") ?></span>
            <img src="<?=$templateFolder?>/images/close.svg" class="rate__close-img">
        </h2>
        <div class="rate-web__popup-container">
            <form enctype="multipart/form-data" action="">
                <input type="hidden" name="g-recaptcha-response-rate" id="g-recaptcha-response-rate">
                <div class="rate-us__mini-section rate-us__mini-section--without-border rate-web__mini-section">
                    <h3 class="rate-us__mini-title rate-web__mini-title"><?= Loc::GetMessage("IMPRESSION") ?></h3>

                    <div class="rate-us__radio-buttons rate-web__radio-buttons">
                        <? $i = 0;?>
                        <? while ($i < 10) { ?>
                            <? $i++;?>
                            <label class="rate-us__form-control rate-web__form-control">
                                <span class="rate-us__label"><?=$i;?></span>
                                <input type="radio" name="impression" value="<?=$i?>"  />
                            </label>
                        <? } ?>
                    </div>
                </div>

                <div class="rate-us__mini-section rate-us__mini-section--without-border rate-web__mini-section rate-web__mini-section--last">
                    <h3 class="rate-us__mini-title rate-us__mini-title--last rate-web__mini-title">
                        <?= Loc::GetMessage("SUGGESTIONS") ?>
                    </h3>

                    <textarea placeholder="<?= Loc::GetMessage("OPINION") ?>" class="rate-us__textarea rate-web__textarea"></textarea>
                </div>
                <div class="rate-web__result"><?= Loc::GetMessage("THANK_YOU") ?></div>
                <div class="errors rate-us__errors rate-web__errors"><?= Loc::GetMessage("ERROR") ?></div>
                <div class="errors rate-us__errors rate-web__errors-comment"><?= Loc::GetMessage("ERROR_COMMENT") ?></div>
                <div class="errors rate-us__errors rate-web__errors-captcha"><?= Loc::GetMessage("ERROR_CAPTCHA") ?></div>
                <button class="rate-us__btn rate-web__btn-send"><?= Loc::GetMessage("SEND") ?></button>
            </form>
            <button class="rate-us__btn rate-web__btn-close"><?= Loc::GetMessage("CLOSE") ?></button>
        </div>
    </div>
    <div class="rate-web">
        <div class="rate-web__animate"></div>
        <div class="rate-web__inner-mask"></div>
            <div class="rate-web__btn">
                <img src="<?=$templateFolder?>/images/star.svg" class="rate__img">
                <span class="rate-web__btn-title"><?= Loc::GetMessage("TITLE") ?></span>
            </div>
    </div>

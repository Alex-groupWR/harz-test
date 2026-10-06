<?php
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(SITE_TEMPLATE_PATH . '/header.php');
?>
<div class="modal modal--dealer" style="display: none;">
    <a href="" class="modal__close js-hide-modal"></a>
    <div class="modal__body">
        <form class="form" action="/local/ajax/form.php" method="post">
            <input type="hidden" name="action" value="dealer">
            <div class="form__wrapper">
                <div class="form__title"><?= Loc::getMessage('Become a reseller') ?></div>

                <div class="form__desc"><?= Loc::getMessage('DESCR') ?></div>
                <div class="form__desc"><?= Loc::getMessage('Please fill in all fields') ?></div>

                <div class="form__body form__body--narrow">
                    <div class="form__rows">
                        <div class="form__row">
                            <label class="form__input" data-placeholder="<?= Loc::getMessage('Company name') ?>">
                                <input type="text" name="company">
                            </label>
                        </div>

                        <div class="form__row">
                            <label class="form__input" data-placeholder="<?= Loc::getMessage('Country') ?>">
                                <input type="text" name="country">
                            </label>
                        </div>

                        <div class="form__row">
                            <label class="form__input" data-placeholder="<?= Loc::getMessage('Your email') ?>">
                                <input type="text" name="email">
                            </label>
                        </div>

                        <div class="form__row">
                            <label class="form__input" data-placeholder="<?= Loc::getMessage('Contact person') ?>">
                                <input type="text" name="person">
                            </label>
                        </div>
                    </div>

                    <div class="form__buttons">
                        <button class="form__button" type="submit"><?= Loc::getMessage('Registration') ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

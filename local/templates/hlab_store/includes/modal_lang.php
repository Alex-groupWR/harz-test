<div class="modal modal--lang" style="display: none;">
    <a href="" class="modal__close js-hide-modal"></a>
    <div class="modal__body">
        <div class="languages languages--modal">
            <div class="languages__wrapper">
                <?php foreach($GLOBALS['languages'] as $CODE => $LANGUAGE) { ?>
                    <div class="languages__links">
                        <a href="?lang=<?= $CODE ?>" class="languages__link"><?= $LANGUAGE ?></a>
                    </div>
                <?} ?>
            </div>

        </div>
    </div>
</div>
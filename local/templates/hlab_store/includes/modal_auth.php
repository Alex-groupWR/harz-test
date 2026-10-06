<!-- <div class="modal modal--auth" style="display: none;">
    <a href="" class="modal__close js-hide-modal"></a>
    <div class="modal__body">
        <form class="form">
            <div class="form__wrapper">
                <div class="form__title">
                    Log in
                </div>

                <div class="form__desc">
                    Please fill in all fields
                </div>

                <div class="form__body form__body--narrow">
                    <div class="form__rows">
                        <div class="form__row">
                            <label class="form__input" data-placeholder="E-mail">
                                <input type="email">
                            </label>
                        </div>

                        <div class="form__row">
                            <label class="form__input" data-placeholder="Password">
                                <input type="password">
                            </label>
                        </div>
                    </div>

                    <div class="form__buttons">
                        <button class="form__button" type="submit">
                            Authorization
                        </button>
                    </div>

                    <div class="form__rows">
                        <div class="form__row">
                            <div class="form__text form__text--tac">
                                У вас еще нет аккаунта? <a href="" class="form__link js-show-modal"
                                                           data-modal="modal--reg">Зарегистрироваться</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> -->


<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth_form", Array(
    "FORGOT_PASSWORD_URL" => "/auth/",  // Forgotten Password Page
        "PROFILE_URL" => "/personal/",  // Profile page
        "REGISTER_URL" => "/auth/register/",    // Registration page
        "SHOW_ERRORS" => "Y",   // Show errors
        'AJAX_MODE' => 'Y',
    ),
    false
);?>
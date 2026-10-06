<div class="support">
    <div class="support__bg"></div>
    <div class="support__wrapper">
        <div class="support__title">
            Советы и ответы от команды Harz labs
        </div>
        <div class="support__search">
            <form action="/support/search/" method="post">
                <label class="search search--dark">
                    <input type="search" class="search__item search__item--dark" placeholder="Искать ответы" name="q"
                           maxlength="50" value="<?= $_REQUEST['q'] ?>">
                </label>
            </form>
        </div>
    </div>
</div>
<?$APPLICATION->IncludeComponent("bitrix:search.page", "support_empty", Array(
    "AJAX_MODE" => "N",	// Включить режим AJAX
    "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
    "AJAX_OPTION_HISTORY" => "Y",	// Включить эмуляцию навигации браузера
    "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
    "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
    "CACHE_TIME" => "3600",	// Время кеширования (сек.)
    "CACHE_TYPE" => "A",	// Тип кеширования
    "CHECK_DATES" => "Y",	// Искать только в активных по дате документах
    "DEFAULT_SORT" => "rank",	// Сортировка по умолчанию
    "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под результатами
    "DISPLAY_TOP_PAGER" => "Y",	// Выводить над результатами
    "FILTER_NAME" => "",	// Дополнительный фильтр
    "NO_WORD_LOGIC" => "Y",	// Отключить обработку слов как логических операторов
    "PAGER_SHOW_ALWAYS" => "Y",	// Выводить всегда
    "PAGER_TEMPLATE" => "",	// Название шаблона
    "PAGER_TITLE" => "Результаты поиска",	// Название результатов поиска
    "PAGE_RESULT_COUNT" => "150",	// Количество результатов на странице
    "RESTART" => "Y",	// Искать без учета морфологии (при отсутствии результата поиска)
    "SHOW_WHEN" => "N",	// Показывать фильтр по датам
    "SHOW_WHERE" => "N",	// Показывать выпадающий список "Где искать"
    "USE_LANGUAGE_GUESS" => "Y",	// Включить автоопределение раскладки клавиатуры
    "USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
    "USE_TITLE_RANK" => "Y",	// При ранжировании результата учитывать заголовки
    "arrFILTER" => array(	// Ограничение области поиска
        0 => "iblock_content",
    ),
    "arrFILTER_iblock_content" => array(	// Искать в информационных блоках типа "iblock_content"
        0 => "4",
    ),
    "arrWHERE" => "",
    "COMPONENT_TEMPLATE" => ".default"
),
    false
);?>
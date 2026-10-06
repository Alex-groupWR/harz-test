<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?>
<div class="container">

	<div class="page-section text-page support-page">
		<div class="left-sidenav-text-page">
            <?if(LANGUAGE_ID=="en"):?>
			<ul class="nav flex-column">
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#print-settings"> Printing preferences </a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#ourProducts"> Our Products </a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#afterWork"> Post-processing </a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#print"> Print </a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#lookingMaterials"> Material overview </a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#bye"> Purchase </a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#delivery"> Shipping </a>
                </li>
                <li class = "nav-item">
                    <a class="nav-link" href="/support/#supportService"> Support </a>
                </li>
            </ul>
            <?else:?>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#print-settings">Настройки печати</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#ourProducts">Наши продукты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#afterWork">Постобработка</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#print">Печать</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#lookingMaterials">Обзор материалов</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#bye">Покупка</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#delivery">Доставка</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/support/#supportService">Служба поддержки</a>
                    </li>
                </ul>
            <?endif;?>
		</div>

		<div class="main right-col">
			<div class="support-block">
				<div class="print-settings" id="print-settings">
					<div class="name-support">
                        <?if(LANGUAGE_ID=="en"):?>
                            <h1> Print Settings </h1>
                        <?else:?>
                            <h1>Настройки печати</h1>
                        <?endif?>

					</div>
                    <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list","support_setting_printer",
                        Array(
                            "VIEW_MODE" => "TEXT",
                            "SHOW_PARENT_NAME" => "Y",
                            "IBLOCK_TYPE" => "content",
                            "IBLOCK_ID" => "39",
                            "SECTION_ID" => false,
                            "SECTION_CODE" => "",
                            "SECTION_URL" => "",
                            "COUNT_ELEMENTS" => "Y",
                            "TOP_DEPTH" => "2",
                            "SECTION_FIELDS" => "",
                            "SECTION_USER_FIELDS" => "",
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_NOTES" => "",
                            "CACHE_GROUPS" => "Y",
                            "COUNT_PRINTERS" => 999999
                        )
                    );?>

				</div>










				</div>

			</div>


		</div>
	</div>
</div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>


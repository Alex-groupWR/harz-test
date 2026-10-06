<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle("О компании - HARZ Labs");
$APPLICATION->SetPageProperty('title', "О компании - HARZ Labs");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

Loc::loadMessages(SITE_TEMPLATE_PATH . "/index.php");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/vendor/jquery.fancybox.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/slick/slick.js");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/slick/slick.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/slick/slick-theme.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/style/jquery.fancybox.min.css");


?><?$APPLICATION->IncludeComponent(
	"bitrix:advertising.banner",
	"banner_custaom2",
	Array(
		"BS_ARROW_NAV" => "Y",
		"BS_BULLET_NAV" => "Y",
		"BS_CYCLING" => "N",
		"BS_EFFECT" => "fade",
		"BS_HIDE_FOR_PHONES" => "N",
		"BS_HIDE_FOR_TABLETS" => "N",
		"BS_KEYBOARD" => "Y",
		"BS_WRAP" => "Y",
		"CACHE_TIME" => "",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "banner_custaom2",
		"DEFAULT_TEMPLATE" => "-",
		"NOINDEX" => "N",
		"QUANTITY" => "1",
		"TYPE" => "REK"
	)
);?> <? /* $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/includes/header.php", Array(), Array("MODE" => "php")); */ ?>
<div class="container">
	 <!-- style="padding-top: 15px;" -->
	<div class="page-section text-page company-page" style="padding-top: 150px;">
		 <!-- style="padding-top: 0px;  margin-top: 0; top: 150px;" -->
		<div class="left-sidenav-text-page">
			<ul class="nav flex-column">
				<li class="nav-item"> <a class="nav-link" href="#about">О нас</a> </li>
				<li class="nav-item"> <a class="nav-link" href="#video">Видео</a> </li>
				<li class="nav-item"> <a class="nav-link" href="#team">Команда</a> </li>
				<li class="nav-item"> <a class="nav-link" href="#history">История</a> </li>
				 <? /*      <li class="nav-item">
                        <a class="nav-link" href="#worth">Ценности</a>
                    </li>
                 <li class="nav-item">
                        <a class="nav-link" href="#priorities">Приоритеты</a>
                    </li>*/ ?>
				<li class="nav-item"> <a class="nav-link" href="#job">Карьера в Harz Labs</a> </li>
				<li class="nav-item"> <a class="nav-link" href="#certificates">Сертификаты</a> </li>
				<li class="nav-item"> <a class="nav-link" style="text-align: left;" href="#quality">Политика в области качества</a> </li>
				 <? /*   <li class="nav-item">
                        <a class="nav-link" href="#thanks">Благодарности</a>
                    </li>*/ ?>
				<li class="nav-item"> <a class="nav-link" href="#news">Новости</a> </li>
				<li class="nav-item"> <a class="nav-link" href="#media">СМИ о нас</a> </li>
				<li class="nav-item"> <a class="nav-link" href="#offices">Контакты</a> </li>
				 <? /* <li class="nav-item">
                        <a class="nav-link" href="404.html">404</a>
                    </li>*/ ?>
			</ul>
		</div>
		<div class="main right-col">
			<div class="company-block">
				<div id="about">
				</div>
				<div class="about-block">
					<div class="clearfix">
					</div>
					<div class="slogan" id="slogan">
						 Ваше воображение
					</div>
					<div class="clearfix">
					</div>
					<div class="row">
						<div class="col-lg-4">
							<p>
								 HARZ Labs — отечественный лидер в разработке и&nbsp;производстве фотополимеров для 3D-печати с собственным лабораторно-производственным комплексом. Компания основана в Москве в 2017 году. Профессиональная команда, современное оборудование и передовые методы управления делают HARZ Labs одним из самых технологичных игроков на рынке 3D-печати.<br>
 <br>
								 В рабочие процессы внедрена интегрированная система менеджмента качества ISO 9001 и ISO 13485, позволяющие выпускать продукцию в полном соответствии с мировыми стандартами.
							</p>
						</div>
						<div class="col-lg-4">
							<p>
								 Основное направление разработок — фотополимеры промышленного и медицинского назначения, при этом медицинские материалы компании имеют регистрационное удостоверение на территории РФ.<br>
 <br>
								 HARZ Labs активно выстраивает коммуникацию со своей аудиторией, предоставляя профессиональную техническую поддержку, обучение по 3D-печати и разработку материалов по индивидуальному техническому заданию. <br>
 <br>
								 Компания поддерживает и укрепляет партнёрские отношения с ведущими учебными заведениями, стоматологическими клиниками, зуботехническими лабораториями и крупными производствами.
							</p>
						</div>
						<div class="col-lg-4">
							<p>
								 HARZ Labs является регулярным участником международных отраслевых выставок. Продукция компании востребована более чем в 80 странах, а сеть реселлеров насчитывает 50 компаний-партнёров по всему миру. Поддерживать связь с рынком за пределами РФ помогает представительство компании, расположенное в Европе.<br>
 <br>
								 HARZ Labs — это компания, предлагающая своим клиентам эффективные решения для профессиональных задач в области фотополимерной 3D-печати, основанные на высоком качестве продукта, сервиса, а также надежности и технологических инновациях.
							</p>
						</div>
					</div>
					<div class="slogan yellow-letters">
						 Наши материалы
					</div>
					<div class="clearfix">
					</div>
				</div>
				<div id="video">
				</div>
				<div class="section-video">
					<h1>Видео о нас</h1>
					<div class="block-video" style=" max-width: none;">
						<div class="bg-video" style="height: auto;">
							 <!-- 		 <iframe width="100%" height="450px" src="https://www.youtube.com/embed/e4NQImQbiWI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
							<div style="position: relative; width: 100%; padding-top: 56.25%;">
								 <iframe 
						    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
						    src="https://rutube.ru/play/embed/278c397870ee731b903d46bf8e9b7958/?skinColor=8e24aa" 
						    frameborder="0" 
						    allow="clipboard-write; autoplay" 
						    webkitallowfullscreen 
						    mozallowfullscreen 
						    allowfullscreen>
						  </iframe>
							</div>
							 <? /* <iframe width="100%" height="450px" poster="/static/img/videoposter.jpg" controls src="https://www.youtube.com/embed/CKL7L52jltA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>*/ ?>
						</div>
					</div>
				</div>
				<div id="team">
				</div>
				<div class="section-team">
					<h1>Команда</h1>
					 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"comands",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FIELD_CODE" => array(0=>"ID",1=>"",),
		"FILE_404" => "",
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => "42",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "99",
		"PAGER_BASE_LINK" => "",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"EMAIL",1=>"DOLGNOST",2=>"DESCRIPTION",3=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
					<div class="row team-text">
						 <? if (LANGUAGE_ID == "ru"): ?>
						<div class="col-md-6">
							<p>
								 Мы – команда единомышленников, объединенных идеей создания инновационных российских продуктов и продвижения их на зарубежные рынки. Основным направлением работы компании является создание продуктов для цифровой стоматологии.
							</p>
						</div>
						<div class="col-md-6">
							<p>
								 Основными приоритетами в нашей работе являются высокое качество продукции и ориентация на удовлетворение потребностей клиента. HARZ Labs предоставляет огромные возможности для профессионального и карьерного роста сотрудников, включая молодых специалистов выпускников ВУЗов, которые ещё не имеют опыта работы. Мы уделяем особое внимание формированию позитивной и дружелюбной атмосфере в коллективе, поощряем новые идеи и предложения, творческий подход в решении научных и технологических задач.
							</p>
						</div>
						 <? else: ?>
						<div class="col-md-6">
							<p>
								 We are a team of like-minded people united by the idea of ​​creating innovative Russian products and promoting them to foreign markets. The main focus of the company is the creation of products for digital dentistry.
							</p>
						</div>
						<div class="col-md-6">
							<p>
								 The entire Dental product line has passed medical certification in Russia. The company has created all the conditions for work and development: a competitive salary, a comfortable office with a recreation and entertainment area, a democratic atmosphere, an English language learning program at the expense of the company, and more.
							</p>
						</div>
						 <? endif; ?>
					</div>
				</div>
				<div id="history">
				</div>
				<div class="section-history">
					<h1>История</h1>
					<div class="history__table">
						<div class="history__table-row">
							<div class="history__year">
								 2017
							</div>
							<div class="history__img-cell">
 <img alt="2017" src="/local/templates/hlab_store/img/years/ru/2017.svg" class="history__img">
							</div>
							<div class="history__events">
								<ul class="history__list">
									<li class="history__list-item">Лучший стартап года на выставке 3D Print Expo.</li>
									<li class="history__list-item">Компания Harz Labs основана в Москве в 2017 году выпускниками МГУ и является одним из крупнейших российских разработчиков и производителей материалов для 3D печати. Производственный корпус в г. Мытищи.</li>
								</ul>
							</div>
						</div>
						<div class="history__table-row">
							<div class="history__year">
								 2018
							</div>
							<div class="history__img-cell">
 <img alt="2018" src="/local/templates/hlab_store/img/years/ru/2018.svg" class="history__img">
							</div>
							<div class="history__events">
								<ul class="history__list">
									<li class="history__list-item">В 2018 году открыто международное представительство и склад в Европе (Латвия).</li>
									<li class="history__list-item">Постоянный участник российских и зарубежных выставок в области технологий 3D печати.</li>
									<li class="history__list-item">Участник крупнейшей в мире ежегодной выставки по 3D-печати FORMNEXT во Франкфурте-на-Майне.</li>
								</ul>
							</div>
						</div>
						<div class="history__table-row">
							<div class="history__year">
								 2019
							</div>
							<div class="history__img-cell">
 <img alt="2019" src="/local/templates/hlab_store/img/years/ru/2019.svg" class="history__img">
							</div>
							<div class="history__events">
								<ul class="history__list">
									<li class="history__list-item">С 2019 резидент инновационного центра "Сколково" в рамках кластера "Ядерные технологии".</li>
									<li class="history__list-item">Запуск нового производственного корпуса и собственной исследовательской лаборатории.</li>
									<li class="history__list-item">Участник крупнейшей в мире ежегодной выставки по 3D-печати FORMNEXT во Франкфурте-на-Майне.</li>
								</ul>
							</div>
						</div>
						<div class="history__table-row">
							<div class="history__year">
								 2020
							</div>
							<div class="history__img-cell">
 <img alt="2020" src="/local/templates/hlab_store/img/years/ru/2020.svg" class="history__img">
							</div>
							<div class="history__events">
								<ul class="history__list">
									<li class="history__list-item">Сертификация стоматологических фотополимеров в России. Получение регистрационного удостоверения на медицинское изделие № РЗН 12007.</li>
									<li class="history__list-item">Разработка и запуск производства фотополимеров для промышленных 3Д-принтеров.</li>
									<li class="history__list-item">Участник крупнейшей в мире ежегодной выставки по 3D-печати FORMNEXT во Франкфурте-на-Майне.</li>
								</ul>
							</div>
						</div>
						<div class="history__table-row">
							<div class="history__year">
								 2021
							</div>
							<div class="history__img-cell">
 <img alt="2021" src="/local/templates/hlab_store/img/years/ru/2021.svg" class="history__img">
							</div>
							<div class="history__events">
								<ul class="history__list">
									<li class="history__list-item">Сеть компаний-реселлеров насчитывает 40 компаний, продукция реализуется в 70 странах мира.</li>
									<li class="history__list-item">Участник крупнейшей в мире ежегодной выставки по 3D-печати FORMNEXT во Франкфурте-на-Майне.</li>
									<li class="history__list-item">Участник крупнейшей в мире стоматологической выставки IDS в Кёльне.</li>
									<li class="history__list-item">Обладатель премии "Экспортер года" в Подмосковье по итогам 2020 года.</li>
								</ul>
							</div>
						</div>
						<div class="history__table-row">
							<div class="history__year">
								 2022
							</div>
							<div class="history__img-cell">
 <img alt="2022" src="/local/templates/hlab_store/img/years/ru/2022.svg" class="history__img">
							</div>
							<div class="history__events">
								<ul class="history__list">
									<li class="history__list-item">Запущен новый лабораторно-производственный корпус (2000 м², объём выпуска 60 т/мес.).</li>
									<li class="history__list-item">Запущен образовательный центр в сфере аддитивных технологий. Получена лицензия на образовательную деятельность.</li>
									<li class="history__list-item">Член ассоциации 3D-печати в России.</li>
									<li class="history__list-item">Обладатель премии "Экспортер года" в Подмосковье по итогам 2021 года.</li>
								</ul>
							</div>
						</div>
						<div class="history__table-row">
							<div class="history__year">
								 2023
							</div>
							<div class="history__img-cell">
 <img alt="2023" src="/local/templates/hlab_store/img/years/ru/2023.svg" class="history__img">
							</div>
							<div class="history__events">
								<ul class="history__list">
									<li class="history__list-item">Продукция реализуется более чем в 80 странах мира.</li>
									<li class="history__list-item">Пройден аудит на соответствие стандарту менеджмента качества ISO 13485 – ”производитель медицинских изделий”.</li>
									<li class="history__list-item">В компании внедрены системы менеджмента качества ISO 13485 и ISO 9001.</li>
									<li class="history__list-item">Обладатель премии "Экспортер года" в Подмосковье по итогам 2022 года.</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				 <? /*
                    <div id="worth"></div>
                    <div class="section-worth">
                        <h1>Ценности</h1>
                        <div class="d-flex flex-row flex-worth">
                            <div class="single-worth">
                                <h2>Ориентация на клиента</h2>
                                <p>наша компания открыта клиентам. Мы готовы отвечать на любые вопросы наших клиентов и рады видеть их у нас</p>
                            </div>
                            <div class="single-worth">
                                <h2 style="color:#8956D2;">Работа на перспективу</h2>
                                <p>мы выстраиваем долгосрочные отношения и относимся с уважением к своим коллегам, партнерам и клиентам</p>
                            </div>
                            <div class="single-worth">
                                <h2 style="color:#867793;">Ответственность</h2>
                                <p>полное осознание последствий своего выбора и последующих действий, принятие на себя ответственности за результат</p>
                            </div>
                            <div class="single-worth">
                                <h2 style="color:#AD890B;">Качество продукции</h2>
                                <p>Наша компания открыта клиентам. Мы готовы отвечать на любые вопросы наших клиентов и рады видеть их у нас</p>
                            </div>
                            <div class="single-worth">
                                <h2 style="color:#9159BD;">Ориентация на цели</h2>
                                <p>Целеориентированность: мы работаем на результат</p>
                            </div>
                            <div class="single-worth">
                                <h2 style="color:#DBB42A;">Объективность</h2>
                                <p>Объективность: мы принимаем решения основываясь на фактах</p>
                            </div>
                            <div class="single-worth">
                                <h2 style="color:#C7AAF1;">Гибкость</h2>
                                <p>Гибкость: мы поддерживаем дух стартапа, открытость и инициативность в сотрудниках</p>
                            </div>
                            <div class="single-worth">
                                <h2 style="color:#C3AED6;">Красота и стройность</h2>
                                <p>Красота и стройность: в компании должна быть как внутренняя красота (в процессах, в офисе, в документации), так и внешняя (в продукте, в общении)</p>
                            </div>
                        </div>
                    </div>

             <div id="priorities"></div>
                    <div class="section-priorities">
                        <h1>Приоритеты</h1>
                        <div class="d-flex flex-row flex-priorities">
                            <div class="single-priorities">
                                <div class="number">1</div>
                                <h2>Качество</h2>
                                <p>Качество нашей продукции и услуг должно превосходить ожидания потребителей и соответствовать нормативным документам тех стран, на территории которых она реализуется</p>
                            </div>
                            <div class="single-priorities">
                                <div class="number">2</div>
                                <h2>Эволюция</h2>
                                <p>Постоянно улучшать качество продукции, процессов управления и производства в компании</p>
                            </div>
                            <div class="single-priorities">
                                <div class="number">3</div>
                                <h2>Сервис</h2>
                                <p>Обеспечивать высокий уровень сервиса для партнеров и клиентов во всех аспектах взаимодействия с клиентом: техническая поддержка, доставка продукции, работа с рекламациями, социальные сети, процесс продажи и т.д.</p>
                            </div>
                        </div>
                    </div>*/ ?>
				<div id="job">
				</div>
				<div class="section-job">
					<h1>Карьера в HARZ Labs</h1>
					<?/*
					<div class="d-flex justify-content-between advantages">
						<div class="d-flex align-content-center elem-advantage align-items-end">
							<div>
							</div>
							<div class="text-advantage">
								 Оформление согласно<br>
								 ТК РФ
							</div>
						</div>
						<div class="d-flex align-content-center elem-advantage align-items-end">
							<div>
							</div>
							<div class="text-advantage">
								 Демократичная дружелюбная атмосфера
							</div>
						</div>
						<div class="d-flex align-content-center elem-advantage align-items-end">
							<div>
							</div>
							<div class="text-advantage">
								 Личностный и карьерный<br>
								 рост
							</div>
						</div>
						<div class="d-flex align-content-center elem-advantage align-items-end">
							<div>
							</div>
							<div class="text-advantage">
								 Комфортный <br>
								 современный<br>
								 офис
							</div>
						</div>
						<div class="d-flex align-content-center elem-advantage align-items-end">
							<div>
							</div>
							<div class="text-advantage">
								 Льготные программы для сотрудников
							</div>
						</div>
					</div>
					 <?$APPLICATION->IncludeComponent(
							"bitrix:news.list",
							"vakan",
							Array(
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"ADD_SECTIONS_CHAIN" => "Y",
								"AJAX_MODE" => "Y",
								"AJAX_OPTION_ADDITIONAL" => "",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"CACHE_FILTER" => "Y",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"CHECK_DATES" => "Y",
								"COMPONENT_TEMPLATE" => "comands",
								"DETAIL_URL" => "",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"DISPLAY_DATE" => "Y",
								"DISPLAY_NAME" => "Y",
								"DISPLAY_PICTURE" => "Y",
								"DISPLAY_PREVIEW_TEXT" => "Y",
								"DISPLAY_TOP_PAGER" => "Y",
								"FIELD_CODE" => array(0=>"ID",1=>"",),
								"FILE_404" => "",
								"FILTER_NAME" => "",
								"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
								"IBLOCK_ID" => "44",
								"IBLOCK_TYPE" => "content",
								"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
								"INCLUDE_SUBSECTIONS" => "Y",
								"MESSAGE_404" => "",
								"NEWS_COUNT" => "99",
								"PAGER_BASE_LINK" => "",
								"PAGER_BASE_LINK_ENABLE" => "Y",
								"PAGER_DESC_NUMBERING" => "Y",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_PARAMS_NAME" => "arrPager",
								"PAGER_SHOW_ALL" => "Y",
								"PAGER_SHOW_ALWAYS" => "Y",
								"PAGER_TEMPLATE" => "",
								"PAGER_TITLE" => "Новости",
								"PARENT_SECTION" => "",
								"PARENT_SECTION_CODE" => "",
								"PREVIEW_TRUNCATE_LEN" => "",
								"PROPERTY_CODE" => array(0=>"Name_EN",1=>"PREW_EN",2=>"EMAIL",3=>"DOLGNOST",4=>"DESCRIPTION",5=>"",),
								"SET_BROWSER_TITLE" => "N",
								"SET_LAST_MODIFIED" => "N",
								"SET_META_DESCRIPTION" => "N",
								"SET_META_KEYWORDS" => "N",
								"SET_STATUS_404" => "Y",
								"SET_TITLE" => "N",
								"SHOW_404" => "Y",
								"SORT_BY1" => "ACTIVE_FROM",
								"SORT_BY2" => "SORT",
								"SORT_ORDER1" => "DESC",
								"SORT_ORDER2" => "ASC",
								"STRICT_SECTION_CHECK" => "N"
							)
					);
					<div class="no-vacancy">
						<h2>Нет подходящей вакансии?<br>
						 загрузите резюме и мы свяжемся с вами</h2>
						<div class="dwnl-resume" data-toggle="modal" data-target="#getJobModal">
							 Загрузить свое резюме в PDF
						</div>
					</div>*/?>
					<div class="job-banner">
						<? $jobBannerFile = \Bitrix\Main\Config\Option::get( "askaron.settings", "UF_JOBBANNER_IMAGE"); ?>
						<? $jobBannerImage = CFile::GetFileArray($jobBannerFile) ?>
						<img class="job-banner__image" src="<?=$jobBannerImage['SRC'] ?>" width="1160" height="361" alt="">
						<div class="job-banner__content">
							<div class="job-banner__content-top">
								<div class="job-banner__title">Стань частью команды HARZ Labs</div>
								<div class="job-banner__features">
									<div>узнать о работе у нас</div>
									<div>вакансии</div>
									<div>прислать резюме</div>
								</div>
							</div>
							<a href="<?echo \Bitrix\Main\Config\Option::get( "askaron.settings", "UF_JOBBANNER_URL");?>" class="job-banner__button" target="_blank"><?echo \Bitrix\Main\Config\Option::get( "askaron.settings", "UF_JOBBANNER_BUTTON_TEXT");?></a>
						</div>
					</div>
				</div>
				 <!-- The Modal -->
				<div class="modal" id="getJobModal">
					<div class="bx24-modal-container">
						 <script data-b24-form="inline/29/fg6qh5" data-skip-moving="true">
						(function (w, d, u) {
							var s = d.createElement('script');
							s.async = true;
							s.src = u + '?' + (Date.now() / 180000 | 0);
							var h = d.getElementsByTagName('script')[0];
							h.parentNode.insertBefore(s, h);
						})(window, document, 'https://bx.harzlabs.ru/upload/crm/form/loader_29_fg6qh5.js');
					</script>
					</div>
				</div>
				<div id="certificates">
				</div>
				<div class="section-certificates">
					<h2>Сертификаты</h2>
					 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"sert",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "sert",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"FIELD_CODE" => array(0=>"ID",1=>"",),
		"FILE_404" => "",
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"IBLOCK_ID" => "50",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "99",
		"PAGER_BASE_LINK" => "",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "Y",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_PARAMS_NAME" => "arrPager",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"NAME_EN",1=>"PREW_EN",2=>"Name_EN",3=>"EMAIL",4=>"DOLGNOST",5=>"DESCRIPTION",6=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "N",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
					<div id="quality">
					</div>
					<div class="quality">
						<h2 class="quality__title">Политика в области качества</h2>
						<div class="d-flex quality__row justify-content-between">
 <img src="/img/quality.png" class="quality__img">
							<p class="quality__name">
								 Документация системы менеджмента качества
							</p>
 <a href="/img/quality-policy.pdf" class="quality__link" download="">скачать</a>
						</div>
					</div>
					<div id="news">
					</div>
					<div class="section-news">
						<div id="news2">
						</div>
						<h1>Новости о компании</h1>
						 <?
					$arNewsFilter = (LANGUAGE_ID=="ru") ? ['SECTION_ID' => 224, "!PROPERTY_HIDE_RU_VALUE"   =>   'Y'] : ['SECTION_ID' => 224, "!PROPERTY_HIDE_EN_VALUE"   =>   'Y'];

					$APPLICATION->IncludeComponent(
						"bitrix:news.list",
						"news_about",
						array(
							"DISPLAY_DATE" => "Y",
							"DISPLAY_NAME" => "Y",
							"DISPLAY_PICTURE" => "Y",
							"DISPLAY_PREVIEW_TEXT" => "Y",
							"AJAX_MODE" => "Y",
							"IBLOCK_TYPE" => "content",
							"IBLOCK_ID" => ID_IB_NEWS_RU,
							"NEWS_COUNT" => "4",
							"SORT_BY1" => "ACTIVE_FROM",
							"SORT_ORDER1" => "DESC",
							"SORT_BY2" => "SORT",
							"SORT_ORDER2" => "ASC",
							"FILTER_NAME" => "arNewsFilter",
							"FIELD_CODE" => array(
								0 => "",
								1 => "",
							),
							"PROPERTY_CODE" => array(
								0 => "PREVIEW_TEXT_RU",
								1 => "DETAIL_TEXT_RU",
								2 => "NAME_EN",
								3 => "PREW_EN",
								4 => "Name_EN",
								5 => "EMAIL",
								6 => "DOLGNOST",
								7 => "DESCRIPTION",
								8 => "",
							),
							"CHECK_DATES" => "Y",
							"DETAIL_URL" => "",
							"PREVIEW_TRUNCATE_LEN" => "",
							"ACTIVE_DATE_FORMAT" => "j M Y",
							"SET_TITLE" => "N",
							"SET_BROWSER_TITLE" => "N",
							"SET_META_KEYWORDS" => "N",
							"SET_META_DESCRIPTION" => "N",
							"SET_LAST_MODIFIED" => "Y",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
							"ADD_SECTIONS_CHAIN" => "N",
							"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
							"PARENT_SECTION" => "",
							"PARENT_SECTION_CODE" => "",
							"INCLUDE_SUBSECTIONS" => "Y",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "3600",
							"CACHE_FILTER" => "Y",
							"CACHE_GROUPS" => "Y",
							"DISPLAY_TOP_PAGER" => "Y",
							"DISPLAY_BOTTOM_PAGER" => "Y",
							"PAGER_TITLE" => "Новости",
							"PAGER_SHOW_ALWAYS" => "Y",
							"PAGER_TEMPLATE" => "",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "Y",
							"PAGER_BASE_LINK_ENABLE" => "Y",
							"SET_STATUS_404" => "N",
							"SHOW_404" => "N",
							"MESSAGE_404" => "",
							"PAGER_BASE_LINK" => "",
							"PAGER_PARAMS_NAME" => "arrPager",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"AJAX_OPTION_HISTORY" => "N",
							"AJAX_OPTION_ADDITIONAL" => "",
							"COMPONENT_TEMPLATE" => "news_about",
							"STRICT_SECTION_CHECK" => "N",
							"FILE_404" => ""
						),
						false
					); ?>
					</div>
					<div class="section-news">
						<div id="media">
						</div>
						<h1>СМИ о нас</h1>
						 <?
					$arNewsFilter = (LANGUAGE_ID=="ru") ? ['SECTION_ID' => 1991, "!PROPERTY_HIDE_RU_VALUE"   =>   'Y'] : ['SECTION_ID' => 1991, "!PROPERTY_HIDE_EN_VALUE"   =>   'Y'];

					$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"smi_about", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "Y",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => ID_IB_MEDIA_RU,
		"NEWS_COUNT" => "4",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arNewsFilter",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "PREVIEW_TEXT_RU",
			2 => "DETAIL_TEXT_RU",
			3 => "NAME_EN",
			4 => "PREW_EN",
			5 => "Name_EN",
			6 => "EMAIL",
			7 => "DOLGNOST",
			8 => "DESCRIPTION",
			9 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "j M Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "news_about",
		"STRICT_SECTION_CHECK" => "N",
		"FILE_404" => ""
	),
	false
); ?>
					</div>
					<div id="offices">
					</div>
					<div class="section-offices">
						<h1>Контакты</h1>
						 <!-- <div class="block-map">
							<div id="map">
							</div> -->
						<div class="d-flex justify-content-start block-offices">
							<div class="office">
								<h2>Мытищи</h2>
								<p style=" margin-bottom: 20px; height: 27px;">
 <b style=" font-weight: bold;">Производство, Склад, Офис</b>
								</p>
								<p style=" margin-top: 0px;">
									 141006, Россия, Моск. обл., г. Мытищи, ул. Силикатная, д. 51А, стр. 6
								</p>
								<p style=" margin-top: 0px;">
 <b style=" font-weight: bold;">самовывоз заказов производится по данному адресу</b>
								</p>
								<p style=" margin-top: 0px;">
 <b style=" font-weight: bold;">С 10:30 до 17:30</b>
								</p>
							</div>
							 <!-- 		<div class="office">
								<h2>Мытищи</h2>
								<p style=" margin-bottom: 20px;">
 <b style="font-weight: bold;">Офис</b>
								</p>
								<p style=" margin-top: 0px;">
									 141002, Россия, Моск. обл., г. Мытищи, ул. Колпакова, д. 2, стр. 13, офис 265
								</p>
								<p style=" margin-top: 0px;">
 <b style=" font-weight: bold;">С 10:00 до 19:00</b>
								</p>
							</div> --> <? /* 13.03.2026 ?>
							<div class="office">
								 <? if (LANGUAGE_ID == "ru"): ?>
								<h2>Москва</h2>
								 <? else: ?>
								<h2>Moscow</h2>
								 <? endif; ?> 
<? if (LANGUAGE_ID == "ru"): ?>
								<p style=" margin-bottom: 20px; height: 27px;">
 <b style=" font-weight: bold;">Центр Инновационных Разработок</b>
								</p>
								<p style=" margin-top: 0px;">
									 121205, Россия, г. Москва, территория инновационного центра «Сколково», ул. Луговая, д. 4, к. 5, пом. 6
								</p>
								<p style=" margin-top: 0px;">
 <b style=" font-weight: bold;">С 10:00 до 19:00</b>
								</p>
								 <? else: ?>
								<? /* 13.03.2026 ?>
								<p style=" margin-bottom: 20px;">
 <b style=" font-weight: bold;"> Innovation Center </b>
								</p>
								<p style="margin-top: 0px;">
									 121205, Russia, Moscow, ter. Skolkovo Innovation Center, Bolshoi blvd., 42, building 1, room 1061
								</p>
								 <? endif; ?>
							</div>
<? */ ?>
							<div class="office">
								 <? if (LANGUAGE_ID == "ru"): ?>
								<h2>Рига</h2>
								 <? else: ?>
								<h2>Riga</h2>
								 <? endif; ?> <? if (LANGUAGE_ID == "ru"): ?>
								<p style=" margin-bottom: 20px; height: 27px;">
 <b style="font-weight: bold;">Европейское представительство, Международный склад</b>
								</p>
								<p style=" margin-top: 0px;">
									 Slavu iela 7, Riga, LV-1083, Latvia
								</p>
								<p style=" margin-top: 0px;">
 <b style=" font-weight: bold;">С 10:00 до 19:00 (по московскому времени)</b>
								</p>
								 <? else: ?>
								<p style=" margin-bottom: 20px;">
 <b style=" font-weight: bold;">European office + International warehouse</b>
								</p>
								<p style=" margin-top: 0px;">
									 Slavu iela 7, Riga, LV-1083, Latvia
								</p>
								 <? endif; ?>
							</div>
						</div>
					</div>
					<div class="company-card">
						<h2 class="company-card__title">Карточка предприятия</h2>
						<div class="company-card__download">
							<a href="Карточка предприятия ХЛ Мытищи_02.02.2026.pdf" download="Карточка предприятия ХАРЦ Лабс" class="company-card__download-btn">Скачать карточку документом</a>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Полное наименование
							</p>
							<p class="company-card__text">
								 Общество с ограниченной «ХАРЦ Лабс»
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Сокращенное наименование
							</p>
							<p class="company-card__text">
								 ООО «ХАРЦ Лабс»
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Юридический адрес
							</p>
							<p class="company-card__text">
								 141013 Московская область, г.о. Мытищи, г. Мытищи, ул. Силикатная, влд. 51А к.5
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Фактический адрес
							</p>
							<p class="company-card__text">
								 141013 Московская область, г.о. Мытищи, г. Мытищи, ул. Силикатная, влд. 51А к.5
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Почтовый адрес (адрес для корреспонденции)
							</p>
							<p class="company-card__text">
								 141013, Московская область, Мытищинский район, г. Мытищи, ул. Силикатная, д.37, а/я № 466
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 ИНН/КПП
							</p>
							<p class="company-card__text">
								 7751087784/502901001
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 ОГРН
							</p>
							<p class="company-card__text">
								 5177746037728 присвоен: 05.10.2017
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Р/счет
							</p>
							<p class="company-card__text">
								 40702 810 8 0258 0002792
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Банк
							</p>
							<p class="company-card__text">
								 АО "АЛЬФА-БАНК"
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 БИК
							</p>
							<p class="company-card__text">
								 044525593
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 К/счет
							</p>
							<p class="company-card__text">
								 30101 810 2 0000 0000593
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 ОКАТО/ОКПО
							</p>
							<p class="company-card__text">
								 45283582000/19743175
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 ОКВЭД
							</p>
							<p class="company-card__text">
								 21.20.2 Производство материалов, применяемых в медицинских целях
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Тел.
							</p>
							<p class="company-card__text">
								 8 800 550 9344
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Эл.почта
							</p>
							<p class="company-card__text">
 <a href="mailto:info@harzlabs.ru">info@harzlabs.ru</a>
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Генеральный директор
							</p>
							<p class="company-card__text">
								 Адамов Андрей Владимирович
							</p>
						</div>
						<div class="company-card__row rerow">
							<p class="company-card__small-title">
								 Действует на основании
							</p>
							<p class="company-card__text">
								 Устава
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		 <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/company.js"); ?> <script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script> <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChtunykUf13dUyK_1CTWK1YkzuVZTQcps&callback=initMap&libraries=&v=weekly"
        async>
</script>
	</div>
</div>
 <br><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
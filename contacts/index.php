<?php require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetTitle("Контакты - HARZ labs");


?><div class="page-section page-section--contacts text-page new-page">
	<div class="main container right-col">
		<div class="tab-content">
			<div class="container tab-pane active">



				<div class="section-offices">
					<h1>Контакты</h1>
					<div>
						<div class="office">
							<h2>Мытищи</h2>
							<p style=" margin-bottom: 10px; margin-top: 20px;"><b style="   font-weight: bold;">Производство + Склад + Офис</b></p>
							<p style="    margin-top: 0px;">141006, Россия, Моск. обл., г. Мытищи, ул. Силикатная, д. 51А,
								стр. 6</p>
							<p style="    margin-top: 0px;"><b style="    font-weight: bold;">самовывоз заказов производится по данному адресу</b></p>
						</div>
					<!-- 	<div class="office">
							<h2>Мытищи</h2>
							<p style=" margin-bottom: 20px;"><b style="font-weight: bold;">Офис</b></p>
							<p style="    margin-top: 0px;">141002, Россия, Моск. обл., г. Мытищи, ул. Колпакова, д. 2, стр.
								13, офис 265</p>
						</div> -->

						<? /* 13.03.2026 ?>
						<div class="office">
							<? if (LANGUAGE_ID == "ru"): ?>
								<h2>Москва</h2>
							<? else: ?>
								<h2>Moscow</h2>
							<? endif; ?>
							<? if (LANGUAGE_ID == "ru"): ?>
								<p style=" margin-bottom: 20px;"><b style="  font-weight: bold;">Центр Инновационных Разработок</b></p>
								<p style="    margin-top: 0px;">121205, Россия, г. Москва, тер. Инновационного Центра Сколково,
									Большой б-р, д. 42, стр. 1, помещение 1061</p>
							<? else: ?>
								<p style=" margin-bottom: 20px;"><b style=" font-weight: bold;"> Innovation Center </b></p>
								<p style="margin-top: 0px;"> 121205, Russia, Moscow, ter. Skolkovo Innovation Center, Bolshoi
									blvd., 42, building 1, room 1061 </p>
							<? endif; ?>
						</div>
						<? */ ?>

						<div class="office">
							<? if (LANGUAGE_ID == "ru"): ?>
								<h2>Рига</h2>
							<? else: ?>
								<h2>Riga</h2>
							<? endif; ?>
							<? if (LANGUAGE_ID == "ru"): ?>
								<p style=" margin-bottom: 20px;"><b style="font-weight: bold;">Европейское представительство + Международный склад</b></p>
								<p style="    margin-top: 0px;">Slavu iela 7, Riga, LV-1083, Latvia</p>
							<? else: ?>
								<p style=" margin-bottom: 20px;"><b style="  font-weight: bold;">European office + International warehouse</b></p>
								<p style="    margin-top: 0px;">Slavu iela 7, Riga, LV-1083, Latvia</p>
							<? endif; ?>
						</div>
					</div>
				</div>

			</div>

		</div>
		<div class="container">
			<div class="company-card">
					<meta name="format-detection" content="telephone=no"> 
				<?/*<h2 class="company-card__title">Карточка предприятия</h2>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Полное наименование</p>        
							<p class="company-card__text">Общество с ограниченной «ХАРЦ Лабс»</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Сокращенное наименование</p>        
							<p class="company-card__text">ООО «ХАРЦ Лабс»</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Юридический адрес</p>        
							<p class="company-card__text">123298  Г. Москва, ВН.ТЕР.Г. МУНИЦИПАЛЬНЫЙ ОКРУГ ХОРОШЕВО-МНЕВНИКИ, УЛ. 3-Я ХОРОШЁВСКАЯ, Д.13, К.1, ПОМЕЩ. 4.4</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Фактический адрес</p>        
							<p class="company-card__text">141001, г. Мытищи, ул. Силикатная, д.51А, стр.5</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Почтовый адрес (адрес для корреспонденции)</p>        
							<p class="company-card__text">141013, Московская область, Мытищинский район, г. Мытищи, ул. Силикатная, д.37, а/я № 466</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">ИНН/КПП</p>        
							<p class="company-card__text">7751087784/773401001</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">ОГРН</p>        
							<p class="company-card__text">5177746037728 присвоен: 05.10.2017</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Р/счет</p>        
							<p class="company-card__text">40702 810 8 0258 0002792</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Банк</p>        
							<p class="company-card__text">АО "АЛЬФА-БАНК"</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">БИК</p>        
							<p class="company-card__text">044525593</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">К/счет</p>        
							<p class="company-card__text">30101 810 2 0000 0000593</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">ОКАТО / ОКПО</p>        
							<p class="company-card__text">45283577000/ 19743175</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">ОКВЭД</p>        
							<p class="company-card__text">72.19 научные исследования и разработки в области естественных и технических наук прочие</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Тел.</p>        
							<p class="company-card__text">8 800 550 9344 </p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Эл.почта</p>        
							<p class="company-card__text">info@harzlabs.ru</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Генеральный директор</p>        
							<p class="company-card__text">Адамов Андрей Владимирович</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Действует на основании</p>        
							<p class="company-card__text">Устава</p>    
				</div>*/?>
<h2 class="company-card__title">Карточка предприятия</h2>
<div class="company-card__download">
				<a href="Карточка предприятия ХАРЦ Лабс  Мытищи_02.02.2026 (Актуальная).docx" download="Карточка предприятия ХАРЦ Лабс.docx" class="company-card__download-btn">Скачать карточку документом</a>
				</div> 
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Полное наименование</p>        
							<p class="company-card__text">Общество с ограниченной «ХАРЦ Лабс»</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Сокращенное наименование</p>        
							<p class="company-card__text">ООО «ХАРЦ Лабс»</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Юридический адрес</p>        
							<p class="company-card__text">141013  Московская область, г.о. Мытищи, г. Мытищи, ул. Силикатная, влд. 51А к.5</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Фактический адрес</p>        
							<p class="company-card__text">141013  Московская область, г.о. Мытищи, г. Мытищи, ул. Силикатная, влд. 51А к.5</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Почтовый адрес (адрес для корреспонденции)</p>        
							<p class="company-card__text">141013, Московская область, Мытищинский район, г. Мытищи, ул. Силикатная, д.37, а/я № 466</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">ИНН/КПП</p>        
							<p class="company-card__text">7751087784/502901001</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">ОГРН</p>        
							<p class="company-card__text">5177746037728 присвоен: 05.10.2017</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Р/счет</p>        
							<p class="company-card__text">40702 810 8 0258 0002792</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Банк</p>        
							<p class="company-card__text">АО "АЛЬФА-БАНК"</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">БИК</p>        
							<p class="company-card__text">044525593</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">К/счет</p>        
							<p class="company-card__text">30101 810 2 0000 0000593</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">ОКАТО/ОКПО</p>        
							<p class="company-card__text">45283582000/19743175</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">ОКВЭД</p>        
							<p class="company-card__text">21.20.2 Производство материалов, применяемых в медицинских целях</p>    
						</div>    
						<div class="company-card__row rerow">        
							<p class="company-card__small-title">Тел.</p>        
							<p class="company-card__text">8 800 550 9344 </p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Эл.почта</p>        
							<p class="company-card__text">info@harzlabs.ru</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Генеральный директор</p>        
							<p class="company-card__text">Адамов Андрей Владимирович</p>    
						</div>    <div class="company-card__row rerow">        
							<p class="company-card__small-title">Действует на основании</p>        
							<p class="company-card__text">Устава</p>    
						</div>
					</div>
				</div>
	</div>

</div>

<? require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php' ?>
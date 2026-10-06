<?
require($_SERVER["DOCUMENT_ROOT"]."/static/header-support.php");
$APPLICATION->SetTitle("3D-печать для начинающих");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D-печать для начинающих</title>
    <link rel="stylesheet" href="support.css">
</head>

<body>
    <div class="article-new-design">
        <div class="custom-article">
            <div class="custom-div">
                <div>
                    <h1>Фотополимерная 3Д-печать для начинающих</h1>
                        <h2>Что такое фотополимерная 3D-печать?</h2>
                </div>
        
                <div>
                    <p>
                            Фотополимерная 3D-печать — это метод создания объемных объектов из жидких фотополимерных смол, которые затвердевают под воздействием света определенной длины волны и интенсивности.
                    </p>
                </div>
        
                <div class="backgrey">
                        <p>
                            <b>
                              Фотополимерные принтеры делятся на разные подвиды технологий в зависимости от устройства оптической системы:
                            </b>
        
                         </p>
                        <img src="https://bx.harzlabs.ru/upload/medialibrary/c01/thvm28g18vv8tjaeb789gr7yh9yadunq/MSLA.png" alt="LCD/MSLA технология печати">
                        <P>
                            <b>LCD (MSLA)</b> – для формирования картинки используется ЖК-матрица и набор светодиодов.
                        </P>
                        <img src="https://bx.harzlabs.ru/upload/medialibrary/45d/3hdy97chryycil76ydf3371rjl6js9vp/SLA.png" alt="SLA технология печати">
                        <P>
                            <b>SLA</b> – для формирования картинки используется лазерный луч и сканатор, который заштриховывает слой.
                        </P>

                        <img src="https://bx.harzlabs.ru/upload/medialibrary/92b/icums77rqvctmbkdyj3w60amm95zkeul/DLP.png" alt="DLP технология печати">
                        <P>
                            <b>DLP</b> – для формирования картинки используется проектор, состоящий из DMD-матрицы с&nbsp;микрозеркалами и&nbsp;одного светодиода.
                        </P>
                </div>
        
                <div>
                        <h2>Как работать с фотополимерной печатью?</h2>
                        <h3>1. Подготовка 3D-модели</h3>
                        <p>Сначала создается или скачивается 3D-модель. Модель должна создаваться с учетом способа ее изготовления.</p>
                        <p><b>Популярные программы для создания 3D-моделей:</b></p>
                        <UL class="und-list">
                            <li><b>Инженерные:</b> Autodesk Fusion, Siemens NX, Компас 3D.</li>
                            <li><b>Стоматологические:</b> Exocad, Blender for Dental.</li>
                            <li><b>Художественные:</b> Blender, Zbrush.</li>
                        </UL>
                </div>

                <div class="backgrey">
                        <p><b>На что обратить внимание при создании и экспорте модели?</b></p>
                        <img src="https://bx.harzlabs.ru/upload/medialibrary/5af/5dg08mo2fd9wkmshjjmh4u5mo92a4xej/Stl.png" alt="STL формат">
                        <P>
                            <b>Формат.</b> Большинство принтеров работают с форматом STL.
                        </P>

                        <img src="https://bx.harzlabs.ru/upload/medialibrary/98e/88ukq0i13lz78qudlkap5en8pcy4iksy/Hole.png" alt="3д-модель с замкнутыми полостями">
                        <P>
                            <b>Замкнутые полости.</b> Их отсутствие важно, чтобы избежать скопления смолы внутри модели, иначе это приведет к разрушению модели.
                        </P>

                        <img src="https://bx.harzlabs.ru/upload/medialibrary/99d/cmi05wuqxev73uqk18f7kfn4z6if7t5s/Defekty.png" alt="Дефекты сетки 3д-модели">
                        <P>
                            <b>Дефекты сетки.</b> Проверьте модель на разрывы, и вывернутые полигоны. Проверку можно сделать в программах Matrialise Magics или Voxel Dance Additive.
                        </P>
                </div>
        
                <div class="backblack">
                        <h3>2. Использование слайсеров</h3>
                        <p>Модель загружается в слайсер для подготовки к печати. Такие программы обычно идут на флешке с принтером, но лучше скачать более свежую версию с сайта производителя. Большинство принтеров работают с универсальными слайсерами, но есть и принтеры, которые работают только со своими программами.  </p>
                        <p><b>Примеры популярных программ:</b></p>
                        <UL class="und-list">
                            <li><a href="https://www.chitubox.com/" target="blank">Chitubox Basic</a></li>
                            <li><a href="https://mango3d.io/" target="blank">Lychee Slicer</a></li>
                            <li><a href="https://www.formware.co/slicer" target="blank">Formware 3D</a></li>
                            <li><a href="https://voxeldance.com/Tango" target="blank">Voxel Dance Tango</a></li>
                        </UL>
                        <br>
                        <p><b>В слайсере необходимо:</b></p>
                        <ol class="ord-list">
                            <li><b>Выбрать модель принтера</b></li>
                            <li><b><a href="https://harzlabs.ru/support/#print-settings" target="blank">Внести отправные параметры печати.</a> </b>
                                Для каждого нового принтера и каждого нового материала необходимо заново подбирать настройки печати. Даже две одинаковые модели принтеров могут иметь разные рабочие настройки и не всегда совпадать с теми, что мы указываем на сайте. Для подбора настроек используйте <a href="https://harzlabs.ru/support/printing/how-to-use-harz-labs-test/" target="blank">калибровочный тест.</a></li>
                            <li><b>Правильно расположить модель:</b> избегайте эффекта присоски, минимизируйте площадь каждого слоя. Отверстия будут точнее, если печатать их вертикально.</li>
                            <img class="img80" src="https://bx.harzlabs.ru/upload/medialibrary/b6e/yzyfyzw601cvm5o1wht0afjl1dm90mas/Supports.png" alt="Расстановка поддержек">
                            <br>
                            <li><b>Поставить поддержки:</b> Исходите из прочности материала и геометрии детали, поддержите все начальные точки и не дайте модели раскачиваться при печати.</li>
                            <li><b>Нарезать на слои:</b> программа сама нарежет ваш объект на слои и добавит к ним текстовый файл G-code</li>
                            <li><b>Сохранить файл в формате принтера.</b></li>
                            <li><b>Отправить файл на печать удаленно или через флешку.</b> Обратите внимание, что флешки иногда выходят из строя, это может привести к дефектной печати</li>
                        </ol>
                </div>
        
                <div>
                    <h3>3. Запуск принтера</h3>
                    <p><b>Перед печатью:</b></p>
                    <ul class="und-list">
                        <li>Убедитесь, что принтер установлен на устойчивой поверхности и уберите транспортировочные пленки.</li>
                        <li>Обеспечьте чистоту помещения, отсутствие вибраций и хорошую вентиляцию.</li>
                        <li>Проверьте температуру в помещении, должно быть не ниже 23°C.</li>
                        <li>Проведите калибровку платформы, <b>для этого нужно:</b></li>
                    </ul>
                    <br>
                    <div>
                        <div class="card-grid">
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/0b0/4k8ubf3pssy4c3cb6e1pb8kojl0k7kic/1-Remove-the-vat.jpg" alt="Снятие ванночки с 3д-принтера">
                                <p><b>1. Снять ванну принтера</b></p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/6a4/8flfmo10hnc1e36p2xmen1bbmv56ya8j/2-Check-the-Matrix.jpg" alt="Проверка матрицы 3д-принтера">
                                <p><b>2. Проверить чистоту матрицы</b></p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/d11/kdkxzqlf5elev2udf2k1slg5jhuae9rs/3-Check-the-platform.jpg" alt="Проверка платформы 3д-принтера">
                                <p><b>3. Проверить чистоту платформы</b></p>
                            </div>
                                <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/5d2/57cthwyvxjpxplrwazqa4rtkh6of6tsp/4-Loosen-the-adjustment-screws.jpg" alt="Регулировочные винты платформы 3д-принтера">
                                <p><b>4. Ослабить регулировочные винты на платформе, но не откручивать полностью</b></p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/189/gzewlv3ydplr7cjsvwkw4cu859nrt5d8/5-Put-a-sheet.jpg" alt="Калибровка 3д-принтера листом бумаги">
                                <p><b>5. Положить лист бумаги или калибровочную карту на экран принтера</b></p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/91a/m3acjhu01vyun11ck0ulodlrfpevmx2w/6-Start-calibrating.jpg" alt="запуск калибровки 3д-принтера">
                                <p><b>6. Запустить калибровку платформы</b></p>
                                <p>Платформа начнёт опускаться вниз</p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/ce2/v7rqpa1jwqu420anqr9zse51p9eypqsf/7-Tighten-the-adjustment-screws.jpg" alt="Затяжка винтов платформы 3д-принтера">
                                <p>7. После опускания и остановки платформы прижать ее рукой к листу бумаги <b>и&nbsp;затянуть регулировочные винты</b> крест-накрест</p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/927/21lmoo3fi4q4d43akt6azes2etmr00h0/8-Z_0.jpg" alt="Положение 0 3д-принтера">
                                <p>8. В настройках принтера <b>запомнить положение стола</b> нажав кнопку Z=0 (так нужно делать не на всех принтерах)</p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/5c3/h2jd2nq4rt6ga549kqdze3lxlkk1oogx/9-Finish-the-calibrating.jpg" alt="Завершение калибровки 3д-принтера">
                                <p><b>9. Вернуть стол в начальное положение,</b> завершив калибровку </p>
                            </div>
                        </div>
                        <div>
                            <ul class="und-list">
                                <li>Следом проверьте состояние плёнки на ванночке и залейте материал.</li>
                            </ul>
                        </div>
                        <div class="card-grid">
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/777/vr8xemt2uuxbk5nyudtegcch8ssl7n6h/10-Film.jpg" alt="Плохая и хорошая плёнка 3д-принтера">
                                <p><b>10. Проверьте состояние пленки ванны</b></p>
                                <p>При наличии дефектов и повреждений замените ее. Хорошая плёнка должна быть прозрачной, натянутой как барабан. Плохая плёнка матовая, с повреждениями и/или плохим натяжением.</p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/701/zqq1fd743kshnmqrjfyvaqxif0igb4jv/11-Fill-the-vat.jpg" alt="Заливка фотополимера в 3д-принтер">
                                <p><b>11. Хорошо взболтайте бутылку</b></p>
                                <p>А затем залейте материал в ванну до нужного уровня.</p>
                            </div>
                            <div class="card">
                                <img src="https://bx.harzlabs.ru/upload/medialibrary/3f9/utxhufufq2bapen8w7qo1fk234oz625z/12-Check-the-vat.jpg" alt="Проверка ванночки 3д-принтера">
                                <p><b>12. Удостоверьтесь, что на дне ванночки нет мусора или осадка</b></p>
                                <p>Аккуратно проведите несколько раз резиновым шпателем по дну ванночки. Делайте это перед каждым запуском на печать</p>
                            </div>
                        </div>
                        <div>
                            <ul class="und-list">
                                <li>Включите подогрев до 30°C (если это возможно).</li>
                                <li>Запустите файл на печать. </li>
                                <li>Не трогайте принтер в процессе работы. Останавливать принтер стоит только в случаях аварийной ситуации (посторонние звуки в трансмиссии, отрыв модели от стола и прочее).</li>
                            </ul>
                        </div>
                    </div>
                </div>
        
                <div class="backblack">
                    <h3>4. Постобработка</h3>
                    <p><b>После печати:</b></p>
                    <div class="card-grid">
                        <div class="card">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/898/lpe59vj6d8xf56jeywbjmrm97i6xsetx/13-Remove-the-model-from-the-platform.jpg" alt="Снятие модели с 3д-принтера">
                            <p><b>1. Снимите изделие с платформы, используя защитные перчатки, очки и инструменты</b></p>
                            <p>Будьте осторожны при снятии моделей, не&nbsp;допускайте попадания полимера на кожу и в глаза, остерегайтесь поломки лезвия ножа, если используете его.</p>
                        </div>
                        <div class="card">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/6fc/g3o7eh5payln1xd8xh6rmv7lop1kiwbu/14-wash.jpg" alt="Промывка 3д-модели в спирте">
                            <p><b>2. Проведите промывку в спирте (изопропиловом или этиловом), используя ультразвуковую ванну</b></p>
                            <p>Не допускайте нагрева спирта, т.к. это может привести к его активному испарению и риску пожара.</p>
                        </div>
                        <div class="card">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/983/lulb73d2hrrdj4qxhgfbkgu8iqs9lxlx/15-Use-compressed-air.jpg" alt="Продувка 3д-модели сжатым воздухом">
                            <p><b>3. Продуйте изделие сжатым воздухом</b></p>
                            <p>Это позволяет избавиться от остатков спирта на поверхности модели и оценить качество промывки. Если остаются глянцевые поверхности - их нужно повторно промыть.</p>
                        </div>
                        <div class="card">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/5de/n68jy2zbm4b1mqypzk162w3kw50bzbew/16-Remove-supports.jpg" alt="Удаление поддержек 3д-модели">
                            <p><b>4. Удалите поддержки вручную или удобным инструментом</b></p>
                            <p>Поддержки можно удалить как во время промывки, так и после прогрева.</p>
                        </div>
                        <div class="card">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/b91/29u2oo76ft7kcw470nt2htza3r3empw0/17-Use-Heater.jpg" alt="Прогрев 3д-модели в сушильном шкафу">
                            <p><b>5. Прогрейте изделия в сушильном шкафу</b></p>
                            <p>Важно, чтобы внутри шкафа была стабильная температура. Отдайте предпочтения тем устройствам, где есть датчик температуры.</p>
                        </div>
                        <div class="card">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/64f/kehjozavwfssao1kqdt5768v065to4aq/18-Use-UV_chamber.jpg" alt="Засветка 3д-модели в УФ-камере">
                            <p><b>6. Засветите модель в УФ-камере согласно <a href="https://harzlabs.ru/support/finishing/how-long-do-i-post-cure-my-prints/" target="blank">рекомендациям для вашей УФ-камеры</a></b></p>
                        </div>
                    </div>
                    <p><b>Рекомендуемое оборудование для обработки, режимы прогрева и засветки можно найти <a href="https://harzlabs.ru/support/finishing/how-long-do-i-post-cure-my-prints/" target="blank">здесь</a></b></p>
                </div>
                <div class="back">
                    <h3>5. Последуюшая работа с принтером</h3>
                    <div class="card-grid-2">
                        <div class="card-black">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/6cc/dcle51zpcklaepggg0szxlpug83r0olz/19-Check-the-vat.jpg" alt="Проверка ванны 3д-принтера на наличие мусора">
                            <p><b>Проверьте ванну на наличие остатков смолы или мусора</b></p>
                            <p>При необходимости профильтруйте материал через фильтр или используйте очистку ванны.</p>
                        </div>
                        <div class="card-black">
                            <img src="https://bx.harzlabs.ru/upload/medialibrary/e42/jdsktx6qdpa9moofuc1v82sx5dw7ttsu/20-Filter-resin.jpg" alt="Слив фотополимера в бутылку">
                            <p><b>Смена и хранение материла</b></p>
                            <p>Если материал не используется повторно, или вы меняете фотополимер – слейте его обратно в бутылку через фильтр для краски. Подробнее читайте <a href="https://harzlabs.ru/support/materials-overview/resin-care/" target="blank">здесь</a></p>
                        </div>
                    </div>
                </div>
                <div class="backgrey">
                    <h3>Готово!</h3>
                    <p>Теперь вы знаете основные этапы фотополимерной 3D-печати. Следуйте этим рекомендациям, чтобы получить качественные результаты и избежать ошибок.</p>
                </div>
            </div>
        </div>
    </div>

	<script data-b24-form="inline/30/bt5rxu" data-skip-moving="true">
		(function (w, d, u) {
			var s = d.createElement('script');
			s.async = true;
			s.src = u + '?' + (Date.now() / 180000 | 0);
			var h = d.getElementsByTagName('script')[0];
			h.parentNode.insertBefore(s, h);
		})(window, document, 'https://bx.harzlabs.ru/upload/crm/form/loader_30_bt5rxu.js');
	</script>

</body>

<?require($_SERVER["DOCUMENT_ROOT"]."/static/footer-support.php");?>
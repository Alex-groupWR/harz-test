<?
require($_SERVER["DOCUMENT_ROOT"]."/static/header-support.php");
$APPLICATION->SetTitle("Программа тестирования фотополимеров HARZ Labs");
?>
<div class="container-73785">
    <h1>Программа тестирования фотополимеров HARZ Labs</h1>
    <h2 class="testing__title">Что представляет собой <br>
    Программа тестирования?</h2>
<p class="testing__descr mb-40">
    Программа тестирования HARZ Labs предоставляет зарегистрированным участникам образцы тестовых версий материалов. Ваши отзывы о качестве работы, режимах печати, стабильности материала и особых свойствах позволяют нам улучшать рецептуру чтобы делать фотополимеры HARZ Labs еще лучше.
    <br><br>
    <b>Обратите внимание, что тестовые версии материалов еще не выпущены HARZ Labs в основную линейку продукции, поэтому они могут быть несовершенны и меняться в процессе тестирования.</b>
</p>

<img src="/local/templates/hlab_store/img/involvement.png" class="testing__subtitle mb-40">

<p><b>Кто может принять участие?</b></p>
<p class="mb-60">Участие в программе может принять специалист в области фотополимерной печати или компания, использующая технологии аддитивного производства. Если вы уже применяете фотополимерную печать у себя в лаборатории или на производстве, обладаете комплектом оборудования из списка валидированного нами оборудования, а также имеете компетенции в интересующей нас сфере деятельности согласно специфике используемого материала, вы можете подать заявку на участие в программе.</p>

<p><b>Что дает участие в программе?</b></p>
<p class="mb-60">Участники программы тестирования HARZ Labs получают некоммерческий доступ к самым новым решениям в области фотополимерных материалов.
</p>

<p><b>Взимается ли плата за присоединение к программе?</b></p>
<p class="mb-60">Нет. Участие в программе бесплатно.</p>

<p><b>Какое вознаграждение я получу за участие в тестировании?</b></p>
<p class="mb-60">Эта программа является добровольной, и за участие в ней не предусмотрено вознаграждений.
</p>

<p><b>Как отправить отзыв в HARZ Labs?</b></p>
<p class="mb-60">Отзыв можно оставить вашему куратору от компании HARZ Labs. Он также проконсультирует вас по настройке, постобработке и всем особенностям работы с материалом.</p>

<p><b>Как стать участником?</b></p>
<p class="mb-60"> Заполните и отправьте форму, нажав на кнопку ниже.
    <br>После, с вами свяжется сотрудник HARZ Labs для подтверждения участив в программе.
    <a href="#form" class="print__btn " style="cursor: pointer;">Заполнить форму</a>
</p>

<img src="/local/templates/hlab_store/img/materials.jpg" class="testing__subtitle testing__subtitle--materials mb-40">

<div style="overflow-x:auto;">
    <table class="table">
        <tbody>
        <tr>
            <td class="table__title" width="20%"><b>Материал</b></td>
            <td class="table__title"><b>Цвет</b></td>
            <td class="table__title" width="25%"><b>Особые свойства</b></td>
            <td class="table__title"><b>Целевое использование</b></td>
        </tr>

       <tr>
            <td class="table__sub-title"><b>Nylon Like Water Washable </b></td>
            <td class="table__sub-value">Серый</td>
            <td class="table__sub-value">Имитирует свойства полиамида 6, отмывается водой</td>
            <td class="table__sub-value">Фотополимер для печати ударопрочных инженерных и художественных изделий, отмываемый водой. Для настольных LCD/DLP принтеров</td>
        </tr>

<tr>
            <td class="table__sub-title"><b>Dielectric</b></td>
            <td class="table__sub-value">Жёлтый прозрачный</td>
            <td class="table__sub-value">Низкая диэлектрическая проницаемость</td>
            <td class="table__sub-value">Диэлектрическая проницаемость 1.628. Тангенс угла диэлектрических потерь 5.39 × 10^-3. Для настольных LCD\DLP фотополимерных принтеров</td>
        </tr>

    <tr>
            <td class="table__sub-title"><b>J-Cast V2</b></td>
            <td class="table__sub-value">Красный</td>
            <td class="table__sub-value">Ювелирный литьевой материал</td>
            <td class="table__sub-value">Предназначен для художественного и ювелирного литья по выжигаемым моделям</td>
        </tr>
      

        </tbody>
    </table>
</div>

<div id="form" style="margin-bottom: 128px;"></div>
<div class="form">
    <div class="bx24-modal-container">
        <script data-b24-form="inline/39/ycsild" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://bx.harzlabs.ru/upload/crm/form/loader_39_ycsild.js');</script>
    </div>
</div>

<script>
const anchors = document.querySelectorAll('a[href*="#"]')

for (let anchor of anchors) {
  anchor.addEventListener('click', function (e) {
    e.preventDefault()
    
    const blockID = anchor.getAttribute('href').substr(1)
    
    document.getElementById(blockID).scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    })
  })
}
</script>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/static/footer-support.php");?>
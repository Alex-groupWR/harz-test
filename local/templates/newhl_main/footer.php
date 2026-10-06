<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?use Bitrix\Main\Page\Asset;?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(88230973, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/88230973" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    <?if (LANGUAGE_ID == 'ru') {?>
        <script>
            (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
            })(window,document,'https://bx.harzlabs.ru/upload/crm/site_button/loader_5_lkpdly.js');

            window.addEventListener('onBitrixLiveChat', function(event){
                var widget = event.detail.widget;
                widget.setOption('checkSameDomain', false);

                const callbackBTN =  $('a[data-b24-crm-button-widget="callback"]');

                // if ($(callbackBTN).length) {
                //     $('.b24-window-widget').remove()
                //     $(callbackBTN).attr('href', 'tel:+74952910200')
                //     $(callbackBTN).find('span').text('+7 495 291 02 00')
                //     $(callbackBTN).off()
                // }

                if (this.BX && this.BX.SiteButton && this.BX.SiteButton.buttons && this.BX.SiteButton.buttons.openerButtonNode) {
                    const target = this;
                    this.BX.SiteButton.buttons.openerButtonNode.addEventListener('click', function (event) {
                        console.log(target.BX.SiteButton.buttons.isShown)
                        if (target.BX.SiteButton.buttons.isShown) {
                            $('.rate-web').hide()
                        } else {
                            $('.rate-web').show()
                        }
                    })
                }

                if (this.BX && this.BX.SiteButton && this.BX.SiteButton.shadow && this.BX.SiteButton.shadow.shadowNode) {
                    const target = this;
                    this.BX.SiteButton.shadow.shadowNode.addEventListener('click', function (event) {
                        console.log(target.BX.SiteButton.buttons.isShown)
                        if (target.BX.SiteButton.buttons.isShown) {
                            $('.rate-web').hide()
                        } else {
                            $('.rate-web').show()
                        }
                    })
                }
            });
        </script>

        <!-- Top.Mail.Ru counter -->
        <script type="text/javascript">
            var _tmr = window._tmr || (window._tmr = []);
            _tmr.push({id: "3609484", type: "pageView", start: (new Date()).getTime()});
            (function (d, w, id) {
                if (d.getElementById(id)) return;
                var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
                ts.src = "https://top-fwz1.mail.ru/js/code.js";
                var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
                if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
            })(document, window, "tmr-code");
        </script>
        <noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3609484;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
        <!-- /Top.Mail.Ru counter -->
    <?} else { ?>
        <script>
        (function(w,d,u){
            var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
            var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://bx.harzlabs.ru/upload/crm/site_button/loader_6_ui1hip.js');
        </script>
    <?php } ?>


<? if (LANGUAGE_ID == 'en') { ?>
    <div class="cookie-popup">
        <div class="cookie-popup__popup">
            <p class="cookie-popup__text">We use cookies to improve your experience on our website. By continuing to use this site, you consent to the use of cookies in accordance with our <a href="/about/privacy-and-cookie-policy.php">Privacy & Cookie Policy</a>.</p>
            <button class="cookie-popup__btn">Accept</button>
        </div>
    </div>
<? } ?>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
	      rel="stylesheet">
<? critical_css_foot(); ?>
</body>
</html>

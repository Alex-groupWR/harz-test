<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>

<div class="help-article-block">
    <h3 id="hh33"><?= Loc::GetMessage("IS_HELPFUL") ?></h3>
    <div class="yes-or-no-block" id="yesOrNo">
        <div class="yes elem">
            <span class="text"><?= Loc::GetMessage("YES") ?></span>
            <? if ($arResult["isManager"]) { ?>
                <span class="counter"><?= $arResult["VOTES"]["PROPERTY_YES_COUNTER_VALUE"] ?></span>
            <? } ?>
            <svg width="18" height="16" viewBox="0 0 18 16" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M1.6087 7.08691H5.26087V15H1.6087C1.44726 15 1.29244 14.9358 1.17828 14.8217C1.06413 14.7075 1 14.5527 1 14.3913V7.69561C1 7.53417 1.06413 7.37935 1.17828 7.2652C1.29244 7.15104 1.44726 7.08691 1.6087 7.08691V7.08691Z"
                      stroke="#40344A" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5.26086 7.08696L8.30434 1C8.62408 1 8.94069 1.06298 9.23609 1.18534C9.53149 1.3077 9.7999 1.48704 10.026 1.71313C10.2521 1.93922 10.4314 2.20763 10.5538 2.50303C10.6761 2.79843 10.7391 3.11504 10.7391 3.43478V5.26087H15.447C15.6197 5.26087 15.7903 5.29758 15.9477 5.36856C16.105 5.43955 16.2455 5.54318 16.3597 5.67259C16.4739 5.802 16.5593 5.95422 16.6103 6.11916C16.6612 6.28409 16.6764 6.45797 16.655 6.62926L15.742 13.9336C15.7052 14.228 15.5621 14.4989 15.3397 14.6953C15.1172 14.8916 14.8307 15 14.534 15H5.26086"
                      stroke="#40344A" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="no elem">
            <span class="text"><?= Loc::GetMessage("NO") ?></span>
            <? if ($arResult["isManager"]) { ?>
                <span class="counter"><?= $arResult["VOTES"]["PROPERTY_NO_COUNTER_VALUE"] ?></span>
            <? } ?>
            <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M1.6087 9.47852H5.26087V1.00026H1.6087C1.44726 1.00026 1.29244 1.06897 1.17828 1.19127C1.06413 1.31358 1 1.47946 1 1.65243V8.82634C1 8.99931 1.06413 9.16519 1.17828 9.2875C1.29244 9.4098 1.44726 9.47852 1.6087 9.47852V9.47852Z"
                      stroke="#40344A" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5.26086 9.47826L8.30434 16C8.62408 16 8.94069 15.9325 9.23609 15.8014C9.53149 15.6703 9.7999 15.4782 10.026 15.2359C10.2521 14.9937 10.4314 14.7061 10.5538 14.3896C10.6761 14.0731 10.7391 13.7339 10.7391 13.3913V11.4348H15.447C15.6197 11.4348 15.7903 11.3955 15.9477 11.3194C16.105 11.2433 16.2455 11.1323 16.3597 10.9937C16.4739 10.855 16.5593 10.6919 16.6103 10.5152C16.6612 10.3385 16.6764 10.1522 16.655 9.96865L15.742 2.14256C15.7052 1.8271 15.5621 1.5369 15.3397 1.32651C15.1172 1.11611 14.8307 1 14.534 0.999999H5.26086"
                      stroke="#40344A" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <script>
        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        $("#yesOrNo .elem").click(function () {
            if (getCookie('page<?=$arParams["CURRENT_PAGE_ID"]?>')) {
                $("#hh33").html("<?= Loc::GetMessage('SORRY') ?>");
                $(".help-article-block #yesOrNo").html("<h3><?= Loc::GetMessage('YOUR_VOICE') ?></h3>");
            } else {
                const elemText = $(this).find('.text').text();
                const counter = $(this).find('.counter');

                let date = new Date(Date.now() + 86400e3);
                date = date.toUTCString();
                document.cookie = "page<?=$arParams['CURRENT_PAGE_ID']?>=yes; expires=" + date;

                $.post("/local/components/ptrhta/news.votes/templates/.default/set_vote.php",
                    {
                        elementId: '<?=$arParams["CURRENT_PAGE_ID"]?>',
                        iblockId: '<?=$arParams["IBLOCK_ID"]?>',
                        elem: elemText,
                    },
                    function (data) {
                        if (<?=$arResult["isManager"]?>) {
                            $(counter).text(data)
                        } else {
                            $("#hh33").html("<?= Loc::GetMessage('THANKS') ?>");
                            $(".help-article-block #yesOrNo").html("<h3><?= Loc::GetMessage('FEEDBACK_IS_HELPED') ?></h3>");
                        }
                    });
            }
        });
    </script>



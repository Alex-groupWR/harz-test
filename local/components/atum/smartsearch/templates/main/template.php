<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><div class="smartSearch js-smartSearch">
	<div class="smartSearch-form">
		<input type="hidden" class="js-smartSearch-search" />
		<input type="text" 
			class="js-smartSearch-input" 
			placeholder="<?//=GetMessage('FORM_PLACEHOLDER')?>"
			value="<?=htmlspecialchars($_GET["q"])?>" 
			onkeyup="smartsearch_<?=$arParams['ID']?>.keyup(this,event)"
			onclick="smartsearch_<?=$arParams['ID']?>.click(this,event)"
		/>
		<button class="js-smartSearch-clear" style="display: none;" onclick="smartsearch_<?=$arParams['ID']?>.clear(this,event)"></button>
		<button class="js-smartSearch-submit" onclick="toggleSearchNew()">
            <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                                                                  viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:#43384E;}
                        </style>
                <path class="st0" d="M15.4,14.9l-3.5-3.7c1.1-1.2,1.8-2.8,1.8-4.5c0-3.7-3-6.7-6.7-6.7S0.4,3,0.4,6.7s3,6.7,6.7,6.7
                            c1.5,0,2.8-0.5,3.9-1.3l3.5,3.7c0.1,0.1,0.3,0.2,0.4,0.2c0.1,0,0.3-0.1,0.4-0.2C15.6,15.6,15.6,15.2,15.4,14.9z M1.6,6.7
                            c0-3,2.4-5.4,5.4-5.4c3,0,5.4,2.4,5.4,5.4c0,3-2.4,5.4-5.4,5.4C4.1,12.1,1.6,9.7,1.6,6.7z"/>
                        </svg><?//=GetMessage("ATUM_SMARTSEARCH_POISK")?></button>
	</div>
	<div class="js-smartSearch-result"></div>
</div>
<script>
	var smartsearch_<?=$arParams['ID']?> = new JsSmartSearch('<?echo CUtil::JSEscape($templateFolder)?>/template_ajax.php','<?echo CUtil::JSEscape($componentPath)?>/ajax.php',<?=CUtil::PhpToJSObject($arParams)?>);
</script>
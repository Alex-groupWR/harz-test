<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arResult*/
/** @var array $arParams*/

if ($arResult['ITEMS_COUNT'] == 0 ){?>	<div class="smartSearch-empty"><?=GetMessage('ITEMS_NOT_FOUND')?></div>
<?}else{?>
	<div class="smartSearch-result-block" >
		<?foreach ($arResult['ITEMS'] as $key=>$item){ $page = floor($key / $arParams['ITEMS_COUNT_NAV']);?>
			<div class="js-smartSearch-result-item" data-page="<?=$page?>">
				<div class="smartSearch-result-item-center">
					<a href="<?=$item['URL']?>" class="smartSearch-result-item-picture" title="<?=$item['NAME']?>"<?if($item['PICTURE']){?> style="background-image: url('<?=$item['PICTURE']?>');"<?}?>></a>
					<div class="smartSearch-result-item-data">
						<a href="<?=$item['URL']?>" class="smartSearch-result-item-name" title="<?=$item['NAME']?>"><?=$item['NAME']?></a>
						<div class="smartSearch-result-item-info">
<!--							--><?//if($item['BREADCRUMB']){?><!--<div class="smartSearch-result-item-breadcrumb">--><?//=$item['BREADCRUMB']?><!--</div>--><?//}?>
<!--							--><?//if($item['DESCRIPTION']){?><!--<div class="smartSearch-result-item-description">--><?//=$item['DESCRIPTION']?><!--</div>--><?//}?>
<!--							--><?//if($item['ARTICLE']){?><!--<div class="smartSearch-result-item-article">--><?//=GetMessage("ATUM_SMARTSEARCH_ART")?><!----><?//=$item['ARTICLE']?><!--</div>--><?//}?>
							<?if($item['PRICE']>0){?>
								<div class="smartSearch-result-item-price">
									<?=GetMessage('PRICE')?>: <span<?=($item['OLD_PRICE'])?' class="new"':''?>><?=$item['PRICE_FORMATED']?></span>
									<?if($item['OLD_PRICE']){?><span class="old"><?=$item['OLD_PRICE_FORMATED']?></span><?}?>
								</div>
							<?}else{?>
								<div class="smartSearch-result-item-price"><?=GetMessage('PRICE')?>: <span><?=GetMessage('BY_REQUEST')?></span></div>
							<?}?>
						</div>
					</div>
				</div>
			</div>
		<?}

		if ($arResult['ITEMS_COUNT'] > $arParams['ITEMS_COUNT_NAV']){?>
			<div class="smartSearch-more" onclick="smartsearch_<?=$arParams['ID']?>.more(this,event)"><?=GetMessage('SHOW_MORE')?></div>
		<?}?>
	</div>
	
<?}?>
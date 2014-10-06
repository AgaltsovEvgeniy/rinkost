<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$trading = false;

if(preg_match('/^\/forex-trading\//', $_SERVER['REQUEST_URI'])){ $trading = true; }
?>
<div class="innerMenu secondry">
<?if (!empty($arResult)):?>
  <ul class="inner nav">
  <?
  foreach($arResult as $arItem):
  	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
  		continue;
  ?>
  	<?if($arItem["SELECTED"]):?>
  		<li class="active"><a href="<?=$arItem["LINK"]?>" <?if( $trading ): echo 'style="font-size: 8pt"'; endif;?> ><span><?=$arItem["TEXT"]?></span></a></li>
  	<?else:?>
  		<li><a href="<?=$arItem["LINK"]?>" <?if( $trading ): echo 'style="font-size: 8pt"'; endif;?>><span><?=$arItem["TEXT"]?></span></a></li>
  	<?endif?>
  <?endforeach?>
  </ul>
  <?endif?>
</div>
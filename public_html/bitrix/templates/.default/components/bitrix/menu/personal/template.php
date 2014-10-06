<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

?>
<?if (!empty($arResult)):
  $section = '';
?>
  <?
  foreach($arResult as $arItem):
    //new dBug($arItem);
  	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
  		continue;
    if ( $arItem['PARAMS']['SECTION'] != $section ) {
      if ($section) { echo '</ul>'; }
      echo '<div class="menuTitle">'.$arItem['PARAMS']['SECTION'].'</div><ul>';
      $section = $arItem['PARAMS']['SECTION'];
    }
  ?>
  	<?if($arItem["SELECTED"]):?>
  		<li class="active"><a href="<?=$arItem["LINK"]?>"><span><?=$arItem["TEXT"]?></span></a></li>
  	<?else:?>
  		<li><a href="<?=$arItem["LINK"]?>"><span><?=$arItem["TEXT"]?></span></a></li>
  	<?endif?>
  <?endforeach?>
  </ul>
  <?endif?>
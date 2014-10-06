<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>


<div class="searchRequest">Вы искали: <b class="boldText"><?=$arResult["REQUEST"]["QUERY"]?></b></div>
<div class="searchRows">
<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false){?>

<?} elseif(count($arResult["SEARCH"])>0) {?>

	<?foreach($arResult["SEARCH"] as $arItem){
    $arItem["URL_WO_PARAMS"] = str_replace('index.php', '', $arItem["URL_WO_PARAMS"]);
    //new dbug($arItem);
    /*if (  ) {

    }*/
    ?>
		<div class="row">
			<a href="<?=$arItem["URL_WO_PARAMS"];?>" class="title redText"><?=$arItem["TITLE_FORMATED"];?></a>
			<p><?=$arItem["BODY_FORMATED"];?></p>
		</div>
	<?}
	if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") { echo $arResult["NAV_STRING"]; }
		?>
<?} else {?>
	<?ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND"));?>
<?}?>
</div>
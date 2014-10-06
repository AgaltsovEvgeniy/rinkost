<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include $_SERVER['DOCUMENT_ROOT'].'/include/cache_country.php';
$country_id = (int)$_POST['country_id'];
if ( count($arRegions[$country_id]) ) {
?>
<label for="lSum" class="label">Регион</label>
<select name="region">
  <?
  foreach( $arRegions[$country_id] as $region ):?>
    <option value="<?=$region['ID']?>"><?=$region['NAME']?></option>
  <?endforeach;?>
</select>
<?
} else {
  echo'';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
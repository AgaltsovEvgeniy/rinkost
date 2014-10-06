<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$ID = (int)$_REQUEST['ID'];
if ( !$ID ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
$obCache = new CPHPCache();
$cacheID = $ID; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/depositing/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $arrData = $vars['arrData'];
} else {
  CModule::IncludeModule('iblock');
  $res = CIblockElement::GetList( array(), array('ID'=>$ID, 'ACTIVE'=>'Y'), false, false, array() );
  $arrData = $res->GetNext();
  $obCache->EndDataCache(array('arrData' => $arrData));
}
if ( !$arrData ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }

$APPLICATION->SetTitle($arrData['NAME']);
$APPLICATION->AddChainItem($arrData['NAME']);
echo'<div class="tipicalPage">';
echo $arrData['~DETAIL_TEXT'];
echo'<p></p><p><a href="javascript:void(0)" onclick="window.history.back()" class="backLink">Вернуться назад</a></p>';
echo'</div>';
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
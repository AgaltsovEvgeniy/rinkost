<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$code = htmlspecialchars( $_GET['ELEMENT_CODE'] );
// на всякий
if ( !$code ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
$obCache = new CPHPCache();
$cacheID = 'detail'.md5($code); // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/promotions/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $arrData = $vars['arrData'];
} else {
  $arrData = array('err'=>false, 'data'=>array());
  CModule::IncludeModule('iblock');
  $res = CIBlockElement::GetList( array(), array('IBLOCK_ID'=>CFG::IBLOCK_PROMOTIONS, 'ACTIVE'=>'Y', 'ACTIVE_DATE'=>'Y', '=CODE'=>$code), false, false, array() );
  if ( $arrData['data'] = $res->GetNext() ) {
    // получили
    $arrData['data']['DATE'] = CIBlockFormatProperties::DateFormat('d.m.Y', MakeTimeStamp($arrData['data']["ACTIVE_FROM"], CSite::GetDateFormat()));
    
  } else { $arrData['err'] = true; }
  $obCache->EndDataCache(array('arrData' => $arrData));
}
if ( $arrData['err'] ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
$APPLICATION->SetTitle($arrData['data']['NAME']);
$APPLICATION->AddChainItem($arrData['data']['NAME']);
?>
<?
echo'<div class="tipicalPage">';
echo'<div class="pinkDate vUglu">'.$arrData['data']['DATE'].'</div>'.$arrData['data']['~DETAIL_TEXT'].'<p></p>';
echo'<p><a href="javascript:void(0)" onclick="window.history.back()" class="backLink">К списку акций</a></p>';
//include $_SERVER['DOCUMENT_ROOT'].'/include/pluso.php';
echo'</div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
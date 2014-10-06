<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$code = htmlspecialchars( $_GET['ELEMENT_CODE'] );
// на всякий
if ( !$code ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
$obCache = new CPHPCache();
$cacheID = 'detail'.md5($code); // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/news/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $arrData = $vars['arrData'];
} else {
  $arrData = array('err'=>false, 'data'=>array());
  CModule::IncludeModule('iblock');
  $res = CIBlockElement::GetList( array(), array('IBLOCK_ID'=>CFG::IBLOCK_NEWS, 'ACTIVE'=>'Y', 'ACTIVE_DATE'=>'Y', '=CODE'=>$code), false, false, array() );
  if ( $arrData['data'] = $res->GetNext() ) {
    // получили
    $arrData['data']['DATE'] = CIBlockFormatProperties::DateFormat('d.m.Y', MakeTimeStamp($arrData['data']["ACTIVE_FROM"], CSite::GetDateFormat()));
    $res = CIBlockElement::GetProperty( $arrData['data']['IBLOCK_ID'], $arrData['data']['ID'], array('sort'=>'asc'), array('CODE'=>'PHOTOS') );
    while ( $ar = $res->GetNext() ) {
      if ( $ar['VALUE'] ) { $arrData['data']['PICTURES'][] = CFile::GetPath($ar['VALUE']); }
    }
  } else { $arrData['err'] = true; }
  $obCache->EndDataCache(array('arrData' => $arrData));
}
if ( $arrData['err'] ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
$APPLICATION->SetTitle($arrData['data']['NAME']);
$APPLICATION->AddChainItem($arrData['data']['NAME']);
?>
<?
echo'<div class="tipicalPage">';
echo'<div class="newsDate"><div class="pinkDate vUglu">'.$arrData['data']['DATE'].'</div></div>'.$arrData['data']['~DETAIL_TEXT'].'<p></p>';
if ( count($arrData['data']['PICTURES']) ) {
  echo'<div class="fotorama" 
      data-height="500"
      data-width="100%"
      data-fit="contain"
      data-thumbheight="100"
      data-thumbwidth="100"
      data-nav="thumbs">';
  foreach ( $arrData['data']['PICTURES'] as $item ) {
    echo'<img src="'.$item.'">';
  }
  echo'</div>';
}
echo'<p><a href="javascript:void(0)" onclick="window.history.back()" class="backLink">К списку новостей</a></p>';
include $_SERVER['DOCUMENT_ROOT'].'/include/pluso.php';
echo'</div>';


// получим комментарии на ID комментируемого элемента (новости)
$ID = $arrData['data']["ID"];
/* если неизвестен ID комментируемого элемента (новости)
$ELEM_IBLOCK_ID = CFG::IBLOCK_NEWS;
$ELEM_CODE = $_REQUEST["ELEMENT_CODE"];
*/
// где хранятся комментарии IBLOCK_ID и SECTION_ID
$IBLOCK_ID = CFG::IBLOCK_COMMENT_NEWS;
$SECTION_ID = 0;
// для кэша
$COMMENT_CODE = 'news';
require $_SERVER['DOCUMENT_ROOT'].'/include/getComments.php';


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О компании");
echo'<div class="tipicalPage">';
$obCache = new CPHPCache();
$cacheID = 'aboutCompany'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
if ( $obCache->InitCache($cacheLifetime, $cacheID) ) {
  $vars = $obCache->GetVars();
  $arrData = $vars['arrData'];
} else {
  $arrData = array();
  CModule::IncludeModule('iblock');
  $res = CIBlockElement::GetByID( CFG::ELEMENT_ABOUT );
  if ( $ar = $res->GetNext() ) {
    $arrData['first'] = '<div class="mainText"><img src="'.CFile::GetPath( $ar['PREVIEW_PICTURE'] ).'" alt="" class="bossPhoto">';
    $arrData['first'] .= $ar['~PREVIEW_TEXT'].'</div>';
    $arrData['first'] .= '<div class="primechanieOpen biger">'.$ar['~DETAIL_TEXT'].'</div>';
  }
  $arrData['why'] = '';
  $res = CIBlockElement::GetList( array('sort'=>'asc'), array('ACTIVE'=>'Y', 'SECTION_ID'=>CFG::SECTION_WHY), false, false, array() );
  $arImg = array('usloviya', 'terminali', 'konkursi', 'akciiBonusi');
  $arLinks = array('/forex-trading/trading-conditions/','/forex-trading/trading-terminals/','/contests/','/promotions-and-bonuses/');
  while ( $ar = $res->GetNext() ) {
    $arrData['why'] .= '<div class="row '.array_shift($arImg).'">
        <i></i>
        <div class="text">
          <div class="title redText"><a href="'.array_shift($arLinks).'">'.$ar['NAME'].'</a></div>
          <p>'.$ar['~PREVIEW_TEXT'].'</p>
        </div>
      </div>';
  }
  if ($arrData['why']) {
    $arrData['why'] = '<span class="boldLabel">Почему мы?</span><div class="whyWe">'.$arrData['why'].'</div>';
  }

  $arrData['history'] = '<span class="boldLabel">История</span><div class="tabs history">';
  $res = CIBlockElement::GetList( array('name'=>'desc'), array('ACTIVE'=>'Y', 'SECTION_ID'=>CFG::SECTION_HISTORY), false, false, array() );
  $tabs = $contentTabs = '';
  while ( $ar = $res->GetNext() ) {
    $tabs .= '<div class="bt">'.$ar['NAME'].'</div>';
    $contentTabs .= '<div class="contentTab">'.$ar['~PREVIEW_TEXT'].'</div>';
  }
  $arrData['history'] .= '<div class="btTabs">'.$tabs.'</div><div class="contentTabs">'.$contentTabs.'</div></div>';
  $obCache->EndDataCache(array('arrData' => $arrData));
}
?>
<?
echo $arrData['first'];
echo $arrData['why'];
echo $arrData['history'];
echo'</div>';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
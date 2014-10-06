<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Торговые условия");
?>
<?

$obCache = new CPHPCache();
$cacheID = 'trading_conditions'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
if ( $obCache->InitCache($cacheLifetime, $cacheID) ) {
  $vars = $obCache->GetVars();
  $html = $vars['html'];
} else {
  $html = '<div class="usloviyaTable">';
  $arSections = array();
  CModule::IncludeModule('iblock');
  $res = CIBlockPropertyEnum::GetList( array('sort'=>'asc'), array('CODE'=>'TARIFF', 'IBLOCK_ID'=>CFG::IBLOCK_TRADING_CONDITIONS) );
  $arTariff = array();
  while ( $ar = $res->GetNext() ) {
    $arTariff[] = array( 'ID'=>$ar['ID'], 'VALUE'=>$ar['VALUE'] );
  }
  $res = CIBlockElement::GetList( array('sort'=>'asc'), array('IBLOCK_ID'=>CFG::IBLOCK_TRADING_CONDITIONS, 'ACTIVE'=>'Y', 'INCLUDE_SUBSECTIONS'=>'Y'), false, false, array('*', 'PROPERTY_TARIFF') );
  $arElem = array();
  while ( $ar = $res->GetNext() ) {
    $arElem[$ar['IBLOCK_SECTION_ID']][str_replace(' ', '_', $ar['PROPERTY_TARIFF_VALUE'])] = array( 'NAME'=>$ar['NAME'], 'PREVIEW_TEXT'=>$ar['PREVIEW_TEXT'], 'TARIFF'=>$ar['PROPERTY_TARIFF_VALUE'] );
  }
  $res = CIBlockSection::GetList( array('sort'=>'asc'), array('IBLOCK_ID'=>CFG::IBLOCK_TRADING_CONDITIONS, 'ACTIVE'=>'Y'), false );
  while ( $arSect = $res->GetNext() ) {
    $arSections[] = array('NAME'=>$arSect['NAME'], 'ID'=>$arSect['ID'] );
  }
  if ( count($arTariff) ) {
    $html .= '<div class="thead"><div class="row">';
    foreach( $arTariff as $tariff){
      $html .= '<div class="cell"><span>'.$tariff['VALUE'].'</span></div>';
    }
    $html .= '</div></div><div class="tbody">';
    foreach( $arSections as $section){
      $html .= '<div class="wrapper">';
      $html .= '<div class="rowTitle"><span>'.$section['NAME'].'</span></div>';
      $html .= '<div class="row">';
      foreach( $arTariff as $tariff ) {
        $key = str_replace(' ', '_', $tariff['VALUE']);
        $html .= '<div class="cell">'.$arElem[$section['ID']][$key]['NAME'];
        if ( $arElem[$section['ID']][$key]['PREVIEW_TEXT'] ) {
          $html .= '<p>'.$arElem[$section['ID']][$key]['PREVIEW_TEXT'].'</p>';
        }
        $html .= '</div>';
      }
      $html .= '</div></div>';
    }
    $html .= '</div></div>';
  }
  $obCache->EndDataCache(array('html' => $html));
}

echo $html;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
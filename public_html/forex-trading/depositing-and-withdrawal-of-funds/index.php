<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Внесение и снятие средств");
?>
<?
$obCache = new CPHPCache();
$cacheID = 'depositing'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/depositing/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $html = $vars['html'];
} else {
  CModule::IncludeModule('iblock');
  $res = CIBlockSection::GetList( array(), array('IBLOCK_ID'=>CFG::IBLOCK_DEPOSITING, 'SECTION_ID'=>0, 'ACTIVE'=>'Y'), false );
  $arData = array();
  $head = '<tr><td colspan="2">Способ пополнения</td><td>Валюта</td><td>Издержки</td><td>Сроки</td><td>Пополнение</td></tr></thead>';
  $html = '<div class="tabs"><div class="btTabs">';
  while ( $ar = $res->GetNext() ) {
    $html .= '<div class="bt">'.$ar['NAME'].'</div>';

    $resSect = CIBlockSection::GetList( array('sort'=>'asc'), array('IBLOCK_ID'=>$ar['IBLOCK_ID'], 'SECTION_ID'=>$ar['ID'], 'ACTIVE'=>'Y'), false );
    $arMethods = array();
    $costs = '';
    $numSnoski = 0;
    while ( $arSect = $resSect->GetNext() ) {
      $resElem = CIBlockElement::GetList( array(), array('IBLOCK_ID'=>$arSect['IBLOCK_ID'], 'SECTION_ID'=>$arSect['ID'], 'ACTIVE'=>'Y'), false, false, array('*', 'PROPERTY_TERMS', 'PROPERTY_CURRENCIES', 'PROPERTY_COSTS') );
      $elems = '';
      if ( !$resElem->SelectedRowsCount() ) { break; }
      while ( $arElem = $resElem->GetNext() ) {
        $cost = false;
        // сноски
        if ( $arElem['PROPERTY_COSTS_VALUE']['TEXT'] ) {
          $r = CIBlockElement::GetProperty( $arElem['IBLOCK_ID'], $arElem['ID'], array('sort'=>'asc'), array('CODE'=>'COSTS') );
          $a = $r->GetNext();
          $cost = true;
          $numSnoski++;
          $costs .= '<p><sup>'.$numSnoski.'</sup>'.$arElem['PROPERTY_COSTS_VALUE']['TEXT'].'</p>';
        }
        $elems .= '<tr><td class="tsPic">';
        if ($arElem['PREVIEW_PICTURE']) { $elems .= '<img src="'.CFile::GetPath($arElem['PREVIEW_PICTURE']).'" alt="'.$arElem['NAME'].'">'; }
        $elems .= '</td><td class="tsTitle">'.$arElem['NAME'].'</td>';
        $elems .= '<td class="tsValutes">'.$arElem['PROPERTY_CURRENCIES_VALUE'].'</td>';
        $elems .= '<td class="tsIzderjki"><span>Комиссия вашего банка</span>';
        if ( $cost ) { $elems .= '<sup>'.$numSnoski.'</sup>'; }
        $elems .= '</td>';
        $elems .= '<td class="tsSrok">'.$arElem['PROPERTY_TERMS_VALUE'].'</td>';
        $elems .= '<td class="tsPop">» <a href="'.$arElem['DETAIL_PAGE_URL'].'">Инструкция</a></td></tr>';
      }
      $arMethods[] = array( 'head'=>'<tr><td colspan="6" class="tGroup">'.$arSect['NAME'].'</td></tr>', 'elems'=>$elems);
    }
    $arData[] = array('methods'=>$arMethods, 'costs'=>$costs);
  }
  $html .= '</div>';
  $html .= '<div class="contentTabs">';
  foreach ( $arData as $arMethods ) {
    $html .= '<div class="contentTab"><table class="popoln"><thead>';
    foreach ( $arMethods['methods'] as $key=>$item ) {
      $html .= $item['head'];
      if (!$key) { $html .= $head; }
      $html .= $item['elems'];
    }
    $html .= '</tbody></table>';
    if ( $arMethods['costs'] ) {
      $html .= '<div class="payPrimech"><span class="label">Примечания:</span>'.$arMethods['costs'].'</div>';
    }
    $html .= '</div>';
  }
  $html .= '</div></div>';
  $obCache->EndDataCache(array('html' => $html));
}
echo $html;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
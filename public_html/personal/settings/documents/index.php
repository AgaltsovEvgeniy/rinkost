<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Документы');
$APPLICATION->AddChainItem('Настройки');
$APPLICATION->AddChainItem('Документы');
?>

<?
echo'<div class="docsPage">';

include $_SERVER['DOCUMENT_ROOT'].'/include/cache_docs.php';
Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('docsUser');
global $USER;
$res = CIBlockElement::GetList( array(), array('IBLOCK_ID'=>CFG::IBLOCK_USERS_DOCS, 'ACTIVE'=>'Y', '=NAME'=>$USER->GetID()), false, false, array() );
$arDocs = array();
if ( $ar = $res->GetNext() ) {
  $res = CIBlockElement::GetProperty( $ar['IBLOCK_ID'], $ar['ID'], array(), array('CODE'=>'DOC') );
  while ( $ar = $res->GetNext() ) {
    if ( $ar['VALUE'] ) {
      $r = CFile::GetByID($ar['VALUE']);
      $info = $r->GetNext();
      $moreInfo = pathinfo($info['FILE_NAME']);
      $arDocs[str_replace(' ', '_', $ar['DESCRIPTION'])] = array( 'desc'=>$ar['DESCRIPTION'], 'url'=>'/upload/'.$info['SUBDIR'].'/'.$info['FILE_NAME'], 'ext'=>$moreInfo['extension'], 'size'=>FUNC::outFileSize($info['FILE_SIZE']) );
    }
  }
}
//new dBug($arDocs);
echo '<table>';
foreach ($arrData as $item) {
  if ( count($arDocs[str_replace(' ', '_', $item['desc'])]) ) {
    $item = $arDocs[str_replace(' ', '_', $item['desc'])];
  }
  echo'<tr><td class="tDocTitle"><span class="docExt">'.$item['desc'].'</span></td>';
  echo'<td class="tDocVes">.'.$item['ext'].' '.$item['size'].'</td>';
  echo'<td class="tDocLink"><a target="blank" href="'.$item['url'].'" class="">Скачать</a></td></tr>';
}
echo'</table>';
Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('docsUser', '');
echo'</div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
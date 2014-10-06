<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$obCache = new CPHPCache();
$cacheID = 'documents'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
if ( $obCache->InitCache($cacheLifetime, $cacheID) ) {
  $vars = $obCache->GetVars();
  $arrData = $vars['arrData'];
} else {
  $arrData = array();
  CModule::IncludeModule('iblock');
  $res = CIBlockElement::GetList( array('sort'=>'asc'), array('IBLOCK_ID'=>CFG::IBLOCK_DOCS, 'ACTIVE'=>'Y', 'INCLUDE_SUBSECTIONS'=>'Y'), false, false, array('ID','IBLOCK_ID') );
  while ( $ar = $res->GetNext() ) {
    $rProp = CIBlockElement::GetProperty( $ar['IBLOCK_ID'], $ar['ID'], array('sort'=>'asc'), array('CODE'=>'DOC') );
    while ( $arProp = $rProp->GetNext() ) {
      if ( $arProp['VALUE'] ) {
        $r = CFile::GetByID($arProp['VALUE']);
        $info = $r->GetNext();
        $moreInfo = pathinfo($info['FILE_NAME']);
        $arrData[] = array( 'desc'=>$arProp['DESCRIPTION'], 'ext'=>$moreInfo['extension'], 'size'=>FUNC::outFileSize($info['FILE_SIZE']), 'url'=>'/upload/'.$info['SUBDIR'].'/'.$info['FILE_NAME'] );
      }// ORIGINAL_NAME
    }
  }
  $obCache->EndDataCache(array('arrData' => $arrData));
}
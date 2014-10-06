<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$obCache = new CPHPCache();
$cacheID = 'country'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
if ( $obCache->InitCache($cacheLifetime, $cacheID) ) {
  $vars = $obCache->GetVars();
  $arCountry = $vars['arCountry'];
  $arRegions = $vars['arRegions'];
} else {
  //CSaleLocation::DeleteAll();
  // GetCountryArray()
  CModule::IncludeModule('sale');
  $arSort = array("COUNTRY_NAME_LANG"=>"ASC", "REGION_NAME_LANG"=>"ASC", "CITY_NAME_LANG"=>"ASC", "SORT"=>"ASC", );
  $resC = CSaleLocation::GetList( $arSort, array("LID" => LANGUAGE_ID, 'REGION_NAME'=>false, 'CITY_NAME'=>false ), false, false, array());
  $arCountry = $arRegions = array();
  //$arC = CCountry::GetList(); 
  while ( $arC = $resC->GetNext() ) {
    //new dbug($arC);
    $arCountry[] = array( 'ID'=>$arC['COUNTRY_ID'], 'NAME'=>$arC['COUNTRY_NAME']);
    $resR = CSaleLocation::GetList( $arSort, array("LID" => LANGUAGE_ID, 'COUNTRY_ID'=>$arC['COUNTRY_ID'], '!REGION_NAME'=>false, 'CITY_NAME'=>false ), false, false, array());
    while ( $arR = $resR->GetNext() ) {
      //new dBug($arR);
      $arRegions[$arC['COUNTRY_ID']][] = array( 'ID'=>$arR['REGION_ID'], 'NAME'=>$arR['REGION_NAME']);
    }
  }
  $obCache->EndDataCache(array('arCountry' => $arCountry, 'arRegions' => $arRegions));
}
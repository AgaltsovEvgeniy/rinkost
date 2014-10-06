<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сертификаты и лицензии");

$obCache = new CPHPCache();
$cacheID = 'certificateList'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/certificate/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $data = $vars['data'];
} else {
  CModule::IncludeModule('iblock');
  $data = array();
  $res = CIBlockElement::GetList( array('sort'=>'asc','ID'=>'asc'), array( 'IBLOCK_ID'=>CFG::IBLOCK_CERTIFICATES, 'ACTIVE'=>'Y',  'INCLUDE_SUBSECTIONS'=>'Y' ), false, false, array() );
  while ( $ar = $res->GetNext() ) {
    $arDetailPicture = CFile::GetFileArray($ar["DETAIL_PICTURE"]);
    $data['items'][] = array(
      'preview_img'=>CFile::GetPath($ar["PREVIEW_PICTURE"]),
      'detail_img'=>$arDetailPicture['SRC'],
      'detail_img_alt'=>$arDetailPicture['DESCRIPTION'],
      'name'=>$ar["NAME"],
    );
  }
  $obCache->EndDataCache(array('data' => $data));
}
//new dBug($data);
?>
<div class="srtificatesRows">
  <?foreach($data['items'] as $value):?>
  <a class="row colorbox" href="<?=$value['detail_img']?>">
    <div class="img"><img alt="<?=$value['detail_img_alt']?>" src="<?=$value['preview_img']?>"></div>
    <span><?=$value['name']?></span>
  </a>
  <?endforeach;?>
  <?if(count($data['items'])%3==2):?>
  <div class="row" style="height:0;"></div>
  <?endif;?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
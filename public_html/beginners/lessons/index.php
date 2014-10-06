<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Уроки");

//навигация
$obCache = new CPHPCache();
$cacheID = 'beginnersLessonsNav'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/beginners-lessons/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $nav = $vars['data'];
} else {
  CModule::IncludeModule('iblock');
  $nav = array();
  $res = CIBlockElement::GetList( array('sort'=>'asc','ID'=>'asc'), array( 'IBLOCK_ID'=>CFG::IBLOCK_LESSONS, 'ACTIVE'=>'Y',  'INCLUDE_SUBSECTIONS'=>'Y' ), false, false, array() );
  while ( $ar = $res->GetNext() ) {
    if($ar['DETAIL_PAGE_URL']=='/beginners/lessons/how-to-install-the-program/'){
      $ar['DETAIL_PAGE_URL'] = '/beginners/lessons/';
    }
    $nav[] = array(
      'id'=>$ar['ID'],
      'name'=>$ar['NAME'],
      'url'=>$ar['DETAIL_PAGE_URL']
    );
  }
  $obCache->EndDataCache(array('data' => $nav));
}
//new dBug($nav);
//детальное описание
$code = htmlspecialchars( $_GET['ELEMENT_CODE'] );
// на всякий
if ( !$code ) { $code = 'how-to-install-the-program'; }
$obCache = new CPHPCache();
$cacheID = 'detail'.md5($code); // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/beginners-lessons/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $arrData = $vars['arrData'];
} else {
  $arrData = array('err'=>false, 'data'=>array());
  CModule::IncludeModule('iblock');
  $res = CIBlockElement::GetList( array(), array('IBLOCK_ID'=>CFG::IBLOCK_LESSONS, 'ACTIVE'=>'Y', 'ACTIVE_DATE'=>'Y', '=CODE'=>$code), false, false, array() );
  if ( $arrData['data'] = $res->GetNext() ) {
    
  } else { $arrData['err'] = true; }
  $obCache->EndDataCache(array('arrData' => $arrData));
}
if ( $arrData['err'] ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
$APPLICATION->SetTitle('Уроки. '.$arrData['data']['NAME']);
$APPLICATION->AddChainItem($arrData['data']['NAME']);

$URL = str_replace('?'.$_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
$URL = htmlspecialchars($URL);
?>
<div class="content2columns">
  <div class="leftColumn">
    <ol>
      <?foreach($nav as $value):?>
      <?
        $active = '';
        if($value['url']==$URL){
          $active = ' class="active"';
        }
      ?>
      <li<?=$active?>><a href="<?=$value['url']?>"><?=$value['name']?></a></li>
      <?endforeach;?>
    </ol>
  </div>
  <div class="rightColumn">
    <?=$arrData['data']['~DETAIL_TEXT']?>
  </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
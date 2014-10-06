<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Лекции");


//навигация
$obCache = new CPHPCache();
$cacheID = 'beginnersLecturesNav'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/beginners_lectures/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $nav = $vars['data'];
  $default_code = $vars['default_code'];
} else {
  CModule::IncludeModule('iblock');
  $nav = array();
  $default_code = false;
  $res = CIBlockSection::GetList(array("left_margin"=>"asc"),array('IBLOCK_ID'=>CFG::IBLOCK_LECTURES, 'ACTIVE'=>'Y', 'GLOBAL_ACTIVE'=>'Y'),false,false);
  while($ar = $res->GetNext()){
    if($default_code === false && $ar['DESCRIPTION']){
      $default_code = $ar['CODE'];
      $ar['SECTION_PAGE_URL'] = $ar['LIST_PAGE_URL'];
    }
    $nav[] = array(
      'name'=>$ar['NAME'],
      'level'=>$ar['DEPTH_LEVEL'],
      'url'=>$ar['SECTION_PAGE_URL'],
      'link'=>($ar['DESCRIPTION'] ? true : false),
      'type'=>'section'
    );
    
    $res2 = CIBlockElement::GetList(array('sort'=>'asc'),array('IBLOCK_ID'=>CFG::IBLOCK_LECTURES, 'ACTIVE'=>'Y', 'SECTION_ID'=>$ar['ID']),false,false,array());
    while($ar2 = $res2->GetNext()){
      if($default_code === false){
        $default_code = $ar2['CODE'];
        $ar2['DETAIL_PAGE_URL'] = $ar2['LIST_PAGE_URL'];
      }
      $nav[] = array(
        'name'=>$ar2['NAME'],
        'level'=>($ar['DEPTH_LEVEL']+1),
        'url'=>$ar2['DETAIL_PAGE_URL'],
        'link'=>true,
        'type'=>'element'
      );
    }
  }
  $obCache->EndDataCache(array('data' => $nav, 'default_code'=>$default_code));
}

$URL = str_replace('?'.$_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
$URL = htmlspecialchars($URL);

//детальное описание
$code = htmlspecialchars( $_GET['ELEMENT_CODE'] );
if ( !$code ) {
  //код по умолчанию
  $code = $default_code;
}
$obCache = new CPHPCache();
$cacheID = 'detail'.md5($code); // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/beginners_lectures/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $arrData = $vars['arrData'];
} else {
  $arrData = array('err'=>false, 'data'=>array());
  //это элемент?
  $res = CIBlockElement::GetList( array(), array('IBLOCK_ID'=>CFG::IBLOCK_LECTURES, 'ACTIVE'=>'Y', '=CODE'=>$code), false, false, array() );
  if( $ar = $res->GetNext() ) {
    $arrData['data'] = array(
      'NAME'=>$ar['NAME'],
      'CONTENT'=>$ar['~DETAIL_TEXT']
    );
  }else{
    //это раздел?
    $res = CIBlockSection::GetList(array(),array('IBLOCK_ID'=>CFG::IBLOCK_LECTURES, 'ACTIVE'=>'Y', 'GLOBAL_ACTIVE'=>'Y', '=CODE'=>$code));
    if($ar = $res->GetNext()){
      $arrData['data'] = array(
        'NAME'=>$ar['NAME'],
        'CONTENT'=>$ar['DESCRIPTION']
      );
    }else{
      $arrData['err'] = true;
    }
  }
  $obCache->EndDataCache(array('arrData' => $arrData));
}
if ( $arrData['err'] ) { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
$APPLICATION->SetTitle('Лекции. '.$arrData['data']['NAME']);
$APPLICATION->AddChainItem($arrData['data']['NAME']);
?>
<div class="content2columns">
  <div class="leftColumn lecturesMenu">
    <?foreach($nav as $value):?>
      <?
        $active = '';
        if($value['url']==$URL){
          $active = ' active';
        }
      ?>
      <?if($value['link']):?>
        <a class="<?=$value['type'].$active?> level<?=$value['level']?>" href="<?=$value['url']?>"><?=($value['type']=='element')?'-&nbsp;':''?><?=$value['name']?></a>
      <?else:?>
        <span class="<?=$value['type'].$active?> level<?=$value['level']?>"><?=$value['name']?></span>
      <?endif;?>
    <?endforeach;?>
  </div>
  <div class="rightColumn">
    <?=$arrData['data']['CONTENT']?>
  </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
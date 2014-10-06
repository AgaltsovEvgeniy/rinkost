<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Словарь терминов");

$sectionIds[0] = array('lang'=>'ru','id'=>17);
$sectionIds[1] = array('lang'=>'en','id'=>18);

$obCache = new CPHPCache();
$cacheID = 'glossary'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/glossary/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $data = $vars['data'];
} else {
  CModule::IncludeModule('iblock');
  $data = array();
  $res = CIBlockElement::GetList( array('sort'=>'asc','ID'=>'asc'), array( 'IBLOCK_ID'=>CFG::IBLOCK_GLOSSARY, 'ACTIVE'=>'Y',  'INCLUDE_SUBSECTIONS'=>'Y' ), false, false, array() );
  while ( $ar = $res->GetNext() ) {
    if($ar['ID']==51){
      //en A
      $ar['DETAIL_PAGE_URL'] = str_replace('en/a/','',$ar['DETAIL_PAGE_URL']);
    }
    $data['items'][$ar['ID']] = array(
      'url'=>$ar['DETAIL_PAGE_URL'],
      'name'=>$ar["NAME"],
      'detail_text'=>$ar['~DETAIL_TEXT']
    );
    $data['letters'][$ar['IBLOCK_SECTION_ID']][] = array(
      'url'=>$ar['DETAIL_PAGE_URL'],
      'name'=>$ar["NAME"]
    );
    $data['url'][$ar['DETAIL_PAGE_URL']] = $ar['ID'];
    /* $data['items'][] = $ar; */
  }
  $obCache->EndDataCache(array('data' => $data));
}
//по умолчанию en A
$content = $data['items'][51]['detail_text'];

$URL = str_replace('?'.$_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
$URL = htmlspecialchars($URL);
if($_SERVER['SCRIPT_NAME']=='/bitrix/urlrewrite.php'){
  if(isset($data['url'][$URL])){
    $content = $data['items'][$data['url'][$URL]]['detail_text'];
  }else{
    //404
    include $_SERVER['DOCUMENT_ROOT'].'/404.php';
  }
}
?>
<div class="letters">
  <?foreach($sectionIds as $sId):?>
    <p>
    <?foreach($data['letters'][$sId['id']] as $value):?>
      <? 
        $active = '';
        if($value['url']==$URL){
          $active = ' class="active"';
        }
      ?>
      <a href="<?=$value['url']?>"<?=$active?>><?=$value['name']?></a>
    <?endforeach;?>
    </p>
  <?endforeach;?>
</div>
<div class="glossaryContent">
  <?=$content?>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
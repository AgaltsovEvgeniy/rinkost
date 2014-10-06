<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вопрос-ответ");
?>
<div class="tipicalPage">
<?
$obCache = new CPHPCache();
$cacheID = 'faq'; // используем некое уникальное имя для кэша
$cacheLifetime = 3600*24; // сутки
$cachePath = '/faq/'; // папка
if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
  $vars = $obCache->GetVars();
  $category = $vars['category'];
  $html = $vars['html'];
} else {
  CModule::IncludeModule('iblock');
  $category = array();
  $html = '';
  //category array
  $res = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>CFG::IBLOCK_FAQ, "=CODE"=>"CATEGORY"));
  while($ar = $res->GetNext()){
    $category[] = array(
      'ID'=>$ar['ID'],
      'NAME'=>$ar['VALUE']
    );
  }
  //elements
  $res = CIBlockElement::GetList(array('sort'=>'asc','id'=>'asc'),array('IBLOCK_ID'=>CFG::IBLOCK_FAQ, 'ACTIVE'=>'Y'),false,false,array('*','PROPERTY_CATEGORY'));
  while($ar = $res->GetNext()){
    $elems[$ar['PROPERTY_CATEGORY_ENUM_ID']][] = array(
      'question'=>$ar['~PREVIEW_TEXT'],
      'answer'=>$ar['~DETAIL_TEXT'],
    );
  }
  //html
  $tabs = $contentTabs = '';
  $html .= '<div class="tabs">';
  foreach($category as $value){
    $tabs .= '<div class="bt">'.$value['NAME'].'</div>';
    $contentTabs .= '<div class="contentTab">';
    if(isset($elems[$value['ID']]) && is_array($elems[$value['ID']])){
      $contentTabs .= '<div class="faqRows">';
      foreach($elems[$value['ID']] as $elem){
        $contentTabs .= '<div class="row accParent">
                          <div class="question">'.$elem['question'].'</div>
                          <div class="accDropdown answer">
                            <p class="pageText">'.$elem['answer'].'</p>
                          </div>
                        </div>';
      }
      $contentTabs .= '</div>';
    }
    $contentTabs .= '</div>';
  }
  $html .= '<div class="btTabs">'.$tabs.'</div><div class="contentTabs">'.$contentTabs.'</div>';
  $html .= '</div>';
  
  $obCache->EndDataCache(array('category' => $category, 'html'=>$html));
}
//new dBug($elems);
?>
<a class="button white gray vUglu faq" onclick="openSendQuestion()">Задать вопрос</a>
<p class="pageText">Соглашение между одним из крупнейших брокеров России и первым российским автодромом международного уровня было подписано в конце апреля. И Moscow Raceway, как промоутер российского этапа чемпионата, рад такому сотрудничеству.</p>

<?=$html?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
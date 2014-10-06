<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/*
$ELEM_IBLOCK_ID - если у текущего элемента известен только символьный код
$ELEM_CODE - если у текущего элемента известен только символьный код
$ID - если у текущего элемента известен ID
$IBLOCK_ID - инфоблок, где хранятся комментарии
$SECTION_ID - раздел, где хранятся комментарии
$COMMENT_CODE - к какому разделу относится комментарий
*/

// получим комментарии
$uniq_code = md5($ELEM_IBLOCK_ID.'_'.$ELEM_CODE.'_'.$ID.'_'.$IBLOCK_ID.'_'.$COMMENT_CODE);
Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('comments_'.$uniq_code);
CModule::IncludeModule('iblock');
global $USER;
if ( $ELEM_IBLOCK_ID && $ELEM_CODE ) {
  $res = CIBlockElement::GetList(array('id'=>'asc'), array('IBLOCK_ID'=>$ELEM_IBLOCK_ID, 'ACTIVE'=>'Y', 'CODE'=>$ELEM_CODE), false, false, array('ID'));
  $arElem = $res->GetNext();
  $ID = $arElem['ID'];
}
if ( $ID ) {
  $res = CIBlockElement::GetList(array('id'=>'asc'), array('IBLOCK_ID'=>$IBLOCK_ID, 'ACTIVE'=>'Y', 'PROPERTY_ELEMENT'=>$ID), false, array('iNumPage'=>1, 'nPageSize'=>5), array('PREVIEW_TEXT', 'PROPERTY_USER_ID', 'DATE_CREATE'));
  $countComments = $res->SelectedRowsCount();
  ?>
  <div class="primechanieOpen commentsList" ng-controller="ctrlComment">
    <p><b class="bold">Комментарии (<?=$res->SelectedRowsCount()?>):</b></p>
    <?
    if ( $USER->isAuthorized() ) {
      $name = $USER->GetLastName().' '.$USER->GetFirstName();
    ?>
    <form name="formComment" ng-submit="submit()" ng-init="user.section='<?=$COMMENT_CODE;?>';user.name='<?=$name?>';user.id=<?=(int)$ID?>">
      <textarea ng-model="user.text" required placeholder="Ваш комментарий" cols="30" rows="10"></textarea>
      <input type="submit" class="button pink" value="Опубликовать">
    </form>
    <?}?>
    
    <?
    $arComments = array();
    while ( $arComment = $res->GetNext() ) {
      $resUser = $USER->GetByID( $arComment["PROPERTY_USER_ID_VALUE"] );
      $arUs = $resUser->GetNext();
      $arComments[] = array(
        'user'=>$arUs['LAST_NAME'].' '.$arUs['NAME'],
        'date'=>CIBlockFormatProperties::DateFormat('d.m.Y в H:i', MakeTimeStamp($arComment["DATE_CREATE"], CSite::GetDateFormat())),
        'text'=>$arComment['PREVIEW_TEXT'],
      );
    }
    ?>
    <script>
      var commentsEvent = <?=json_encode($arComments)?>;
    </script>
    <div class="rows">
      <div class="row" ng-repeat="item in commentsEvent">
        <p class="submitted"><span class="name">{{item.user}}</span> написал(а) {{item.date}}</p>
        <p>{{item.text}}</p>
      </div>
    </div>
    <?if( $countComments > 5 ):?><div ng-show="btShow" class="showNext" ng-click="next()">Показать еще 5</div><?endif;?>
  </div>
  <?
}
Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('comments', '<div class="primechanieOpen commentsList"><p><b class="bold">Загрузка комментариев</b></p></div>');
?>
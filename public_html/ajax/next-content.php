<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$req = json_decode( file_get_contents('php://input'), true);
$req = array_map( 'htmlspecialchars', $req );
$req = array_map( 'trim', $req );
$offset = (int)$req['offset'];
if ( $offset ) {
  CModule::IncludeModule('iblock');
  global $USER;
  switch ($req['type']) {
    case'news':
      $news = FUNC::getNextNews( $offset );
      $res = array( 'res'=>true, 'data'=>$news );
    break;
    case'promotions':
      $news = FUNC::getNextPromotions( $offset );
      $res = array( 'res'=>true, 'data'=>$news );
    break;
    case'reviews':
      $reviews = FUNC::getNextReviews( $offset );
      $res = array( 'res'=>true, 'data'=>$reviews );
    break;
    case'comments':
      $comments = array('items'=>array(), 'more'=>false);
      $res = CIBlockElement::GetList(array('id'=>'asc'), array('IBLOCK_ID'=>CFG::IBLOCK_COMMENT_NEWS, 'ACTIVE'=>'Y', 'PROPERTY_ELEMENT'=>$ID), false, array('iNumPage'=>$offset, 'nPageSize'=>5), array('PREVIEW_TEXT', 'PROPERTY_USER_ID', 'DATE_CREATE'));
      if ( $res->SelectedRowsCount() > $offset*5 ) { $comments['more'] = true; }
      $arComments = array();
      while ( $arComment = $res->GetNext() ) {
        $resUser = $USER->GetByID( $arComment["PROPERTY_USER_ID_VALUE"] );
        $arUs = $resUser->GetNext();
        $comments['items'][] = array(
          'user'=>$arUs['LAST_NAME'].' '.$arUs['NAME'],
          'date'=>CIBlockFormatProperties::DateFormat('d.m.Y в H:i', MakeTimeStamp($arComment["DATE_CREATE"], CSite::GetDateFormat())),
          'text'=>$arComment['PREVIEW_TEXT'],
        );
      }
      $res = array( 'res'=>true, 'data'=>$comments );
    break;
    default:
      $res = array( 'res'=>false, 'msg'=>'Чё?' );
    break;
  }
} else { $res = array( 'res'=>false, 'msg'=>'Чё?' ); }
echo json_encode($res);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
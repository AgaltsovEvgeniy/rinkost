<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
if ( !$USER->isAuthorized() ) {
  require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
  die;
}
$req = json_decode( file_get_contents('php://input'), true );
CModule::IncludeModule('iblock');
switch ( $req['section'] ) {
  case'news':
    $IBLOCK_TYPE = 'news';
    $IBLOCK_ID = CFG::IBLOCK_COMMENT_NEWS;
    $SECTION_ID = 0;
    $subj = 'новость';
  break;
}
if ( $req['text'] && (int)$req['id'] && $req['section'] && $req['name'] ) {
  $arFields = array(
    'IBLOCK_ID'=>$IBLOCK_ID,
    'IBLOCK_SECTION_ID'=>$SECTION_ID,
    'NAME'=>htmlspecialchars($req['name']),
    'ACTIVE'=>'Y',
    'PREVIEW_TEXT'=>nl2br(htmlspecialchars($req['text'])),
    'PREVIEW_TEXT_TYPE'=>'text',
    'CODE'=>time().'-'.$USER->GetID().'-'.$SECTION_ID,
    'PROPERTY_VALUES'=>array(
      'USER_ID'=>$USER->GetID(),
      'ELEMENT'=>(int)$req['id'],
    ),
  );
  $el = new CIBlockElement;
  $id = $el->Add($arFields);
  if ( $id ) {
    $res = CIBlockElement::GetByID((int)$req['id']);
    $ar = $res->GetNext();
    // отправим письмо
    $body = $arFields['NAME']." (USER_ID: ".$arFields['PROPERTY_VALUES']['USER_ID'];
    $body .= ") оставил комментарий в '".$ar['NAME']."':\n".$arFields['PREVIEW_TEXT'];
    $body .= "\n\nСсылка для редактирования: http://".$_SERVER['SERVER_NAME']."/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=".$IBLOCK_ID."&type='.$IBLOCK_TYPE.'&ID=".$id;
    $arFieldsEmail = array(
      'SUBJ'=>'Комментарий на '.$subj.' '.$ar['NAME'],
      'EMAIL_TO'=>$USER->GetEmail(),
      'TEXT'=>$body,
    );
    CEvent::Send('FEEDBACK_FORM', SITE_ID, $arFieldsEmail, 'Y', 68); // 68 универсальный шаблон
    $res = array( 'res'=>true, 'comment'=>array(
      'user'=>$arFields['NAME'],
      'date'=>CIBlockFormatProperties::DateFormat('d.m.Y в H:i', time()),
      'text'=>$arFields['PREVIEW_TEXT'],
    ) );
  } else {
    $res = array( 'res'=>false, 'msg'=>'Ошибка добавления комментария. Попробуйте повторить попытку позже.' );
  }
} else { $res = array( 'res'=>false, 'msg'=>'Заполните все поля.' ); }
echo json_encode($res);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
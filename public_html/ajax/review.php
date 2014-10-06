<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$req = json_decode( file_get_contents('php://input'), true );
//$req = array_map( 'htmlspecialchars', $req );
//$req = array_map( 'trim', $req );

CModule::IncludeModule('iblock');

if ( $req['text'] && $req['name'] && $req['email'] ) {
  if ( filter_var($req['email'], FILTER_VALIDATE_EMAIL) ) {
    $arFields = array(
      'IBLOCK_ID'=>16,
      'ACTIVE'=>'N',
      'NAME'=>ucfirst($req['name']),
      'PREVIEW_TEXT'=>$req['text'],
      'PREVIEW_TEXT_TYPE'=>'text',
    );
    $arProps[16] = $req['email']; //E-mail
    $arProps[17] = date('d.m.Y H:i:s'); //Date
    $arFields['PROPERTY_VALUES'] = $arProps;
    $element = new CIBlockElement;
    $resElementId = $element->Add($arFields);
    
    if($resElementId){
      $res = array('res'=>true);
    }else{
      $res = array( 'res'=>false, 'msg'=>'Ошибка добавления записи. Попробуйте повторить попытку позже.' );
    }
    
  } else { $res = array( 'res'=>false, 'msg'=>'Неправильно задан email.' ); }
} else { $res = array( 'res'=>false, 'msg'=>'Заполните все поля.' ); }
echo json_encode($res);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
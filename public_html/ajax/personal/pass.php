<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
if ( !$USER->isAuthorized() ) {
  require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
  die;
}
$req = json_decode( file_get_contents('php://input'), true );
if ( $req['pass'] && $req['confirm_pass'] && $req['current_pass'] ) {
  if ( strlen($req['pass']) < 6 ) { $res = array( 'res'=>false, 'msg'=>'Пароль должен быть не менее 6 символов.' ); }
  elseif ( $req['pass'] != $req['confirm_pass'] ) { $res = array( 'res'=>false, 'msg'=>'Пароль и подтверждение пароля не совпадает.' ); }
  else {
    global $USER;
    // проверим текущий пароль
    $arAuthResult = $USER->Login( $USER->GetLogin(), $req['current_pass'] );
    if ( $arAuthResult === true ) {
      $USER->ChangePassword($USER->GetLogin(), randString(10), $req['pass'], $req['pass']);
      $res = array( 'res'=>true, 'msg'=>'Чтобы задействовать новый пароль - переавторизуйтесь.' );
    } else { $res = array( 'res'=>false, 'msg'=>'Ошибка ввода текущего пароля.' ); }
  }
} else { $res = array( 'res'=>false, 'msg'=>'Заполните все поля.' ); }

echo json_encode($res);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
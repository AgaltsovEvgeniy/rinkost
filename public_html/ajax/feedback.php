<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$req = json_decode( file_get_contents('php://input'), true);
$req = array_map( 'htmlspecialchars', $req );
$req = array_map( 'trim', $req );
if ( $req['name'] && $req['email'] && $req['otdel'] && $req['text'] && $req['phone'] ) {
  if ( check_email($req['email']) ) {
    $eot = "\n";
    $arFieldsEmail = array(
      'SUBJ'=>'Обратная связь: '.$req['otdel'],
      'EMAIL_TO'=>$req['email'],
      'TEXT'=>'Имя:'.$req['name'].$eot.'Телефон: '.$req['phone'].$eot.'Email: '.$req['email'].$eot.'Вопрос: '.$req['text'],
    );
    CEvent::Send('FEEDBACK_FORM', SITE_ID, $arFieldsEmail, 'Y', 68); // 68 универсальный шаблон
    $res = array( 'res'=>true, 'msg'=>'Ok' );
  } else { $res = array( 'res'=>false, 'msg'=>'Неправильно задан email.' ); }
} else { $res = array( 'res'=>false, 'msg'=>'Заполните все поля.' ); }
echo json_encode($res);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
if ( !$USER->isAuthorized() ) {
  require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
  die;
}
$req = json_decode( file_get_contents('php://input'), true );

$arRequired = array( 'last_name', 'name', 'second_name', 'phone', 'email', 'country_id', 'city', 'zip', 'addr', );
$err = false;
foreach ( $arRequired as $item ) {
  if ( !$req[$item] ) { $err = true; break; }
}
if ( $err ) { $res = array( 'res'=>false, 'msg'=>'Заполните все поля.' ); }
else {
  $err = '';
  if ( !check_email($req['email']) ) {
    $err = 'Неправильно задан email. ';
  }
  if ( !preg_match('/\/upload\//', $req['img']) && $req['img'] ) {
    $ar = array('gif', 'jpg', 'jpeg', 'png');
    $ext = preg_replace( '/^.+?image\/(.+?);.*?base64,.+/', '$1',$req['img'] );
    if ( in_array($ext, $ar) ) {
      $img = base64_decode( preg_replace('/^.+?base64,(.+)/', '$1',$req['img']) );
      $name = time().$USER->GetID();
      $filename = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$name.'.'.$ext;
      $fh = fopen( $_SERVER['DOCUMENT_ROOT'].'/upload/'.$name.'_.'.$ext, 'wb+' );
      fwrite($fh, $img);
      fclose($fh);
      CFile::ResizeImageFile(
        $sourceFile = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$name.'_.'.$ext,
        $destinationFile =  $filename,
        $arSize = array('width'=>150, 'height'=>150),
        $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL,
        $arWaterMark = array(),
        $jpgQuality=false,
        $arFilters = array()
      );
      @unlink($_SERVER['DOCUMENT_ROOT'].'/upload/'.$name.'_.'.$ext);
    } else {
      $err .= 'Изображение должно быть gif, jpg или png. ';
    }
  }
  // проверка на существующий email
  $r = $USER->GetByLogin($req['email']);
  if ( $arTmp = $r->GetNext()) {
    if ( $arTmp['ID'] != $USER->GetID() ) { $err .= 'Пользователь с данным email уже зарегистрирован. '; }
  }
  if ( $err ) {
    $res = array( 'res'=>false, 'msg'=>$err );
  } else {
    
    $arFields = array(
      'NAME'=>$req['name'],
      'LAST_NAME'=>htmlspecialchars($req['last_name']),
      'SECOND_NAME'=>htmlspecialchars($req['second_name']),
      'PERSONAL_ZIP'=>htmlspecialchars($req['zip']),
      'PERSONAL_CITY'=>htmlspecialchars($req['city']),
      'PERSONAL_STREET'=>htmlspecialchars($req['addr']),
      'PERSONAL_STATE'=>htmlspecialchars($req['region_name']),
      'EMAIL'=>htmlspecialchars($req['email']),
      'LOGIN'=>htmlspecialchars($req['email']),
      'PERSONAL_MOBILE'=>htmlspecialchars($req['phone']),
    );
    // страны для пользователей хранятся не в местоположениях -------------------------
    include $_SERVER['DOCUMENT_ROOT'].'/include/cache_country.php';
    $countryName = '';
    foreach ($arCountry as $value) {
      if ( $value['ID'] == (int)$req['country_id'] ) { $countryName = $value['NAME']; }
    }
    if ( $countryName ) {
      $arUserCountry = GetCountryArray();
      $key = array_search( $countryName, $arUserCountry['reference'] );
      if ( $key !== false ) {
        $arFields['PERSONAL_COUNTRY'] = $arUserCountry['reference_id'][$key];
      }
    }
    // --------------------------------------------------------------------------------
    $USER->Update( $USER->GetID(), $arFields );
    if ( $filename ) {
      $USER->Update( $USER->GetID(), array('PERSONAL_PHOTO'=>CFile::MakeFileArray($filename)) );
      @unlink($filename);
    }
    $res = array('res'=>true, 'msg'=>'Ok');
  }
}
echo json_encode($res);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
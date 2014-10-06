<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Мои данные');
$APPLICATION->AddChainItem('Настройки');
$APPLICATION->AddChainItem('Мои данные');
global $arCurrentUser;
//new dBug($arCurrentUser);
?>
<div class="stripedTitle"><span>Основное</span></div>
<form ng-controller="ctrlProfile" ng-submit="submit()" name="formProfile" class="w400">

  <div class="fileform">
    <div class="selectbutton btn gray">
      <div class="inner">
        <?$img = '/i/headShot.jpg';
        if ( $arCurrentUser['PERSONAL_PHOTO'] ) {
          $img = CFile::GetPath($arCurrentUser['PERSONAL_PHOTO']);
        }
        ?>
        <img id="personalPhoto" src="<?=$img?>" alt="photo">
      </div>
    </div>
    <div id="fileformlabel" class="redText">Загрузить фотографию</div>
    <input id="upload" type="file" name="upload">
  </div>

  <div class="formRow">
    <label for="lSum" class="label">Фамилия</label>
    <input id="lSum" type="text" class="textInput" required ng-model="user.last_name" ng-init="user.last_name='<?=$arCurrentUser['LAST_NAME']?>'">
  </div>
  <div class="formRow">
    <label for="lSum" class="label">Имя</label>
    <input id="lSum" type="text" class="textInput" required ng-model="user.name" ng-init="user.name='<?=$arCurrentUser['NAME']?>'">
  </div>
  <div class="formRow">
    <label for="lSum" class="label">Отчество</label>
    <input id="lSum" type="text" class="textInput" required ng-model="user.second_name" ng-init="user.second_name='<?=$arCurrentUser['SECOND_NAME']?>'">
  </div>

  <br>

  <div class="stripedTitle"><span>Контактные данные</span></div>
  <div class="formRow">
    <label for="lSum" class="label">Телефон</label>
    <input id="lSum" type="text" class="textInput" ui-mask="+7 (999) 999-99-99" required ng-model="user.phone" ng-init="user.phone='<?=$arCurrentUser['PERSONAL_MOBILE']?>'">
  </div>
  <div class="formRow">
    <label for="lSum" class="label">E-mail</label>
    <input id="lSum" type="text" class="textInput" required ng-model="user.email" ng-init="user.email='<?=$arCurrentUser['EMAIL']?>'" ng-pattern='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'>
  </div>

  <br>

  <div class="stripedTitle"><span>Контактные данные</span></div>

  <?
  include $_SERVER['DOCUMENT_ROOT'].'/include/cache_country.php';
  if (!$country_id) { $country_id = 126; } // Россия
  ?>
  <div class="formRow">
    <label for="lSum" class="label">Страна</label>
    <select id="selectCountry" name="selectCountry">
      <?foreach( $arCountry as $country ):?>
        <option value="<?=$country['ID']?>" <?if($country_id == $country['ID']):?>selected="selected"<?endif;?>><?=$country['NAME']?></option>
      <?endforeach;?>
    </select>
  </div>
  <?if ( count($arRegions[$country_id]) ):?>
  <div class="formRow" id="selectRegion">
    <label for="lSum" class="label">Регион</label>
    <select name="region" id="regionName">
      <?
      foreach( $arRegions[$country_id] as $region ):?>
        <option value="<?=$region['NAME']?>" <?if( $arCurrentUser['PERSONAL_STATE'] == $region['NAME']):?>selected="selected"<?endif;?>><?=$region['NAME']?></option>
      <?endforeach;?>
    </select>
  </div>
  <?endif;?>

  <div class="formRow">
    <label for="lSum" class="label">Город</label>
    <input id="lSum" type="text" class="textInput" required ng-model="user.city" ng-init="user.city='<?=$arCurrentUser['PERSONAL_CITY']?>'">
  </div>
  <div class="formRow">
    <label for="lSum" class="label">Адрес</label>
    <input id="lSum" type="text" class="textInput" required ng-model="user.addr" ng-init="user.addr='<?=$arCurrentUser['PERSONAL_STREET']?>'">
  </div>
  <div class="formRow">
    <label for="lSum" class="label">Индекс</label>
    <input id="lSum" type="text" class="textInput" required ng-model="user.zip" ng-init="user.zip='<?=$arCurrentUser['PERSONAL_ZIP']?>'">
  </div>

  <br>

  <div class="stripedTitle"><span>Реквизиты</span></div>
  <div class="formRow payType yandexMo">
    <label for="lSum" class="label">Яндекс деньги</label>
    <input id="lSum" type="text" class="textInput" value="65655765868876">
    <i style="background-image: url(i/yandexM.png);"></i>
  </div>
  <span class="redText right addrekv"><span>+</span> <span class="bordered">Добавить реквизит</span></span>
  <div class="clear"></div>
  
  <div class="submitWrapper lined">
    <input type="submit" ng-hide="btHide" class="button pink" value="{{text_save}}">
  </div>

</form>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
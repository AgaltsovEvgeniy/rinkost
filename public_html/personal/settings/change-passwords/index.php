<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Изменить пароли');
$APPLICATION->AddChainItem('Настройки');
$APPLICATION->AddChainItem('Изменить пароли');
?>
<form ng-controller="ctrlChangePass" name="formChangePass" class="w400" ng-submit="submit()">
  <span ng-show="msg">{{msg}}<br><br></span>
  <div class="formRow">
    <label for="lSum" class="label">Текущий пароль</label>
    <input id="lSum" type="password" class="textInput" ng-model="user.current_pass" required ng-minlength="6">
  </div>

  <div class="formRow" ng-show="user.current_pass">
    <label for="lSum" class="label">Новый пароль</label>
    <input id="lSum" type="password" class="textInput" ng-model="user.pass" required ng-minlength="6">
  </div>

  <div class="formRow" ng-show="user.current_pass && user.pass">
    <label for="lSum" class="label">Подтверждение нового пароля <span class="error" ng-show="user.pass && user.confirm_pass && user.confirm_pass != user.pass">(не совпадает)</span></label>
    <input id="lSum" type="password" class="textInput" ng-model="user.confirm_pass" required ng-minlength="6">
  </div>
  
  <div class="submitWrapper">
    <input type="submit" class="button pink" ng-hide="btHide" value="Изменить">
  </div>

</form>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Открыть демо-счет");
?>
<div class="demoInfo">
  <img alt="" src="/i/demoinfo.jpg">
  <p>
    Учебный счет ничем не отличается от реального по своим функциональным возможностям, за исключением того, что Вы не торгуете своими реальными деньгами.
    Тем самым вы приобретаете опыт                
    и уверенность, необходиммые для работы на реальные деньги
  </p>
</div>
<form class="width500 openDemo" action="">
		
  <div class="formRow"> 
    <div class="label dark">E-mail<span class="redText">*</span> <small>на этот e-mail будет отправлен пароль от демо-счета и личного кабинета</small></div>
    <input type="text" class="textInput jirB">
  </div>
  <div class="formRow">
    <div class="label">Фамилия</div>
    <input type="text" class="textInput">
  </div>
  <div class="formRow">
    <div class="label">Имя</div>
    <input type="text" class="textInput">
  </div>
  <div class="formRow">
    <div class="label">Отчество</div>
    <input type="text" class="textInput">
  </div>
  <div class="formRow">
    <div class="label">Телефон</div>
    <input type="text" class="textInput">
  </div>
  <input type="submit" value="Открыть Demo-счет" class="button pink">

</form>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
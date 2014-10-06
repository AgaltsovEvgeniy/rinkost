<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<form action="" class="width500">

    <div class="stripedTitle"><span>Наименование клиента</span></div>
    <div class="formRow">
      <label for="lSum" class="label">Фамилия</label>
      <input id="lSum" type="text" class="textInput" ng-model="user.last_name" required>
    </div>
    <div class="formRow">
      <label for="lSum" class="label">Имя</label>
      <input id="lSum" type="text" class="textInput" ng-model="user.name" required>
    </div>
    <div class="formRow">
      <label for="lSum" class="label">Отчество</label>
      <input id="lSum" type="text" class="textInput" ng-model="user.second_name" required>
    </div>

    <br>

    <div class="stripedTitle"><span>Контактные данные</span></div>
    <div class="formRow">
      <label for="lSum" class="label">Телефон</label>
      <input id="lSum" type="text" class="textInput" ng-model="user.phone" required ui-mask="+7 (999) 999-99-99">
    </div>
    <div class="formRow">
      <label for="lSum" class="label">E-mail</label>
      <input id="lSum" type="text" class="textInput" required ng-model="user.email" ng-pattern='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'>
    </div>

    <br>
    <?
    include $_SERVER['DOCUMENT_ROOT'].'/include/cache_country.php';
    
    if (!$country_id) { $country_id = 126; }
    ?>
    <div class="stripedTitle"><span>Адрес по прописке</span></div>
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
      <select name="region">
        <?
        foreach( $arRegions[$country_id] as $region ):?>
          <option value="<?=$region['ID']?>"><?=$region['NAME']?></option>
        <?endforeach;?>
      </select>
    </div>
    <?endif;?>
    <div class="formRow">
      <label for="lSum" class="label">Город</label>
      <input id="lSum" type="text" class="textInput" ng-model="user.city" required>
    </div>
    <div class="formRow">
      <label for="lSum" class="label">Адрес</label>
      <input id="lSum" type="text" class="textInput" ng-model="user.addr" required>
    </div>
    <div class="formRow">
      <label for="lSum" class="label">Индекс</label>
      <input id="lSum" type="text" class="textInput" ng-model="user.zip" required>
    </div>

    <br>

    <div class="stripedTitle"><span>Валюта</span></div>   
    <div class="formRow radioInline">
      <div>
        <input id="lUsd" type="radio" value="USD" name="currency" ng-model="user.currency"><label for="lUsd" class="label inline">USD</label>
      </div>    
      <div>
        <input id="lRur" type="radio" value="RUR" name="currency" ng-model="user.currency"><label for="lRur" class="label inline">RUR</label>
      </div>
      <div>
        <input id="lEur" type="radio" value="EUR" name="currency" ng-model="user.currency"><label for="lEur" class="label inline">EUR</label>
      </div>
    </div>

    <br>

    <div class="stripedTitle"><span>Тип счета</span></div>    
    <div class="formRow radioInline lined">
      <div>
        <input id="schType1" type="radio" value="Standart" name="schType" ng-model="user.type"><label for="schType1" class="label inline">Standart</label>
      </div>    
      <div>
        <input id="schType2" type="radio" value="Old" name="schType" ng-model="user.type"><label for="schType2" class="label inline">Old</label>
      </div>
      <div>
        <input id="schType3" type="radio" value="Cent" name="schType" ng-model="user.type"><label for="schType3" class="label inline">Cent</label>
      </div>
    </div>
    <div class="snoska">
      Котировка до 5 знаков, плавающий спред до 0,5L
    </div>

    <br><br>
    
    <div class="stripedTitle"><span>Бонус</span></div>    
    <div class="formRow radioInline lined">
      <div>
        <input id="bonusR1" type="radio" name="bonusR" value="25" ng-model="user.bonus"><label for="bonusR1" class="label inline">25%</label>
      </div>    
      <div>
        <input id="bonusR2" type="radio" name="bonusR" value="100/50" ng-model="user.bonus"><label for="bonusR2" class="label inline">100/50%</label>
      </div>
    </div>
    <div class="snoska">
      Вы получите 25% на все торговые операции
    </div>

    <br><br>

    <div class="stripedTitle"><span>Кредитное плечо</span></div>

    <div class="formRow">
      <label for="CredPlecho" class="label">Выберите кредитное полечо</label>
      <select name="plecho" id="CredPlecho">
        <option value="">1:500</option>
        <option value="">1:500</option>
        <option value="">1:500</option>
        <option value="">1:500</option>
        <option value="">1:500</option>
      </select>
    </div>
    
    <br>

    <div class="stripedTitle"><span>Партнер</span></div>

    <div class="formRow">
      <label for="partID" class="label">ID Партнера (если известен)</label>
      <input id="partID" type="text" class="textInput" ng-model="user.partner_id">
    </div>
    
    <br>
    
    <div class="stripedTitle"><span>Соглашение</span></div>
    <div class="formRow">
      <label for="CredPlecho" class="label">Ознакомьтесь</label>
      <div class="soglashenieText">
        <?$APPLICATION->IncludeFile( '/include/chunks/soglashenie.htm', array(), array('MODE'=>'html') );?>
      </div>
    </div>
  
    <div>
      <input id="soglashenieChB" type="checkbox" name="soglashenieChB" required ng-model="user.sogl"><label for="soglashenieChB" class="label">Я согласен с условиями договора</label>
    </div>  

    <div class="submitWrapper">
      <input type="submit" class="button pink" value="Сохранить">
    </div>

  </form>

  <div class="primechanieOpen">
    <p><b class="bold">Примечание:</b></p>
    <?$APPLICATION->IncludeFile( '/include/chunks/primechanie.htm', array(), array('MODE'=>'html') );?>
  </div>
</main>
</div>
<div class="pageContent">
<main class="demoLink">
  <div class="demoInfo onRealPage">
    <img src="/i/demoinfo.jpg" alt="">
    <p><a href="" class="redText">Открыть демо счет</a></p>
    <?$APPLICATION->IncludeFile( '/include/chunks/openDemo.htm', array(), array('MODE'=>'html') );?>
  </div>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// получим адрес
$addr = file_get_contents('address.php');
preg_match( '/\?>(.+?)<\?/', $addr, $addr );
$addr = $addr[1];
?>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0-stable/?lang=ru-RU&coordorder=longlat&load=package.full&wizard=constructor"></script>
<script type="text/javascript">
  var myMap=null,
      coords = [];
  ymaps.ready(init);
  function init(){
    ymaps.geocode('<?=$addr?>',{results:1}).then(function (res) {
      coords = res.geoObjects.get(0).geometry.getCoordinates();
      myMap=new ymaps.Map("mapYandex",{
          center:coords,
          zoom: 16,
          type: "yandex#map"
        }
      );
      myMap.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map","yandex#satellite","yandex#hybrid","yandex#publicMap"]));
      var placemark=new ymaps.Placemark(coords,
        {balloonContent: "Rinkost"},{
          iconImageHref: "/i/marker.png",
          iconImageSize:[57,67],
          iconOffset:[-15, 0]
        }
      );
      myMap.geoObjects.add(placemark);
    });
  }
</script>

<div class="contactsPage">
<?
  $rsSites = CSite::GetByID(SITE_ID);
  $arSite = $rsSites->Fetch();
  ?>
  <div id="mapYandex"></div>
  <div class="baseContacts">
    <div class="cRow phone">
      Многоканальный телефон:<br>
      <span><?$APPLICATION->IncludeFile('/include/chunks/phone.htm', array(), array('MODE'=>'html'));?></span>
    </div>

    <div class="cRow email">
      Электронная почта: <br>
      <span><a href="mailto:<?=$arSite['EMAIL']?>" class="redText"><?=$arSite['EMAIL']?></a></span>
    </div>

    <div class="cRow address">
      <?$APPLICATION->IncludeFile('/include/chunks/addr.htm', array(), array('MODE'=>'html'));?>
    </div>
  </div>
  
  <div class="TPblock">

    <?
    $obCache = new CPHPCache();
    $cacheID = 'contacts'; // используем некое уникальное имя для кэша
    $cacheLifetime = 3600*24; // сутки
    if ( $obCache->InitCache($cacheLifetime, $cacheID) ) {
      $vars = $obCache->GetVars();
      $arrData = $vars['arrData'];
    } else {
      CModule::IncludeModule('iblock');
      $arrData = array();
      $res = CIBlockSection::GetList( array('sort'=>'asc'), array( 'IBLOCK_ID'=>CFG::IBLOCK_CONTACTS, 'SECTION_ID'=>0, 'ACTIVE'=>'Y' ), false );
      while ( $arSect = $res->GetNext() ) {
        $resElem = CIBlockElement::GetList( array('sort'=>'asc'), array('IBLOCK_ID'=>$arSect['IBLOCK_ID'], 'SECTION_ID'=>$arSect['ID'], 'ACTIVE'=>'Y'), false, false, array('*', 'PROPERTY_ICQ', 'PROPERTY_SKYPE', 'PROPERTY_EMAIL') );
        $ar = array();
        while ( $arElem = $resElem->GetNext() ) {
          $arElem['IMG'] = CFile::GetPath( $arElem['PREVIEW_PICTURE'] );
          $ar[] = $arElem;
        }
        $arrData[] = array( 'id'=>$arSect['ID'], 'name'=>$arSect['NAME'], 'users'=>$ar );
      }
      $obCache->EndDataCache(array('arrData' => $arrData));
    }
    foreach ($arrData as $row) {
      echo'<span class="boldLabel">'.$row['name'].'</span>';
      foreach ( $row['users'] as $item ) {
      ?>
      <div class="row">
        <span class="TPpic">
          <span class="inner">
            <?if($item['IMG']):?><img src="<?=$item['IMG']?>"><?endif?>
          </span>           
        </span>
        <div class="desc">
          <span><?=$item['NAME']?></span>
          <div class="workTime"><?=$item['~PREVIEW_TEXT']?></div>
        </div>
        <div class="contacts">
          <?if($item['PROPERTY_SKYPE_VALUE']):?>
            <span class="chat"><span><span><a href="skype:<?=$item['PROPERTY_SKYPE_VALUE']?>?chat">Открыть чат</a></span></span></span>
          <?endif;?>
          <?if($item['PROPERTY_ICQ_VALUE']):?>
            <span class="icq"><span><span><?=$item['PROPERTY_ICQ_VALUE']?></span></span></span>
          <?endif;?>
          <?if($item['PROPERTY_EMAIL_VALUE']):?>
            <span class="email"><span><span><a href="mailto:<?=$item['PROPERTY_EMAIL_VALUE']?>"><?=$item['PROPERTY_EMAIL_VALUE']?></a></span></span></span>
          <?endif;?>
        </div>
      </div>
      <?
      }
    }
    ?>
  </div>

  <form ng-controller="ctrlFeedback" name="formFeedback" class="w400 contForm" ng-submit="submit()">
    <span class="boldLabel">Техническая поддержка</span>
    <div class="formRow">
      <input id="lSum" type="text" class="textInput" placeholder="Представьтесь" required ng-model="user.name">
    </div>
    <div class="formRow">
      <input id="lSum" type="text" class="textInput" ui-mask="+7 (999) 999-99-99" required ng-model="user.phone">
    </div>
    <div class="formRow">
      <input id="lSum" type="text" class="textInput" placeholder="E-mail" required ng-model="user.email" ng-pattern='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'>
    </div>

    <div class="formRow">
      <select ng-model="user.otdel" required id="lSchetNum">
        <option value="">Выберите отдел</option>
        <?foreach( $arrData as $item ):?>
          <option value="<?=$item['name']?>"><?=$item['name']?></option>
        <?endforeach;?>
      </select>
    </div>
    <div class="formRow">
      <textarea ng-model="user.text" required cols="30" rows="10" placeholder="Ваш вопрос"></textarea>
    </div>
    
    <div class="submitWrapper">
      <input type="submit" class="button pink" value="Отправить">
    </div>
  </form>
</div>
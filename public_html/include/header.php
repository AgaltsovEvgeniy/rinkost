<?//include header
global $USER;
if ( $USER->IsAuthorized() && $_GET['logout'] == 'yes' ) {
  $USER->logout();
  localRedirect('/');
}
if($USER->IsAuthorized()):?><div id="bitrix_panel"><?$APPLICATION->ShowPanel();?></div><?endif;?>
<div id="pageHTML" ng-app="rinkost">
  <header id="header">
    <div id="containerHeader" class="inner">
      <div class="pinkPlash">
        <a href="/" class="logo">
          <img src="/i/logo.jpg" alt="" width="185" height="56">
        </a>
      </div>
      <div id="searchButton"></div>

      <div class="otherHeader">
        <div class="authH">
          <?
          Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('blockLogin');
          if ($USER->isAuthorized()):
            $r = $USER->GetByID( $USER->GetID() );
            $arUser = $r->GetNext();
            ?>
            <a class="actionButton" href="?logout=yes">Выход</a>
            <a href="/personal/my-account/" class="userLink">
              <span class="pic">
                <span class="inner">
                  <?if($arUser['PERSONAL_PHOTO']):?><img src="<?=CFile::GetPath($arUser['PERSONAL_PHOTO'])?>"><?endif;?>
                </span>           
              </span>
              <span class="name"><?=$arUser['LAST_NAME']?> <?=$arUser['NAME']?> <?=$arUser['SECOND_NAME']?></span>
            </a>
          <?else:?>
            <div class="actionButton" onclick="openAuthorizePopup()">Вход</div>
          <?endif;
          Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('blockLogin', '');
          ?>
        </div>
        <div class="hPhone">
          <a href="tel:+78001000028" class="tel">8-800-100-00-28</a><br>
          <span class="info">Звонки по России бесплатно</span><br>
          <span class="redText">Заказать звонок?</span>
        </div>      
      </div>    
    </div>
  </header>
  <?
  $classVisible = '';
  $qValue = '';
  if($APPLICATION->GetCurPage()=='/search/'){
    $classVisible = ' visible';
    $qValue = htmlspecialchars($_GET['q']);
    $qValue = trim(str_replace('"',"'",$qValue));
  }
  ?>
  <div id="siteSearch" class="preload<?=$classVisible?>">
    <form class="inner" ng-form-ignore action="/search/">
      <input type="text" placeholder="Введите ключевые слова для поиска" name="q" value="<?=$qValue?>"><input type="submit" class="button pink" value="Найти">
    </form>
  </div>
  <?$APPLICATION->IncludeComponent("bitrix:menu",".default",Array(
      "ROOT_MENU_TYPE" => "top", 
      "MAX_LEVEL" => "1", 
      "CHILD_MENU_TYPE" => "", 
      "USE_EXT" => "Y",
      "DELAY" => "N",
      "ALLOW_MULTI_SELECT" => "Y",
      "MENU_CACHE_TYPE" => "N", 
      "MENU_CACHE_TIME" => "3600", 
      "MENU_CACHE_USE_GROUPS" => "Y", 
      "MENU_CACHE_GET_VARS" => "" 
    )
  );?>
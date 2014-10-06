<? include $_SERVER['DOCUMENT_ROOT'].'/include/head.php';
global $USER, $arCurrentUser;
$arCurrentUser = array();
if ( preg_match('/^\/personal\//', $_SERVER['REQUEST_URI']) ) {
  if ( $USER->isAuthorized() ) {
    $r = $USER->GetByID( $USER->GetID() );
    $arCurrentUser = $r->GetNext();
  } else { include $_SERVER['DOCUMENT_ROOT'].'/404.php'; }
}
?>
<body class="preload inner980">
  <? include $_SERVER['DOCUMENT_ROOT'].'/include/header.php'; ?>
  <div id="containerMain" >
    <div class="containerMain inner">
      <div class="pageContent">
        <aside id="leftSidebar">    
          <nav class="sbInner">

            <div class="titleGreenB personalCab">Личный<br><span><b>Кабинет</b></span></div>
            
            <?$APPLICATION->IncludeComponent("bitrix:menu","personal",Array(
                "ROOT_MENU_TYPE" => "personal", 
                "MAX_LEVEL" => "1", 
                "CHILD_MENU_TYPE" => "", 
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "Y",
                "MENU_CACHE_TYPE" => "N", 
                "MENU_CACHE_TIME" => "3600", 
                "MENU_CACHE_USE_GROUPS" => "Y", 
                "MENU_CACHE_GET_VARS" => "" 
              )
            );?>

            <br>
            <br>
            <div class="titleGreenB loginTrader">Войти в<br><span><b>Web Trader</b></span></div>
            
            <ul>
              <li><a href="">Войти через любое устройство</a></li>
            </ul>

          </nav>      
        </aside>

        <main role="main" class="dinamicContent">

          <? include $_SERVER['DOCUMENT_ROOT'].'/include/breadcrumbs.php'; ?>

          <h1 class="pageTitle"><?$APPLICATION->ShowTitle(false)?></h1>
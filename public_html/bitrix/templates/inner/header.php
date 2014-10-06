<? include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'; ?>
<body class="preload inner980">
  <? include $_SERVER['DOCUMENT_ROOT'].'/include/header.php'; ?>
  <?$APPLICATION->IncludeComponent("bitrix:menu","secondary",Array(
      "ROOT_MENU_TYPE" => "left", 
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

<div id="containerMain" >
  <div class="containerMain inner">
    <div class="pageContent">
      <main role="main" class="dinamicContent">
        <? include $_SERVER['DOCUMENT_ROOT'].'/include/breadcrumbs.php'; ?>

        <h1 class="pageTitle"><?$APPLICATION->ShowTitle(false)?></h1>
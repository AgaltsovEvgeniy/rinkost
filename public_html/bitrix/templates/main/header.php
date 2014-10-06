<? include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'; ?>
<body class="preload">
  <? include $_SERVER['DOCUMENT_ROOT'].'/include/header.php'; ?>
  <div id="containerMain" >
    <div class="fotorama onmain slider" data-click="false" data-width="100%" data-minheight="650" data-autoplay="3000" data-arrows="false">
      <?
      $obCache = new CPHPCache();
      $cacheID = 'slider'; // используем некое уникальное имя для кэша
      $cacheLifetime = 3600*24; // сутки
      if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
        $vars = $obCache->GetVars();
        $html = $vars['html'];
      } else {
        CModule::IncludeModule('iblock');
        $res = CIBlockElement::GetList( array('sort'=>'asc'), array( 'IBLOCK_ID'=>CFG::IBLOCK_SLIDER, 'ACTIVE'=>'Y' ), false, false, array('*', 'PROPERTY_URL') );
        $html = '';
        while ( $ar = $res->GetNext() ) {
          if ( $ar['PROPERTY_URL_VALUE'] ) { $html .= '<a target="blank" href="'.$ar['PROPERTY_URL_VALUE'].'">'; }
          $html .= '<img src="'.CFile::GetPath( $ar['DETAIL_PICTURE'] ).'" alt="'.$ar['NAME'].'">';
          if ( $ar['PROPERTY_URL_VALUE'] ) { $html .= '</a>'; }
        }
        $obCache->EndDataCache(array('html' => $html));
      }
      echo $html;
      ?>
    </div>
    <div class="containerMain inner">
      <div class="pageContent"> 
        <main role="main">
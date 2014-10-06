<?
class FUNC{

  public static function getNextNews( $iNumPage = 1, $nPageSize = 5 ) {
    $obCache = new CPHPCache();
    $cacheID = 'newsList'.$iNumPage; // используем некое уникальное имя для кэша
    $cacheLifetime = 3600*24; // сутки
    $cachePath = '/news/'; // папка
    if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
      $vars = $obCache->GetVars();
      $data = $vars['data'];
    } else {
      CModule::IncludeModule('iblock');
      $data = array('html'=>'', 'more'=>false);
      $res = CIBlockElement::GetList( array('active_from'=>'desc', 'sort'=>'asc'), array( 'IBLOCK_ID'=>CFG::IBLOCK_NEWS, 'ACTIVE'=>'Y', 'ACTIVE_DATE'=>'Y', 'INCLUDE_SUBSECTIONS'=>'Y' ), false, array( 'nPageSize'=>$nPageSize, 'iNumPage'=>$iNumPage ), array() );
      if ( $res->SelectedRowsCount() > $nPageSize*$iNumPage ) { $data['more'] = true; }
      while ( $ar = $res->GetNext() ) {
        $data['items'][] = array(
          'url'=>$ar["DETAIL_PAGE_URL"],
          'img'=>CFile::GetPath($ar["PREVIEW_PICTURE"]),
          'name'=>$ar["NAME"],
          'date'=>CIBlockFormatProperties::DateFormat('j F', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'time'=>CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'date2'=>CIBlockFormatProperties::DateFormat('d.m.Y', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'anons'=>$ar["PREVIEW_TEXT"],
        );
        $data['html'] .= '<div class="row"><a href="'.$ar["DETAIL_PAGE_URL"].'" class="pic"><div class="inner">';
        if ( $ar["PREVIEW_PICTURE"] ) {
          $data['html'] .= '<img src="'.CFile::GetPath($ar["PREVIEW_PICTURE"]).'" alt="'.$ar["NAME"].'">';
        }
        $data['html'] .= '</div></a>';
        $data['html'] .= '<div class="pinkDate">'.CIBlockFormatProperties::DateFormat('j F', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())).', '.CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())).'</div>';
        $data['html'] .= '<span class="comments">15</span>';
        $data['html'] .= '<div class="text"><a href="'.$ar["DETAIL_PAGE_URL"].'" class="title redText">'.$ar["NAME"].'</a>';
        $data['html'] .= '<p>'.$ar["PREVIEW_TEXT"].'</p>';
        $data['html'] .= '</div></div>';
      }
      $obCache->EndDataCache(array('data' => $data));
    }
    return $data;
  }
  
  public static function getNextPromotions( $iNumPage = 1, $nPageSize = 5 ) {
    $obCache = new CPHPCache();
    $cacheID = 'promotionsList'.$iNumPage; // используем некое уникальное имя для кэша
    $cacheLifetime = 3600*24; // сутки
    $cachePath = '/promotions/'; // папка
    if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
      $vars = $obCache->GetVars();
      $data = $vars['data'];
    } else {
      CModule::IncludeModule('iblock');
      $data = array('html'=>'', 'more'=>false);
      $res = CIBlockElement::GetList( array('active_from'=>'desc', 'sort'=>'asc'), array( 'IBLOCK_ID'=>CFG::IBLOCK_PROMOTIONS, 'ACTIVE'=>'Y', 'ACTIVE_DATE'=>'Y', 'INCLUDE_SUBSECTIONS'=>'Y' ), false, array( 'nPageSize'=>$nPageSize, 'iNumPage'=>$iNumPage ), array() );
      if ( $res->SelectedRowsCount() > $nPageSize*$iNumPage ) { $data['more'] = true; }
      while ( $ar = $res->GetNext() ) {
        $data['items'][] = array(
          'url'=>$ar["DETAIL_PAGE_URL"],
          'img'=>CFile::GetPath($ar["PREVIEW_PICTURE"]),
          'name'=>$ar["NAME"],
          'date'=>CIBlockFormatProperties::DateFormat('j F', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'time'=>CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'date2'=>CIBlockFormatProperties::DateFormat('d.m.Y', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'anons'=>$ar["PREVIEW_TEXT"],
        );
        $data['html'] .= '<div class="row"><a href="'.$ar["DETAIL_PAGE_URL"].'" class="pic"><div class="inner">';
        if ( $ar["PREVIEW_PICTURE"] ) {
          $data['html'] .= '<img src="'.CFile::GetPath($ar["PREVIEW_PICTURE"]).'" alt="'.$ar["NAME"].'">';
        }
        $data['html'] .= '</div></a>';
        $data['html'] .= '<div class="pinkDate">'.CIBlockFormatProperties::DateFormat('j F', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())).', '.CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())).'</div>';
        //$data['html'] .= '<span class="comments">15</span>';
        $data['html'] .= '<div class="text"><a href="'.$ar["DETAIL_PAGE_URL"].'" class="title redText">'.$ar["NAME"].'</a>';
        $data['html'] .= '<p>'.$ar["PREVIEW_TEXT"].'</p>';
        $data['html'] .= '</div></div>';
      }
      $obCache->EndDataCache(array('data' => $data));
    }
    return $data;
  }

  public static function outFileSize($size, $postfix = array('б', 'Кб', 'Мб', 'Гб', 'Тб', 'Пб', )) {
    return $size
        ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$postfix[$i]
        : '0 '.$postfix[0];
  }

  public static function getNextReviews( $iNumPage = 1, $nPageSize = 8 ) {
    $obCache = new CPHPCache();
    $cacheID = 'reviewsList'.$iNumPage; // используем некое уникальное имя для кэша
    $cacheLifetime = 3600*24; // сутки
    $cachePath = '/about-company/reviews/'; // папка
    if ( $obCache->InitCache($cacheLifetime, $cacheID, $cachePath) ) {
      $vars = $obCache->GetVars();
      $data = $vars['data'];
    } else {
      CModule::IncludeModule('iblock');
      $data = array('html'=>'', 'more'=>false);
      $arFilter = array( 'IBLOCK_ID'=>CFG::IBLOCK_REVIEWS, 'ACTIVE'=>'Y', 'ACTIVE_DATE'=>'Y', 'INCLUDE_SUBSECTIONS'=>'Y' );
      $res = CIBlockElement::GetList( array('active_from'=>'desc', 'sort'=>'asc'), $arFilter, false, array( 'nPageSize'=>$nPageSize, 'iNumPage'=>$iNumPage ), array() );
      if ( $res->SelectedRowsCount() > $nPageSize*$iNumPage ) { $data['more'] = true; }
      while ( $ar = $res->GetNext() ) {
        $data['items'][] = array(
          'img'=>CFile::GetPath($ar["PREVIEW_PICTURE"]),
          'name'=>$ar["NAME"],
          'date'=>CIBlockFormatProperties::DateFormat('j F', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'time'=>CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'date2'=>CIBlockFormatProperties::DateFormat('d.m', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())),
          'anons'=>$ar["PREVIEW_TEXT"],
        );
        
        $data['html'] .= '<div class="row">';

         $data['html'] .= '<div class="pic">';
            $data['html'] .= '<div class="inner">';
              if($ar["PREVIEW_PICTURE"]) { $data['html'] .= '<img src="'.CFile::GetPath($ar["PREVIEW_PICTURE"]).'" alt="">'; }
              else{ $data['html'] .= '<img src="/i/noface.png" alt="">'; }
            $data['html'] .= '</div>';
         $data['html'] .= '</div>';

         $data['html'] .= '<div class="text">';
          $data['html'] .= '<p class="submitted"><span class="name">'.$ar['NAME'].'</span> написал '.CIBlockFormatProperties::DateFormat('d.m', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())).' в '.CIBlockFormatProperties::DateFormat('H:i', MakeTimeStamp($ar["ACTIVE_FROM"], CSite::GetDateFormat())).'</p>';
          $data['html'] .= '<p>'.$ar['PREVIEW_TEXT'].'</p>';
         $data['html'] .= '</div>'; 

        $data['html'] .= '</div>';

       
      }
      $obCache->EndDataCache(array('rewdata' => $data));
    }
    return $data;
  }
}
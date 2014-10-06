<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результаты поиска");
?>
<?$APPLICATION->IncludeComponent(
  'bitrix:search.page',
  '',
  array(
    "TAGS_SORT" => "NAME",
    "TAGS_PAGE_ELEMENTS" => "150",
    "TAGS_PERIOD" => "30",
    "TAGS_URL_SEARCH" => "/search/index.php",
    "TAGS_INHERIT" => "Y",
    "FONT_MAX" => "50",
    "FONT_MIN" => "10",
    "COLOR_NEW" => "000000",
    "COLOR_OLD" => "C8C8C8",
    "PERIOD_NEW_TAGS" => "",
    "SHOW_CHAIN" => "Y",
    "COLOR_TYPE" => "N",
    "WIDTH" => "100%",
    "USE_SUGGEST" => "Y",
    "SHOW_RATING" => "N",
    "PATH_TO_USER_PROFILE" => "",
    "AJAX_MODE" => "N",
    "RESTART" => "Y",
    "NO_WORD_LOGIC" => "N",
    "USE_LANGUAGE_GUESS" => "N",
    "CHECK_DATES" => "Y",
    "USE_TITLE_RANK" => "Y",
    "DEFAULT_SORT" => "rank",
    "FILTER_NAME" => "",
    "arrFILTER" => array("no"),
    "SHOW_WHERE" => "Y",
    "arrWHERE" => array(),
    "SHOW_WHEN" => "Y",
    "PAGE_RESULT_COUNT" => 20,
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "3600",
    "DISPLAY_TOP_PAGER" => "Y",
    "DISPLAY_BOTTOM_PAGER" => "Y",
    "PAGER_TITLE" => "Результаты поиска",
    "PAGER_SHOW_ALWAYS" => "Y",
    "PAGER_TEMPLATE" => "",
    "AJAX_OPTION_SHADOW" => "Y",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_ADDITIONAL" => ""
  )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
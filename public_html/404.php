<?
define("PATH_TO_404", "/404.php");
global $APPLICATION;
$APPLICATION->RestartBuffer();
CHTTP::SetStatus("404 Not Found");
include $_SERVER['DOCUMENT_ROOT'].'/include/head.php';
?>
<body class="preload inner980">
<?
include $_SERVER['DOCUMENT_ROOT'].'/include/header.php';
?>
<div id="containerMain" class="page404">
  <span>
    Увы, произошла<br>
    <b class="boldText">ошибка 404 :(</b>
  </span>
<?
include $_SERVER['DOCUMENT_ROOT'].'/include/footer.php';
die;
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Документы");
echo'<div class="docsPage"><p class="text18">';
?>До регистрации торгового счёта в нашей компании Вам необходимо внимательно изучить Клиентское соглашение со всеми его приложениями (Спецификация контрактов, Порядок ввода/вывода средств, Регламент, Предупреждение о рисках). Это соглашение будет считаться заключенным и будет иметь точно такую же юридическую силу, как и договор, оформленный в простой письменной форме, после прохождения Вами онлайн регистрации и пополнения своего торгового счета в течение тридцати дней с момента его открытия.<?
echo'</p>';
include $_SERVER['DOCUMENT_ROOT'].'/include/cache_docs.php';
echo '<table>';
foreach ($arrData as $item) {
  echo'<tr><td class="tDocTitle"><span class="docExt">'.$item['desc'].'</span></td>';
  echo'<td class="tDocVes">.'.$item['ext'].' '.$item['size'].'</td>';
  echo'<td class="tDocLink"><a target="blank" href="'.$item['url'].'" class="">Скачать</a></td></tr>';
}
echo'</table>';
echo'</div>';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости");

?>
<?
echo'<div ng-controller="ctrlNextContent"><div class="newsListPage">';
$news = FUNC::getNextNews();
echo $news['html'];
echo'</div>';
if ($news['more']) { echo'<div ng-show="btShow" class="showNext" ng-click="next()">Показать еще 5</div>'; }
echo'</div>';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
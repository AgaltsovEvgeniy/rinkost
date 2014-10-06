<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Акции и бонусы");

?>
<?
echo'<div ng-controller="ctrlNextPromotions"><div class="newsListPage">';
$promotions = FUNC::getNextPromotions();
echo $promotions['html'];
echo'</div>';
if ($promotions['more']) { echo'<div ng-show="btShow" class="showNext" ng-click="next()">Показать еще 5</div>'; }
echo'</div>';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
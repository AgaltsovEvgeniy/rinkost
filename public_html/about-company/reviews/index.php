<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы");
?>
<div ng-controller="ctrlNextReview">
	<div class="commentsList commentPage">
		<a onclick="openSendReview()" class="button white gray vUglu">Написать отзыв</a>
		<div class="rows">
			<?
				$reviews = FUNC::getNextReviews();
				echo $reviews['html'];
			?>
			<?if ($reviews['more']) { echo'<div ng-show="btShow" class="showNext" ng-click="next()">Показать еще 5</div>'; }?>
		</div>
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
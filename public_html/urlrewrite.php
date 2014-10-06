<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/forex\\-trading/depositing\\-and\\-withdrawal\\-of\\-funds/(\\d+)/#",
		"RULE" => "ID=\$1",
		"ID" => "",
		"PATH" => "/forex-trading/depositing-and-withdrawal-of-funds/detail.php",
	),
	array(
		"CONDITION" => "#/promotions\\-and\\-bonuses/(.+?)/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/promotions-and-bonuses/detail.php",
	),
	array(
		"CONDITION" => "#^/beginners/lectures/(.+?)/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/beginners/lectures/index.php",
	),
	array(
		"CONDITION" => "#/about\\-company/news/(.+?)/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/about-company/news/detail.php",
	),
	array(
		"CONDITION" => "#/beginners/lessons/(.+?)/.*#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/beginners/lessons/index.php",
	),
	array(
		"CONDITION" => "#^/beginners/glossary/.*#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/beginners/glossary/index.php",
	),
);

?>
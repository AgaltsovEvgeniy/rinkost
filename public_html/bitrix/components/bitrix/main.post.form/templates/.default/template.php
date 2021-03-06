<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/file.php");
$array = (((!empty($arParams["DESTINATION"]) || in_array("MentionUser", $arParams["BUTTONS"])) && IsModuleInstalled("socialnetwork")) ?
	array('socnetlogdest') : array());
$array[] = "fx";
CUtil::InitJSCore($array);
$arButtonsHTML = array();

foreach($arParams["BUTTONS"] as $val)
{
	switch($val)
	{
		case "CreateLink":
			$arButtonsHTML[] = '<span class="feed-add-post-form-but feed-add-link" id="bx-b-link-'.$arParams["FORM_ID"].'"></span>';
			break;
		case "UploadImage":
			$arButtonsHTML[] = '<span class="feed-add-post-form-but feed-add-img" id="bx-b-uploadimage-'.$arParams["FORM_ID"].'"></span>';
			break;
		case "UploadFile":
			$arButtonsHTML[] = '<span class="feed-add-post-form-but feed-add-file" id="bx-b-uploadfile-'.$arParams["FORM_ID"].'" '.
					'title="'.GetMessage('MPF_FILE_TITLE').'"></span>';
			break;
		case "InputVideo":
			$arButtonsHTML[] = '<span class="feed-add-post-form-but feed-add-video" id="bx-b-video-'.$arParams["FORM_ID"].'"></span>';
			break;
		case "InputTag":
			$arButtonsHTML[] = '<span class="feed-add-post-form-but feed-add-tag" id="bx-b-tag-input-'.$arParams["FORM_ID"].'" '.
				'title="'.GetMessage("MPF_TAG_TITLE").'"></span>';
			break;
		case "MentionUser":
			$arButtonsHTML[] = '<span class="feed-add-post-form-but feed-add-mention" id="bx-b-mention-'.$arParams["FORM_ID"].'" '.
				'title="'.GetMessage("MPF_MENTION_TITLE").'"></span>';
			break;
		case "Quote":
			$arButtonsHTML[] = '<span class="feed-add-post-form-but feed-add-quote" id="bx-b-quote-'.$arParams["FORM_ID"].'"></span>';
			break;
		default:
			if (array_key_exists($val, $arParams["BUTTONS_HTML"]))
				$arButtonsHTML[] = $arParams["BUTTONS_HTML"][$val];
			break;
	}
}
?>
<div class="feed-add-post-micro" id="micro<?=$arParams["LHE"]["jsObjName"]?>" <?
	?>onclick="BX.onCustomEvent(this.nextSibling, 'OnControlClick'); if(this.nextSibling.style.display=='none'){BX.onCustomEvent(this.nextSibling, 'OnShowLHE', ['show']);}" <?
	?><?if(!$arParams["LHE"]["bInitByJS"]){?> style="display:none;"<?}?>><?=GetMessage("BLOG_LINK_SHOW_NEW")?></div><?
?><div class="feed-add-post" id="div<?=$arParams["LHE"]["jsObjName"]?>" <?if($arParams["LHE"]["bInitByJS"]){?> style="display:none;"<?}?>>
	<div class="feed-add-post-form feed-add-post-edit-form">
		<?=$arParams["~HTML_BEFORE_TEXTAREA"]?>
		<div class="feed-add-post-text"><?
			if ($arParams["TEXT"]["~SHOW"] != "Y"):?>
			<div class="feed-add-close-icon" onclick="window['<?=$arParams["JS_OBJECT_NAME"]?>'].showPanelEditor(false);" id="bx-panel-close"></div><?
			endif;?>
<script type="text/javascript">
	BX.message({
		'BX_FPD_LINK_1':'<?=GetMessageJS("MPF_DESTINATION_1")?>',
		'BX_FPD_LINK_2':'<?=GetMessageJS("MPF_DESTINATION_2")?>',
		'TAG_ADD': '<?=GetMessageJS("MPF_ADD_TAG1")?>',
		'MPF_IMAGE': '<?=GetMessageJS("MPF_IMAGE_TITLE")?>',
		'MPF_FILE': '<?=GetMessageJS("MPF_INSERT_FILE")?>',
		'MPF_FILE_INSERT_IN_TEXT': '<?=GetMessageJS("MPF_FILE_INSERT_IN_TEXT")?>',
		'MPF_FILE_IN_TEXT': '<?=GetMessageJS("MPF_FILE_IN_TEXT")?>',
		'MPF_NAME_TEMPLATE' : '<?=urlencode($arParams['NAME_TEMPLATE'])?>',
		'MPF_SMILE_SET' : '<?=GetMessageJS("MPF_SMILE_SET")?>'
	});
	<?
	$res = array();
	foreach ($tmp = array("UploadImage" => "postimage", "UploadFile" => "postfile",
		"InputVideo" => "postvideo", "MentionUser" => "postuser") as $key => $val):
		if (in_array($key, $arParams["PARSER"]))
			$res[] = $val;
	endforeach;

	if (is_array($GLOBALS["arExtranetGroupID"]))
	{
		?>
		if (typeof window['arExtranetGroupID'] == 'undefined')
		{
			window['arExtranetGroupID'] = <?=CUtil::PhpToJSObject($GLOBALS["arExtranetGroupID"])?>;
		}
		<?
	}
	?>
	BX.ready(function()
	{
		window['<?=$arParams["LHE"]["id"]?>Settings'] = <?=CUtil::PhpToJSObject(
			array(
				'parsers' => $res,
				'arFiles' => array_keys($arParams["FILES"]["VALUE_JS"]),
				'showEditor' => ($arParams["TEXT"]["SHOW"] == "Y"),
				'formID' => $arParams["FORM_ID"],
				'objName' => $arParams["JS_OBJECT_NAME"],
				'buttons' => $arParams["BUTTONS"]
			)
		);?>;
		window['<?=$arParams["JS_OBJECT_NAME"]?>'] = new LHEPostForm(
			'<?=$arParams["FORM_ID"]?>',
		<?=CUtil::PhpToJSObject(
			array(
				"sNewFilePostfix" => $arParams["FILES"]["POSTFIX"],
				"LHEJsObjId" => $arParams["LHE"]["id"],
				"LHEJsObjName" => $arParams["LHE"]["jsObjName"],
				"arSize" => $arParams["UPLOAD_FILE_PARAMS"],
				"WDLoadFormController" => !empty($arParams["UPLOAD_WEBDAV_ELEMENT"]),
				"WDControllerCID" => $arParams["UPLOAD_WEBDAV_ELEMENT_CID"],
				"BFileDLoadFormController" => !empty($arParams["~UPLOAD_FILE"]),
				"FControllerID" => $arParams["UPLOAD_FILE_CONTROL_ID"],
				"arFiles" => $arParams["FILES"]["VALUE_JS"],
				"arActions" => $arParams["BUTTONS"]
			));?>,
			window['<?=$arParams["LHE"]["id"]?>Settings']['parsers']
		);
	});

</script>
<?
if (IsModuleInstalled("fileman"))
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/lhe.php");
?>
		<div style="display:none;"><input type="text" tabindex="<?=($arParams["TEXT"]["TABINDEX"]++)?>" onFocus="window['<?=$arParams["LHE"]["jsObjName"]?>'].SetFocus()" name="hidden_focus" /></div>
		</div>
		<div class="feed-add-post-form-but-wrap" id="post-buttons-bottom"><?=implode("", $arButtonsHTML);
	if(!empty($arParams["ADDITIONAL"]))
	{

		if ($arParams["ADDITIONAL_TYPE"] == "popup") {
			?><div class="feed-add-post-form-but-more" <?
				?>onclick="BX.PopupMenu.show('menu-more<?=$arParams["FORM_ID"]?>', this, [<?=implode(", ", $arParams["ADDITIONAL"])?>], {offsetLeft: 42, offsetTop: 3, lightShadow: false, angle: top, events : {onPopupClose : function(popupWindow) {BX.removeClass(this.bindElement, 'feed-add-post-form-but-more-act');}}}); BX.addClass(this, 'feed-add-post-form-but-more-act');"><?
				?><?=GetMessage("MPF_MORE")?><?
				?><div class="feed-add-post-form-but-arrow"></div><?
			?></div><?
		}
		else if (count($arParams["ADDITIONAL"]) < 5)
		{
			?><div class="feed-add-post-form-but-more-open"><?
				?><?=implode("", $arParams["ADDITIONAL"])?>
			</div><?
		}
		else {
			foreach($arParams["ADDITIONAL"] as $key => $val) {
				$arParams["ADDITIONAL"][$key] = array("text" => $val, "onclick" => "BX.PopupMenu.Data['menu-more".$arParams["FORM_ID"]."'].popupWindow.close();");
			}
			?><script type="text/javascript">window['more<?=$arParams["FORM_ID"]?>']=<?=CUtil::PhpToJSObject($arParams["ADDITIONAL"])?>;</script><?
			?><div class="feed-add-post-form-but-more" <?
				?>onclick="BX.PopupMenu.show('menu-more<?=$arParams["FORM_ID"]?>', this, window['more<?=$arParams["FORM_ID"]?>'], {offsetLeft: 42, offsetTop: 3, lightShadow: false, angle: top, events : {onPopupClose : function(popupWindow) {BX.removeClass(this.bindElement, 'feed-add-post-form-but-more-act');}}}); BX.addClass(this, 'feed-add-post-form-but-more-act');"><?
				?><?=GetMessage("MPF_MORE")?><?
				?><div class="feed-add-post-form-but-arrow"></div><?
			?></div><?
		}
	}
	?></div>
</div>
<?=$arParams["~HTML_AFTER_TEXTAREA"]?><?
if($arParams["DESTINATION_SHOW"] == "Y" || !empty($arParams["TAGS"]))
{
?><ol class="feed-add-post-strings-blocks"><?
}
if($arParams["DESTINATION_SHOW"] == "Y")
{
?>
<li class="feed-add-post-destination-block">
	<div class="feed-add-post-destination-title"><?=GetMessage("MPF_DESTINATION")?></div>
	<div class="feed-add-post-destination-wrap" id="feed-add-post-destination-container">
		<span id="feed-add-post-destination-item"></span>
		<span class="feed-add-destination-input-box" id="feed-add-post-destination-input-box">
			<input type="text" value="" class="feed-add-destination-inp" id="feed-add-post-destination-input">
		</span>
		<a href="#" class="feed-add-destination-link" id="bx-destination-tag"></a>
	</div>
</li>
<?
}
if (!empty($arParams["TAGS"]))
{
	$tags = "";
	$tagsInput = "";
	foreach($arParams["TAGS"]["VALUE"] as $val)
	{
		$val = trim($val);
		if(strlen($val) > 0)
		{
			$tags .= '<span class="feed-add-post-tags" data-tag="'.htmlspecialcharsbx($val).'">'.htmlspecialcharsEx($val);
			$tags .= '<span class="feed-add-post-del-but"></span></span>';

			if ($tagsInput != "")
			{
				$tagsInput .= ",";
			}
			$tagsInput .= htmlspecialcharsbx($val);
		}
	}
?>
<li id="post-tags-block-<?=$arParams["FORM_ID"]?>" class="feed-add-post-tags-block"<?if ($tags !== ""):?> style="display:block"<?endif?>>
	<div class="feed-add-post-tags-title"><?=GetMessage("MPF_TAGS")?></div>
	<div class="feed-add-post-tags-wrap" id="post-tags-container-<?=$arParams["FORM_ID"]?>">
		<?=$tags?>
		<span class="feed-add-post-tags-add" id="post-tags-add-new-<?=$arParams["FORM_ID"]?>"><?=GetMessage("MPF_ADD_TAG")?></span>
		<input type="hidden" name="<?=$arParams["TAGS"]["NAME"]?>" id="post-tags-hidden-<?=$arParams["FORM_ID"]?>" value="<?=$tagsInput?>,">
	</div>
<div id="post-tags-popup-content-<?=$arParams["FORM_ID"]?>" style="display:none;">
<?if($arParams["TAGS"]["USE_SEARCH"] == "Y" && IsModuleInstalled("search"))
{
	$APPLICATION->IncludeComponent(
		"bitrix:search.tags.input",
		".default",
		Array(
			"NAME"	=>	$arParams["TAGS"]["NAME"]."_".$arParams["FORM_ID"],
			"VALUE"	=>	"",
			"arrFILTER"	=>	$arParams["TAGS"]["FILTER"],
			"PAGE_ELEMENTS"	=>	"10",
			"SORT_BY_CNT"	=>	"Y",
			"TEXT" => 'size="30" tabindex="'.($arParams["TEXT"]["TABINDEX"]++).'"',
			"ID" => "post-tags-popup-input-".$arParams["FORM_ID"]
		),
		false,
		array("HIDE_ICONS" => "Y")
	);
}
else
{
	?><input type="text" id="post-tags-popup-input-<?=$arParams["FORM_ID"]?>" tabindex="<?=($arParams["TEXT"]["TABINDEX"]++)?>" name="<?=$arParams["TAGS"]["NAME"]?>" size="30" value=""><?
}?>
</div>
<script type="text/javascript">
var BXPostFormTags_<?=$arParams["FORM_ID"]?> = new BXPostFormTags("<?=$arParams["FORM_ID"]?>", "bx-b-tag-input-<?=$arParams["FORM_ID"]?>");
</script>
</li>
<?
}
if($arParams["DESTINATION_SHOW"] == "Y" || !empty($arParams["TAGS"]))
{
?></ol><?
}

if (in_array('socnetlogdest', $array))
{
?>
<script type="text/javascript">
	var lastUsers = <?=(empty($arParams["DESTINATION"]['LAST']['USERS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['USERS']))?>;
	MPFMentionInit('<?=$arParams["FORM_ID"]?>', {
		jsObjName : '<?=$arParams["LHE"]["jsObjName"]?>',
		id : '<?=randString(6)?>',
		extranetUser : <?=($arParams["DESTINATION"]["EXTRANET_USER"] == 'Y'? 'true': 'false')?>,
		initDestination : <?=($arParams["DESTINATION_SHOW"] == "Y" ? "true" : "false")?>,
		items : {
			users : <?=(empty($arParams["DESTINATION"]['USERS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['USERS']))?>,
			groups : <?=($arParams["DESTINATION"]["EXTRANET_USER"] == 'Y' || (array_key_exists("DENY_TOALL", $arParams["DESTINATION"]) && $arParams["DESTINATION"]["DENY_TOALL"]) ?
			'{}' : "{'UA' : {'id':'UA','name': '".(!empty($arParams["DESTINATION"]['DEPARTMENT']) ? GetMessageJS("MPF_DESTINATION_3"): GetMessageJS("MPF_DESTINATION_4"))."'}}")?>,
			sonetgroups : <?=(empty($arParams["DESTINATION"]['SONETGROUPS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['SONETGROUPS']))?>,
			department : <?=(empty($arParams["DESTINATION"]['DEPARTMENT'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['DEPARTMENT']))?>,
			departmentRelation : <?=(empty($arParams["DESTINATION"]['DEPARTMENT_RELATION']) ?
				"false" : CUtil::PhpToJSObject($arParams["DESTINATION"]['DEPARTMENT_RELATION']))?>,
			contacts : <?=(empty($arParams["DESTINATION"]['CONTACTS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['CONTACTS'])); ?>,
			companies : <?=(empty($arParams["DESTINATION"]['COMPANIES'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['COMPANIES'])); ?>,
			leads : <?=(empty($arParams["DESTINATION"]['LEADS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LEADS'])); ?>,
			deals : <?=(empty($arParams["DESTINATION"]['DEALS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['DEALS'])); ?>
		},
		itemsLast : {
			users : lastUsers,
			sonetgroups : <?=(empty($arParams["DESTINATION"]['LAST']['SONETGROUPS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['SONETGROUPS']))?>,
			department : <?=(empty($arParams["DESTINATION"]['LAST']['DEPARTMENT'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['DEPARTMENT']))?>,
			groups : <?=($arParams["DESTINATION"]["EXTRANET_USER"] == 'Y' || (array_key_exists("DENY_TOALL", $arParams["DESTINATION"]) && $arParams["DESTINATION"]["DENY_TOALL"]) ? '{}' : "{'UA':true}" )?>,
			contacts : <?=(empty($arParams["DESTINATION"]['LAST']['CONTACTS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['CONTACTS'])); ?>,
			companies : <?=(empty($arParams["DESTINATION"]['LAST']['COMPANIES'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['COMPANIES'])); ?>,
			leads : <?=(empty($arParams["DESTINATION"]['LAST']['LEADS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['LEADS'])); ?>,
			deals : <?=(empty($arParams["DESTINATION"]['LAST']['DEALS'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['DEALS'])); ?>,
			crm : <?=(empty($arParams["DESTINATION"]['LAST']['CRM'])? '[]': CUtil::PhpToJSObject($arParams["DESTINATION"]['LAST']['CRM'])); ?>
		},
		itemsSelected : <?=(empty($arParams["DESTINATION"]['SELECTED'])? '{}': CUtil::PhpToJSObject($arParams["DESTINATION"]['SELECTED']))?>,
		itemsHidden : <?=CUtil::PhpToJSObject($arParams["DESTINATION"]["HIDDEN_GROUPS"])?>,
		isCrmFeed : <?=(empty($arParams["DESTINATION"]['LAST']['CRM']) ? 'false' : 'true'); ?>
	});
</script>
<?
}
/***************** Upload files ************************************/
?><?=$arParams["UPLOAD_FILE_HTML"]?><?
?><?=$arParams["UPLOAD_WEBDAV_ELEMENT_HTML"]?><?

if (!empty($arParams["FILES"]["VALUE"]) && $arParams["FILES"]["SHOW"] != "N")
{
?>
<div class="feed-add-post-files-block">
	<div class="feed-add-post-files-title feed-add-post-p"><?=GetMessage("MPF_FILES")?></div>
	<div class="feed-add-post-files-list-wrap">
		<div class="feed-add-photo-block-wrap" id="post-form-files">
			<?=implode($arParams["FILES"]["VALUE_HTML"])?>
		</div>
	</div>
</div>
<?
}
?>
	<div class="feed-add-post-buttons" id="lhe_buttons_<?=$arParams["FORM_ID"]?>">
		<a class="feed-add-button feed-add-com-button" href="javascript:void(0)" id="lhe_button_submit_<?=$arParams["FORM_ID"]?>" onmousedown="BX.addClass(this, 'feed-add-button-press')" onmouseup="BX.removeClass(this,'feed-add-button-press')" onclick="BX.onCustomEvent(BX('div<?=$arParams["LHE"]["jsObjName"]?>'), 'OnButtonClick', ['submit']);"><?
			?><span class="feed-add-button-left"></span><?
			?><span class="feed-add-button-text"><?=GetMessage("MPF_BUTTON_SEND")?></span><?
			?><span class="feed-add-button-right"></span></a>
		<a class="feed-cancel-com" href="javascript:void(0)" id="lhe_button_cancel_<?=$arParams["FORM_ID"]?>" onclick="BX.onCustomEvent(BX('div<?=$arParams["LHE"]["jsObjName"]?>'), 'OnButtonClick', ['cancel']);"><?=GetMessage("MPF_BUTTON_CANCEL")?></a>
	</div>
</div>


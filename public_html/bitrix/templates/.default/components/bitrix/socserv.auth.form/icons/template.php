<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(is_array($arParams["~AUTH_SERVICES"][0])){ echo 'Войти через:'; }
?>

<div class="bx-auth-serv-icons">
<?foreach($arParams["~AUTH_SERVICES"] as $service):?>
	<a title="<?=htmlspecialcharsbx($service["NAME"])?>" href="javascript:void(0)" onclick="BxShowAuthFloat('<?=$service["ID"]?>', '<?=$arParams["SUFFIX"]?>')" class="<?=$service['CLASS']?>"></a>
<?endforeach?>
</div>
<?
/*
<a href="" class="vk"></a>
<a href="" class="fb"></a>
<a href="" class="tw"></a>
<a href="" class="gg"></a>
*/
?>
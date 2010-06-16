{include file='header.light.tpl'}

<link rel="stylesheet" type="text/css" href="{$sTemplateWebPathPlugin}css/style.css" media="all" />

<div id="vk_api_transport"></div>
<script src="http://vkontakte.ru/js/api/openapi.js" type="text/javascript" charset="windows-1251"></script>


<div class="openid-block">
	<h1>{$aLang.openid_enter_title} <img src="{$sTemplateWebPathPlugin}img/openid.png" alt="openid" class="openid-img" title="{$aLang.openid}" alt="{$aLang.openid}"/></h1>
	
	<form method="post" action="{router page='login'}openid/enter/" name="fopenid" id="openid_form">
		<div style="overflow: hidden; zoom: 1;">
			<input type="text" style="float: left" class="openid-text" maxlength="255" name="open_login" id="open_login" />
			<input type="hidden" name="submit_open_login" id="submit_open_login_hidden" value="go"/>
			<input type="hidden" value="{$_aRequest.return}" name="return" />
			<a href="#" class="openid-login" onclick="getEl('openid_form').submit(); return false;"><span>{$aLang.openid_enter}</span></a>
		</div>
		
		<div class="openid-services">
			<p>{$aLang.openid_choose_service}</p>
			<a href="javascript: openid_yandex()"><img src="{$sTemplateWebPathPlugin}img/openid_yandex.png" alt="yandex" width="47px" height="21px" /></a>
			<a href="javascript: openid_google()"><img src="{$sTemplateWebPathPlugin}img/openid_google.png" class="google"  alt="google" width="63px" height="21px" /></a>
			<a href="javascript: openid_rambler()"><img src="{$sTemplateWebPathPlugin}img/openid_rambler.png" alt="rambler" width="84px" height="21px" /></a>
			<a href="javascript: openid_vk()"><img src="{$sTemplateWebPathPlugin}img/openid_vk.png" alt="vkontakte" width="84px" height="21px" /></a>
		</div>					
	</form>
</div>
		
		
<script language="JavaScript" type="text/javascript">
var sVkTransportPath='{cfg name='plugin.openid.vk.transport_path'}';
var iVkAppId='{cfg name='plugin.openid.vk.id'}';
var sVkLoginPath='{$aRouter.login}'+'openid/vk/';
{literal}
	function getEl(id) {
		return document.getElementById(id);
	}

	function openid_yandex() {
		getEl('open_login').value='openid.yandex.ru';		
		getEl('openid_form').submit();
	}
	
	function openid_rambler() {
		getEl('open_login').value='rambler.ru';		
		getEl('openid_form').submit();
	}
	
	function openid_google() {
		getEl('open_login').value='https://www.google.com/accounts/o8/id';		
		getEl('openid_form').submit();
	}
	
	function openid_vk() {		
		VK.Auth.login(null,VK.access.FRIENDS);
	}
		
	VK.init({
		apiId: iVkAppId,
		nameTransportPath: sVkTransportPath
	});
	
	VK.Observer.subscribe('auth.login', function(response) {
		window.location = sVkLoginPath;
	});
		
</script>
{/literal}

{include file='footer.light.tpl'}
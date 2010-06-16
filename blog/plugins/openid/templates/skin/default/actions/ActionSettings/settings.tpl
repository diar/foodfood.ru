{include file='header.tpl' menu='settings' showWhiteBack=true}

<h1>{$aLang.openid_menu_settings_title}</h1>

{if count($aOpenId)}

	{literal}
	<script language="JavaScript" type="text/javascript">
	function deleteOpenID(openid,obj) {
		new Request.JSON({
			url: aRouter['settings']+'openid/ajaxdeleteopenid/',
			noCache: false,
			data: {openid:openid,security_ls_key: LIVESTREET_SECURITY_KEY},
			onSuccess: function(resp){
				if (resp) {
					if (resp.bStateError) {
						msgErrorBox.alert(resp.sMsgTitle,resp.sMsg);
					} else {
						msgNoticeBox.alert(resp.sMsgTitle,resp.sMsg);
						$(obj).getParent().fade(0);
					}
				} else {
					msgErrorBox.alert('Error','Please try again later');
				}
			}.bind(this),
			onFailure: function(){
				msgErrorBox.alert('Error','Please try again later');
			}
		}).send();
		return false;
	}
	</script>
	{/literal}

	<ul>
	{foreach from=$aOpenId item=oOpenId}
		<li>{$oOpenId->getOpenid()|escape:'html'} <a href="#" onclick="return deleteOpenID('{$oOpenId->getOpenid()|escape:'html'}',this);"><img src="{$sTemplateWebPathPlugin}img/delete.png" alt="{$aLang.openid_menu_settings_delete}" title="{$aLang.openid_menu_settings_delete}"/></a></li>
	{/foreach}
	</ul>
{else}
	{$aLang.openid_menu_settings_empty}
{/if}

{include file='footer.tpl'}
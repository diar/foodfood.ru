{include file='header.light.tpl'}


<link rel="stylesheet" type="text/css" href="{$sTemplateWebPathPlugin}css/style.css" media="all" />

<div class="openid-block step-three wide">
	<h1>{$aLang.openid_confirm_mail_form_title} <img src="{$sTemplateWebPathPlugin}img/openid.png" alt="openid" class="openid-img" />: 
	<span>{$oKey->getOpenid()|escape:'html'} {if $sMailOpenId}({$sMailOpenId|escape:'html'}){/if}</span></h1>
			
	<form  method="post" action="{router page='login'}openid/confirm/" id="form_confirm">			
		<p>
			{$aLang.openid_confirm_mail_form_desc} <strong>{$oKey->getOpenid()|escape:'html'}</strong><br />
			{$aLang.openid_confirm_mail_form_question}
		</p>	
		
		<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
		<input type="hidden" value="{$_aRequest.confirm_key}" name="confirm_key"/>
		<input type="hidden" name="submit_confirm" id="submit_confirm"/>
		<input type="hidden" name="submit_cancel" id="submit_cancel"/>
		<a href="#" class="openid-ok" onclick="document.getElementById('submit_confirm').value='go';document.getElementById('form_confirm').submit();return false;"><span>{$aLang.openid_confirm_mail_form_yes}</span></a>	
		<a href="#" class="openid-no" onclick="document.getElementById('submit_cancel').value='go';document.getElementById('form_confirm').submit();return false;"><span>{$aLang.openid_confirm_mail_form_no}</span></a>				
	</form>
</div>						


{include file='footer.light.tpl'}
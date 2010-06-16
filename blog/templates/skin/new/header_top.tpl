	<!-- Header -->
	{if !$oUserCurrent}	
	<div style="display: none;">
	<div class="login-popup" id="login-form">
		<div class="login-popup-top"><a href="#" class="close-block" onclick="return false;"></a></div>
		<div class="content">
			<form action="{router page='login'}" method="POST">
				<h3>{$aLang.user_authorization}</h3>
				{hook run='form_login_popup_begin'}
				<div class="lite-note"><a href="{router page='registration'}">{$aLang.registration_submit}</a><label for="">{$aLang.user_login}</label></div>
				<p><input type="text" class="input-text" name="login" tabindex="1" id="login-input"/></p>
				<div class="lite-note"><a href="{router page='login'}reminder/" tabindex="-1">{$aLang.user_password_reminder}</a><label for="">{$aLang.user_password}</label></div>
				<p><input type="password" name="password" class="input-text" tabindex="2" /></p>
				{hook run='form_login_popup_end'}
				<div class="lite-note"><button type="submit" onfocus="blur()"><span><em>{$aLang.user_login_submit}</em></span></button><label for="" class="input-checkbox"><input type="checkbox" name="remember" checked tabindex="3" >{$aLang.user_login_remember}</label></div>
				<input type="hidden" name="submit_login">
			</form>
		</div>
		<div class="login-popup-bottom"></div>
	</div>
	</div>
	{/if}
	
		<div id="header">
            <div id="logo">
                <a href="/"><img src="/public/images/logo.png" alt="Настроение есть!" /></a>
            </div>
            <div class="banner770"></div>
            <div class="clear"></div>
        </div>
        <div id="topMenu">
          <a class="item" href="/kazan/poster">Афиша</a>
          <a class="item" href="/kazan/discount">Скидки</a>
          <a class="item {if $sMenuHeadItemSelect=='blog'}current{/if}" href="/blog">Блоги</a>
          <a class="item {if $sMenuHeadItemSelect=='people'}current{/if}" href="/blog/people">Гурманы</a>
          <a class="item" href="/market/">Доставка</a>
        </div>
		<div style="clear:both;">
		<div class="nav-main">
			
			{if $sMenuHeadItemSelect=='people'}Гурманы{else}{$aLang.blogs}{/if}
		
			{hook run='main_menu'}
		</div>
		
		{if $oUserCurrent}
		<div class="profile">
			<!--<a href="{$oUserCurrent->getUserWebPath()}" class="avatar"><img src="{$oUserCurrent->getProfileAvatarPath(48)}" alt="{$oUserCurrent->getLogin()}" /></a>-->
			<ul>
				<li><a href="{$oUserCurrent->getUserWebPath()}" class="author">{$oUserCurrent->getLogin()}</a> (<a href="{router page='login'}exit/?security_ls_key={$LIVESTREET_SECURITY_KEY}">{$aLang.exit}</a>)</li>
				<li>
					{if $iUserCurrentCountTalkNew}
						<a href="{router page='talk'}" class="message" id="new_messages" title="{$aLang.user_privat_messages_new}">{$iUserCurrentCountTalkNew}</a> 
					{else}
						<a href="{router page='talk'}" class="message-empty" id="new_messages">&nbsp;</a>
					{/if}
					{$aLang.user_settings} <a href="{router page='settings'}profile/" class="author">{$aLang.user_settings_profile}</a> 
				</li>
				<!--<li>{$aLang.user_rating} <strong>{$oUserCurrent->getRating()}</strong></li>-->
			</ul>
		</div>
		{else}
		<div class="profile guest">
			<a href="{router page='login'}" onclick="return showLoginForm();">Войти</a> /
			<a href="{router page='registration'}" class="reg">Регистрация</a>
		</div>
		{/if}
		
	<!-- /Header -->
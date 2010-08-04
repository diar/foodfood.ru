{include file='header.tpl' menu='settings' showWhiteBack=true}


			<h1>{$aLang.settings_social_edit}</h1>
			<form action="" method="POST" enctype="multipart/form-data">
				{hook run='form_settings_profile_begin'}
				<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />
                                
				<p><label for="profile_phone">{$aLang.settings_profile_phone}:</label><br /><input type="text" class="w300" name="profile_phone" id="profile_phone" value="{$oUserCurrent->getProfilePhone()|escape:'html'}"/></p>
				<p><label for="profile_icq">{$aLang.settings_profile_icq}:</label><br /><input type="text" class="w300" name="profile_icq" id="profile_icq" value="{$oUserCurrent->getProfileIcq()|escape:'html'}"/></p>
				<p><label for="profile_skype">{$aLang.settings_profile_skype}:</label><br /><input type="text" class="w300" name="profile_skype" id="profile_skype" value="{$oUserCurrent->getProfileSkype()|escape:'html'}"/></p>
				<p><label for="profile_jabber">{$aLang.settings_profile_jabber}:</label><br /><input type="text" class="w300" name="profile_jabber" id="profile_jabber" value="{$oUserCurrent->getProfileJabber()|escape:'html'}"/></p>
				<p><label for="profile_lj">{$aLang.settings_profile_lj}:</label><br /><input type="text" class="w300" name="profile_lj" id="profile_lj" value="{$oUserCurrent->getProfileLj()|escape:'html'}"/><br />
					<span class="form_note">{$aLang.settings_profile_lj_notice}</span></p>
				<p><label for="profile_vk">{$aLang.settings_profile_vk}:</label><br /><input type="text" class="w300" name="profile_vk" id="profile_vk" value="{$oUserCurrent->getProfileVk()|escape:'html'}"/><br />
					<span class="form_note">{$aLang.settings_profile_vk_notice}</span></p>
				
				<p>
					<label for="profile_site">{$aLang.settings_profile_site}:</label><br />
					<label for="profile_site"><input type="text" class="w300" style="margin-bottom: 5px;" id="profile_site" name="profile_site" value="{$oUserCurrent->getProfileSite()|escape:'html'}"/> &mdash; {$aLang.settings_profile_site_url}</label><br />
					<label for="profile_site_name"><input type="text" class="w300" id="profile_site_name"	name="profile_site_name" value="{$oUserCurrent->getProfileSiteName()|escape:'html'}"/> &mdash; {$aLang.settings_profile_site_name}</label>
				</p>
				
				{hook run='form_settings_profile_end'}
				<p><input type="submit" value="{$aLang.settings_profile_submit}" name="submit_social_edit"/></p>
			</form>

{include file='footer.tpl'}

			{if $oUserCurrent && $oUserCurrent->getId()!=$oUserProfile->getId()}
			<div class="block actions white friend">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">					
					<ul>
						{include file='actions/ActionProfile/friend_item.tpl' oUserFriend=$oUserProfile->getUserFriend()}
						<li><a href="{router page='talk'}add/?talk_users={$oUserProfile->getLogin()}">{$aLang.user_write_prvmsg}</a></li>						
					</ul>
				</div></div>

				<div class="bl"><div class="br"></div></div>
			</div>
			{/if}
			
			<div class="block contacts nostyle">
				
				{if $oUserProfile->getProfileFoto()}
				<img src="{$oUserProfile->getProfileFoto()}" alt="photo" /><br />
				{/if}

			{if $oUserProfile->getProfileIcq()}
				<strong>{$aLang.profile_social_contacts}</strong>
			{else}
			{if $oUserProfile->getProfileSkype()}
				<strong>{$aLang.profile_social_contacts}</strong>
			{else}
			{if $oUserProfile->getProfileJabber()}
				<strong>{$aLang.profile_social_contacts}</strong>
			{else}
			{if $oUserProfile->getProfileVk()}
				<strong>{$aLang.profile_social_contacts}</strong>
			{else}
			{if $oUserProfile->getProfileLj()}
				<strong>{$aLang.profile_social_contacts}</strong>
			{else}{/if}{/if}{/if}{/if}{/if}

				<ul>
					{if $oUserProfile->getProfileIcq()}
						<li class="icq"><a href="http://www.icq.com/people/about_me.php?uin={$oUserProfile->getProfileIcq()|escape:'html'}" target="_blank">{$oUserProfile->getProfileIcq()}</a></li>
					{/if}		
					{if $oUserProfile->getProfileJabber()}
						<li class="jabber"><a target="_blank" href="javascript://" onclick="prompt('Jabber','{$oUserProfile->getProfileJabber()}');return false;" rel="nofollow">{$oUserProfile->getProfileJabber()}</a></li>
					{/if}		
					{if $oUserProfile->getProfileLj()}
						<li class="lj"><a target="_blank" href="http://{$oUserProfile->getProfileLj()}.livejournal.com" rel="nofollow">{$aLang.settings_profile_lj}</a></li>
					{/if}
					{if $oUserProfile->getProfileVk()}
						<li class="vk"><a target="_blank" href="http://vkontakte.ru/{$oUserProfile->getProfileVk()}" rel="nofollow">{$aLang.settings_profile_vk}</a></li>
					{/if}	
					{if $oUserProfile->getProfileSkype()}
						<li class="skype"><a target="_blank" href="javascript://" onclick="prompt('Skype','{$oUserProfile->getProfileSkype()}');return false;" rel="nofollow">{$oUserProfile->getProfileSkype()}</a></li>
					{/if}
				</ul>
			</div>

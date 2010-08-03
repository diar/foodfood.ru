{include file='header.tpl' showWhiteBack=true menu='people'}

			<div class="page people">
		
				<h1>{$aLang.user_list} <span>({$aStat.count_all})</span></h1>

		<!--
				<ul class="block-nav">
					<li {if $sEvent=='good'}class="active"{/if}><strong></strong><a href="{router page='people'}good/">{$aLang.user_good}</a></li>
					<li {if $sEvent=='bad'}class="active"{/if}><a href="{router page='people'}bad/">{$aLang.user_bad}</a><em></em></li>
				</ul>
		-->
				{if $aUsersRating}
				<table>
					<tr>
                                            <td valign="top">
                                            {if $aUsersRegister}
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <td class='newUsersCaption'>Новые гурманы</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    {foreach from=$aUsersRegister item=oUser}
                                                        <tr>
                                                            <td class="user">
                                                                <a href="{router page='profile'}{$oUser->getLogin()}/">
                                                                    <img src="{$oUser->getProfileAvatarPath(48)}" alt="" />
                                                                </a>
                                                                <a href="{router page='profile'}{$oUser->getLogin()}/" class="link">{$oUser->getLogin()}</a>
                                                            </td>
                                                        </tr>
                                                    {/foreach}
                                                    </tbody>
                                                </table>

                                                {/if}
                                        </td>
                                        <td width="100"></td>
                                        <td valign="top">

                                            <table>
                                                <thead>
						<tr>
							<td class="user">{$aLang.user}</td>
							<td class="strength">{$aLang.user_skill}</td>
							<td class="rating">{$aLang.user_rating}</td>
						</tr>
                                                </thead>

                                                <tbody>
                                                {foreach from=$aUsersRating item=oUser}
                                                        <tr>
                                                                <td class="user"><a href="{router page='profile'}{$oUser->getLogin()}/"><img src="{$oUser->getProfileAvatarPath(48)}" alt="" /></a><a href="{router page='profile'}{$oUser->getLogin()}/" class="link">{$oUser->getLogin()}</a></td>
                                                                <td class="strength">{$oUser->getSkill()}</td>
                                                                <td class="rating"><strong>{$oUser->getRating()}</strong></td>
                                                        </tr>
                                                {/foreach}
                                                </tbody>
                                            </table>

                                        </td>
                                    </tr>
					
				</table>
				{else}
					{$aLang.user_empty}	
				{/if}
			</div>

<!--

-->
			{include file='paging.tpl' aPaging=`$aPaging`}

{include file='footer.tpl'}
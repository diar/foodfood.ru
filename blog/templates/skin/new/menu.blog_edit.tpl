
		<ul class="menu">
			<li class="active"><font color="#333333">{$aLang.blog_admin}</font>
				<ul class="sub-menu">					
					<li {if $sMenuItemSelect=='profile'}class="active"{/if}><div><a href="{router page='restaurant'}edit/{$oBlogEdit->getId()}/">{$aLang.blog_admin_profile}</a></div></li>
					<li {if $sMenuItemSelect=='admin'}class="active"{/if}><div><a href="{router page='restaurant'}admin/{$oBlogEdit->getId()}/">{$aLang.blog_admin_users}</a></div></li>
                                        {hook run='menu_blog_edit_admin_item'}
                                </ul>
			</li>
			{hook run='menu_blog_edit'}
		</ul>
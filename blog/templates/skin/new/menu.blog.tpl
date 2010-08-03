		<ul class="menu">
		
			<li {if $sMenuItemSelect=='index'}class="active"{/if}>
				<a href="{cfg name='path.root.web'}/">{$aLang.blog_menu_all}</a> {if $iCountTopicsNew>0}+{$iCountTopicsNew}{/if}
				{if $sMenuItemSelect=='index'}
					<ul class="sub-menu" >
						<li {if $sMenuSubItemSelect=='good'}class="active"{/if}><div><a href="{cfg name='path.root.web'}/">{$aLang.blog_menu_all_good}</a></div></li>						
						{if $iCountTopicsNew>0}<li {if $sMenuSubItemSelect=='new'}class="active"{/if}><div><a href="{router page='new'}">{$aLang.blog_menu_all_new}</a> +{$iCountTopicsNew}</div></li>{/if}
					</ul>
				{/if}
			</li>
			
			<li {if $sMenuItemSelect=='restaurant'}class="active"{/if}>
				<a href="{router page='restaurant'}">{$aLang.blog_menu_collective}</a> {if $iCountTopicsCollectiveNew>0}+{$iCountTopicsCollectiveNew}{/if}
				{if $sMenuItemSelect=='restaurant'}
					<ul class="sub-menu" >											
						<li {if $sMenuSubItemSelect=='good'}class="active"{/if}><div><a href="{$sMenuSubBlogUrl}">{$aLang.blog_menu_collective_good}</a></div></li>
						{if $iCountTopicsBlogNew>0}<li {if $sMenuSubItemSelect=='new'}class="active"{/if}><div><a href="{$sMenuSubBlogUrl}new/">{$aLang.blog_menu_collective_new}</a> +{$iCountTopicsBlogNew}</div></li>{/if}
						<li {if $sMenuSubItemSelect=='bad'}class="active"{/if}><div><a href="{$sMenuSubBlogUrl}bad/">{$aLang.blog_menu_collective_bad}</a></div></li>
					</ul>
				{/if}
			</li>
			
			<li {if $sMenuItemSelect=='log'}class="active"{/if}>
				<a href="{router page='personal_blog'}">{$aLang.blog_menu_personal}</a> {if $iCountTopicsPersonalNew>0}+{$iCountTopicsPersonalNew}{/if}
				{if $sMenuItemSelect=='log'}
					<ul class="sub-menu" style="left: -50px;">											
						<li {if $sMenuSubItemSelect=='good'}class="active"{/if}><div><a href="{router page='personal_blog'}">{$aLang.blog_menu_personal_good}</a></div></li>
						{if $iCountTopicsPersonalNew>0}<li {if $sMenuSubItemSelect=='new'}class="active"{/if}><div><a href="{router page='personal_blog'}new/">{$aLang.blog_menu_personal_new}</a> +{$iCountTopicsPersonalNew}</div></li>{/if}
						<li {if $sMenuSubItemSelect=='bad'}class="active"{/if}><div><a href="{router page='personal_blog'}bad/">{$aLang.blog_menu_personal_bad}</a></div></li>
					</ul>
				{/if}
			</li>
			
			<li {if $sMenuItemSelect=='top'}class="active"{/if}>
				<a href="{router page='top'}">{$aLang.blog_menu_top}</a>
				{if $sMenuItemSelect=='top'}
					<ul class="sub-menu" style="left: -80px;">											
						<li {if $sMenuSubItemSelect=='blog'}class="active"{/if}><div><a href="{router page='top'}blog/">{$aLang.blog_menu_top_blog}</a></div></li>
						<li {if $sMenuSubItemSelect=='topic'}class="active"{/if}><div><a href="{router page='top'}topic/">{$aLang.blog_menu_top_topic}</a></div></li>
						<li {if $sMenuSubItemSelect=='comment'}class="active"{/if}><div><a href="{router page='top'}comment/">{$aLang.blog_menu_top_comment}</a></div></li>
					</ul>
				{/if}
			</li>
			{hook run='menu_blog'}
		</ul>
		
		
		{hook run='menu_blog'} 


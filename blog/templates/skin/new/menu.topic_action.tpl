		<ul class="menu">
		
			<li {if $sMenuSubItemSelect=='add'}class="active"{/if}>
				<a href="{cfg name='path.root.web'}/{if $sMenuItemSelect=='add_blog'}topic{else}{$sMenuItemSelect}{/if}/add/">{$aLang.topic_menu_add}</a>
				{if $sMenuSubItemSelect=='add'}
					<ul class="sub-menu" >
						<li {if $sMenuItemSelect=='topic'}class="active"{/if}><div><a href="{router page='topic'}{$sMenuSubItemSelect}/">{$aLang.topic_menu_add_topic}</a></div></li>						
						<li {if $sMenuItemSelect=='question'}class="active"{/if}><div><a href="{router page='question'}{$sMenuSubItemSelect}/">{$aLang.topic_menu_add_question}</a></div></li>
						<li {if $sMenuItemSelect=='link'}class="active"{/if}><div><a href="{router page='link'}{$sMenuSubItemSelect}/">{$aLang.topic_menu_add_link}</a></div></li>
						<li ><div><a href="{router page='restaurant'}add/"><font color="Red">{$aLang.blog_menu_create}</font></a></div></li>
					</ul>
				{/if}
			</li>
			
			<li {if $sMenuSubItemSelect=='saved'}class="active"{/if}>
				<a href="{router page='topic'}saved/">{$aLang.topic_menu_saved}</a> 				
			</li>
			
			<li {if $sMenuSubItemSelect=='published'}class="active"{/if}>
				<a href="{router page='topic'}published/">{$aLang.topic_menu_published}</a>			
			</li>		
			{hook run='menu_topic_action'}
		</ul>
		
		
		


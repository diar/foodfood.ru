	<!-- Navigation -->
	
	<div id="nav">
		<div class="left"></div>
		{if $oUserCurrent and ($sAction=='restaurant' or $sAction=='index' or $sAction=='new' or $sAction=='personal_blog')}
			<div class="write">
				<a href="{router page='topic'}add/" alt="{$aLang.topic_create}" title="{$aLang.topic_create}" class="button small">
					<span><em>{$aLang.topic_create}</em></span>
				</a>
			</div>
		{/if}
		
		{if $menu}
			{if in_array($menu,$aMenuContainers)}{$aMenuFetch.$menu}{else}{include file=menu.$menu.tpl}{/if}
		{/if}
	
				
		<div class="right"></div>
		<!--<a href="#" class="rss" onclick="return false;"></a>-->
	</div>
	<!-- /Navigation -->
	<div style="float: left;">
	{literal}
		<script type="text/javascript"><!--  
		document.write(VK.Share.button(false,{type: "round", text: {/literal}"{$aLang.sbookmarks_vkontant}"{literal}})); 
		--></script>
	{/literal}
	</div>
	<div style="float: left; padding-left: 5px;">
		<iframe src="http://www.facebook.com/plugins/like.php?href={$oTopic->getUrl()}&layout=button_count&show_faces=false&width=100&action=like&font=arial&colorscheme=light&height=20" scrolling="no"
		 frameborder="0" style="border:none; overflow:hidden; width:100px; height:20px;" allowTransparency="true"></iframe>  
	</div>
	<div style="float: left; padding-left: 5px;" >
		<a class="mrc__share" type="button_count" href="http://connect.mail.ru/share?share_url={$oTopic->getUrl()}">{$aLang.sbookmarks_vmojmir}</a><script src="http://cdn.connect.mail.ru/js/share/2/share.js" type="text/javascript"></script> 
	</div>
	<div style="float: left;padding-left: 5px; ">
	{literal}
		<script type="text/javascript">
		tweetmeme_style = 'compact';
		</script>
		<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>
	{/literal}
	</div>
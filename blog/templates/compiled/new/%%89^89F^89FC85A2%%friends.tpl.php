<?php /* Smarty version 2.6.19, created on 2010-06-04 19:35:22
         compiled from actions/ActionTalk/friends.tpl */ ?>
			<div class="block blogs">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
					<h1><?php echo $this->_tpl_vars['aLang']['block_friends']; ?>
</h1>
					
				<?php if ($this->_tpl_vars['aUsersFriend']): ?>
					<div class="block-content">
					<?php echo '
						<script language="JavaScript" type="text/javascript">
						function friendToogle(element) {
							login=element.getNext(\'a\').get(\'text\');
							to=$(\'talk_users\')
								.getProperty(\'value\')
									.split(\',\')
										.map(function(item,index){
											return item.trim();
										}).filter(function(item,index){
											return item.length>0;
										});
							$(\'talk_users\').setProperty(
								\'value\', 
								(element.getProperty(\'checked\'))
									? to.include(login).join(\',\')
									: to.erase(login).join(\',\')
							);							
						}
						window.addEvent(\'domready\', function() { 
							// сканируем список друзей      
							var lsCheckList=$(\'friends\')
												.getElements(\'input[type=checkbox]\')
													.addEvents({
														\'click\': function(){
															return friendToogle(this);
														}
													});
							// toogle checkbox`а при клике на ссылку-логин
							$(\'friends\').getElements(\'a\').addEvents({
								\'click\': function() {
									checkbox=this.getPrevious(\'input[type=checkbox]\');
									checkbox.setProperty(\'checked\',!checkbox.getProperty(\'checked\'));
									friendToogle(checkbox);
									return false;
								}
							});
							// выделить всех друзей
							$(\'friend_check_all\').addEvents({
								\'click\': function(){
									lsCheckList.each(function(item,index){
										if(!item.getProperty(\'checked\')) {
											item.setProperty(\'checked\',true);
											friendToogle(item);
										}
									});
									return false;
								}
							});
							// снять выделение со всех друзей
							$(\'friend_uncheck_all\').addEvents({
								\'click\': function(){
									lsCheckList.each(function(item,index){
										if(item.getProperty(\'checked\')) {
											item.setProperty(\'checked\',false);
											friendToogle(item);
										}
									});
									return false;
								}
							});							
						});
						</script>
					'; ?>

					
						<ul class="list" id="friends">
							<?php $_from = $this->_tpl_vars['aUsersFriend']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oFriend']):
?>
								<li><input type="checkbox" name="friend[<?php echo $this->_tpl_vars['oFriend']->getId(); ?>
]"/> <a href="#" class="stream-author"><?php echo $this->_tpl_vars['oFriend']->getLogin(); ?>
</a></li>						
							<?php endforeach; endif; unset($_from); ?>
						</ul>
					</div>
					<div class="right"><a href="#" id="friend_check_all"><?php echo $this->_tpl_vars['aLang']['block_friends_check']; ?>
</a> | <a href="#" id="friend_uncheck_all"><?php echo $this->_tpl_vars['aLang']['block_friends_uncheck']; ?>
</a></div>

				<?php else: ?>
					<?php echo $this->_tpl_vars['aLang']['block_friends_empty']; ?>

				<?php endif; ?>
					
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
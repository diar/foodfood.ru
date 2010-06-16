<?php /* Smarty version 2.6.19, created on 2010-06-04 19:34:55
         compiled from actions/ActionTalk/blacklist.tpl */ ?>
			<div class="block blogs">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
					<h1><?php echo $this->_tpl_vars['aLang']['talk_blacklist_title']; ?>
</h1>
				<?php echo '
						<script language="JavaScript" type="text/javascript">
						document.addEvent(\'domready\', function() {	
							new Autocompleter.Request.HTML(
								$(\'talk_blacklist_add\'),
								 DIR_WEB_ROOT+\'/include/ajax/userAutocompleter.php?security_ls_key=\'+LIVESTREET_SECURITY_KEY, 
								 {
									\'indicatorClass\': \'autocompleter-loading\',
									\'minLength\': 1,
									\'selectMode\': \'pick\',
									\'multiple\': true
								}
							);
						});						
						
						function deleteFromBlackList(element) {
							element.getParent(\'li\').fade(0.7);							
							idTarget = element.get(\'id\').replace(\'blacklist_item_\',\'\');
		
			                JsHttpRequest.query(
			                        \'POST \'+aRouter[\'talk\']+\'ajaxdeletefromblacklist/\',			                        
			                        { idTarget: idTarget, security_ls_key: LIVESTREET_SECURITY_KEY },
			                        function(result, errors) {     
			                            if (!result) {
							                msgErrorBox.alert(\'Error\',\'Please try again later\');
							                element.getParent().fade(1);           
							        	}    
							        	if (result.bStateError) {
							                msgErrorBox.alert(result.sMsgTitle,result.sMsg);
							                element.getParent().fade(1);
							        	} else {
							                element.getParent(\'li\').destroy();
							                
							                if($(\'blackList\').getElements(\'li\').length==0) {
							                	$(\'blackList\').destroy();
							                	$(\'list_uncheck_all\').setProperty(\'style\',\'display:none\');
							                }
							        	}                                 
			                        },
			                        true
			                ); 
										                
							return true;
						}
						function addListItem(sId,sLogin) {
							if($(\'blackListBlock\').getElements(\'li\').length==0) {
								$(\'list_uncheck_all\').removeProperty(\'style\');
								list=new Element(\'ul\', {\'class\':\'list\',id:\'blackList\'});
								$(\'blackListBlock\').adopt(list);
							}
							
							oSpan=new Element(\'span\',
								{
									\'class\'  : \'user\',
									\'text\'   : sLogin
								}
							);
							oLink=new Element(\'a\',
								{
									\'id\'    : \'blacklist_item_\'+sId,
									\'href\'  : "#",
									\'class\' : \'delete\',
									\'events\': {
										\'click\': function() {
											deleteFromBlackList(this); 
											return false;
										}
									}
								}
							);
							oItem=new Element(\'li\');
							$(\'blackList\').adopt(oItem.adopt(oSpan,oLink));
						}
						function addToBlackList() {
							sUsers=$(\'talk_blacklist_add\').get(\'value\');
							if(sUsers.length<2) {
								msgErrorBox.alert(\'Error\',\'Пользователь не указан\');
								return false;
							}
							$(\'talk_blacklist_add\').set(\'value\',\'\');
			                JsHttpRequest.query(
			                       \'POST \'+aRouter[\'talk\']+\'ajaxaddtoblacklist/\',                      
			                        { users: sUsers, security_ls_key: LIVESTREET_SECURITY_KEY },
			                        function(result, errors) {     
			                            if (!result) {
							                msgErrorBox.alert(\'Error\',\'Please try again later\');         
							        	}    
							        	if (result.bStateError) {
							                msgErrorBox.alert(result.sMsgTitle,result.sMsg);
							        	} else {
							        		var aUsers = result.aUsers;
							        		aUsers.each(function(item,index) { 
							        			if(item.bStateError){
							        				msgErrorBox.alert(item.sMsgTitle, item.sMsg);
							        			} else {
							                		addListItem(item.sUserId,item.sUserLogin);
							        			}
							        		});
							        	}                                 
			                        },
			                        true
			                ); 							
							return false;
						}
						</script>
					'; ?>


					<div class="block-content">
						<form onsubmit="addToBlackList(); return false;">
							<p><label for="talk_blacklist_add"><?php echo $this->_tpl_vars['aLang']['talk_balcklist_add_label']; ?>
:</label><br />
							<input type="text" id="talk_blacklist_add" name="add" value="" class="w100p" /><br />
							</p>										
						</form>
					</div>
				
				<div class="block-content" id="blackListBlock">						
				<?php if ($this->_tpl_vars['aUsersBlacklist']): ?>
					<?php echo '
						<script>
						window.addEvent(\'domready\', function() { 
							$(\'list_uncheck_all\').addEvents({
								\'click\': function(){
									$(\'blackList\').getElements(\'a\').each(function(item,index){
										deleteFromBlackList(item);
									});
									return false;
								}
							});							
						});
						</script>						
					'; ?>

					<ul class="list" id="blackList">
						<?php $_from = $this->_tpl_vars['aUsersBlacklist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oUser']):
?>
							<li><span class="user"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</span><a href="#" id="blacklist_item_<?php echo $this->_tpl_vars['oUser']->getId(); ?>
" onclick="deleteFromBlackList(this); return false;" class="delete"></a></li>						
						<?php endforeach; endif; unset($_from); ?>
					</ul>
				<?php endif; ?>
				</div>
				<div class="right"><a href="#" id="list_uncheck_all" <?php if (! $this->_tpl_vars['aUsersBlacklist']): ?>style="display:none;"<?php endif; ?>><?php echo $this->_tpl_vars['aLang']['talk_balcklist_delete_all']; ?>
</a></div>
					
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
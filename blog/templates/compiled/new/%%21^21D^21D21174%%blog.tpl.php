<?php /* Smarty version 2.6.19, created on 2010-05-26 20:35:39
         compiled from actions/ActionBlog/blog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'actions/ActionBlog/blog.tpl', 47, false),array('modifier', 'nl2br', 'actions/ActionBlog/blog.tpl', 86, false),array('function', 'router', 'actions/ActionBlog/blog.tpl', 49, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'blog')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('oUserOwner', $this->_tpl_vars['oBlog']->getOwner()); ?>
<?php $this->assign('oVote', $this->_tpl_vars['oBlog']->getVote()); ?>

<?php echo '
<script language="JavaScript" type="text/javascript">
function toggleBlogInfo(id,link) {
	link=$(link);
	var obj=$(id);	
	var slideObj = new Fx.Slide(obj);
	if (obj.getStyle(\'display\')==\'none\') {
		slideObj.hide();
		obj.setStyle(\'display\',\'block\');		
	}	
	link.toggleClass(\'inactive\');
	slideObj.toggle();
}

function toggleBlogDeleteForm(id,link) {
	link=$(link);
	var obj=$(id);	
	var slideObj = new Fx.Slide(obj);
	if (obj.getStyle(\'display\')==\'none\') {
		slideObj.hide();
		obj.setStyle(\'display\',\'block\');
	}	
	link.toggleClass(\'inactive\');
	slideObj.toggle();
	
}
</script>
'; ?>


			<div class="profile-blog">							
				<div class="voting <?php if ($this->_tpl_vars['oBlog']->getRating() >= 0): ?>positive<?php else: ?>negative<?php endif; ?> <?php if (! $this->_tpl_vars['oUserCurrent'] || $this->_tpl_vars['oBlog']->getOwnerId() == $this->_tpl_vars['oUserCurrent']->getId()): ?>guest<?php endif; ?> <?php if ($this->_tpl_vars['oVote']): ?> voted <?php if ($this->_tpl_vars['oVote']->getDirection() > 0): ?>plus<?php elseif ($this->_tpl_vars['oVote']->getDirection() < 0): ?>minus<?php endif; ?><?php endif; ?>">
					<div class="clear"><?php echo $this->_tpl_vars['aLang']['blog_rating']; ?>
</div>
					
					<a href="#" class="plus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
,this,1,'blog'); return false;"></a>
					<div class="total"><?php if ($this->_tpl_vars['oBlog']->getRating() > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['oBlog']->getRating(); ?>
</div>
					<a href="#" class="minus" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
,this,-1,'blog'); return false;"></a>
					
					<div class="clear"></div>
					<div class="text"><?php echo $this->_tpl_vars['aLang']['blog_vote_count']; ?>
:</div><div class="count"><?php echo $this->_tpl_vars['oBlog']->getCountVote(); ?>
</div>
				</div>

				<img src="<?php echo $this->_tpl_vars['oBlog']->getAvatarPath(24); ?>
" alt="avatar" class="avatar" />
				<h1 class="title"><a href="#" class="title-link" onclick="toggleBlogInfo('blog_about_<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
',this); return false;"><span><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span><strong>&nbsp;&nbsp;</strong></a></h1>
				<ul class="action">
					<li class="rss"><a href="<?php echo smarty_function_router(array('page' => 'rss'), $this);?>
blog/<?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/"></a></li>					
					<?php if ($this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->getId() != $this->_tpl_vars['oBlog']->getOwnerId()): ?>
						<li class="join <?php if ($this->_tpl_vars['oBlog']->getUserIsJoin()): ?>active<?php endif; ?>">
							<a href="#" onclick="ajaxJoinLeaveBlog(this,<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
); return false;"></a>
						</li>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->getId() == $this->_tpl_vars['oBlog']->getOwnerId() || $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() )): ?>
  						<li class="edit"><a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
edit/<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['blog_edit']; ?>
"><?php echo $this->_tpl_vars['aLang']['blog_edit']; ?>
</a></li>
 						<?php if ($this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>
							<li class="delete">
								<a href="#" title="<?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
" onclick="toggleBlogDeleteForm('blog_delete_form',this); return false;"><?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
</a> 
								<form id="blog_delete_form" class="hidden" action="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
delete/<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
/" method="POST">
									<input type="hidden" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" name="security_ls_key" /> 
									<?php echo $this->_tpl_vars['aLang']['blog_admin_delete_move']; ?>
:<br /> 
									<select name="topic_move_to">
										<option value="-1"><?php echo $this->_tpl_vars['aLang']['blog_delete_clear']; ?>
</option>
										<?php if ($this->_tpl_vars['aBlogs']): ?> 
											<option disabled="disabled">-------------</option>
											<?php $_from = $this->_tpl_vars['aBlogs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogDelete']):
?>
												<option value="<?php echo $this->_tpl_vars['oBlogDelete']->getId(); ?>
"><?php echo $this->_tpl_vars['oBlogDelete']->getTitle(); ?>
</option>											
											<?php endforeach; endif; unset($_from); ?>
										<?php endif; ?>
									</select>
									<input type="submit" value="<?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
" />
								</form></li>						
						<?php else: ?> 						
  							<li class="delete"><a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
delete/<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" title="<?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['aLang']['blog_admin_delete_confirm']; ?>
');" ><?php echo $this->_tpl_vars['aLang']['blog_delete']; ?>
</a></li>
  						<?php endif; ?>
  					<?php endif; ?>
				</ul>
				<div class="about" id="blog_about_<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
" style="display: none;" >
					<div class="tl"><div class="tr"></div></div>

					<div class="content">
					
						<h1><?php echo $this->_tpl_vars['aLang']['blog_about']; ?>
</h1>
						<p>
						<?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getDescription())) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

						</p>					
						
						<div class="line"></div>
						
						<div class="admins">
							<h1><?php echo $this->_tpl_vars['aLang']['blog_user_administrators']; ?>
 (<?php echo $this->_tpl_vars['iCountBlogAdministrators']; ?>
)</h1>							
							
							<ul class="admin-list">				
								<li>
									<dl>
										<dt>
											<a href="<?php echo $this->_tpl_vars['oUserOwner']->getUserWebPath(); ?>
"><img src="<?php echo $this->_tpl_vars['oUserOwner']->getProfileAvatarPath(48); ?>
" alt=""  title="<?php echo $this->_tpl_vars['oUserOwner']->getLogin(); ?>
"/></a>
										</dt>
										<dd>
											<a href="<?php echo $this->_tpl_vars['oUserOwner']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUserOwner']->getLogin(); ?>
</a>
										</dd>
									</dl>
								</li>
								<?php if ($this->_tpl_vars['aBlogAdministrators']): ?>			
 								<?php $_from = $this->_tpl_vars['aBlogAdministrators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
?>
 								<?php $this->assign('oUser', $this->_tpl_vars['oBlogUser']->getUser()); ?>  									
								<li>
									<dl>
										<dt>
											<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><img src="<?php echo $this->_tpl_vars['oUser']->getProfileAvatarPath(48); ?>
" alt=""  title="<?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
"/></a>
										</dt>
										<dd>
											<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>
										</dd>
									</dl>
								</li>
								<?php endforeach; endif; unset($_from); ?>	
								<?php endif; ?>						
							</ul>
							
						</div>

						
						<div class="moderators">
							<h1><?php echo $this->_tpl_vars['aLang']['blog_user_moderators']; ?>
 (<?php echo $this->_tpl_vars['iCountBlogModerators']; ?>
)</h1>
							<?php if ($this->_tpl_vars['aBlogModerators']): ?>
							<ul class="admin-list">							
 								<?php $_from = $this->_tpl_vars['aBlogModerators']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
?>  
 								<?php $this->assign('oUser', $this->_tpl_vars['oBlogUser']->getUser()); ?>									
								<li>
									<dl>
										<dt>
											<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><img src="<?php echo $this->_tpl_vars['oUser']->getProfileAvatarPath(48); ?>
" alt="" title="<?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
" /></a>
										</dt>
										<dd>
											<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>
										</dd>
									</dl>
								</li>
								<?php endforeach; endif; unset($_from); ?>							
							</ul>
							<?php else: ?>
   	 							<?php echo $this->_tpl_vars['aLang']['blog_user_moderators_empty']; ?>

							<?php endif; ?>
						</div>
						
						<h1 class="readers"><?php echo $this->_tpl_vars['aLang']['blog_user_readers']; ?>
 (<?php echo $this->_tpl_vars['iCountBlogUsers']; ?>
)</h1>
						<?php if ($this->_tpl_vars['aBlogUsers']): ?>
						<ul class="reader-list">
							<?php $_from = $this->_tpl_vars['aBlogUsers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlogUser']):
?>
							<?php $this->assign('oUser', $this->_tpl_vars['oBlogUser']->getUser()); ?>
								<li><a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a></li>
							<?php endforeach; endif; unset($_from); ?>
						</ul>
						<?php else: ?>
   	 						<?php echo $this->_tpl_vars['aLang']['blog_user_readers_empty']; ?>

    					<?php endif; ?>
					</div>
					<div class="bl"><div class="br"></div></div>
				</div>				
			</div>


<?php if ($this->_tpl_vars['bCloseBlog']): ?>
	<div class="topic">
		<?php echo $this->_tpl_vars['aLang']['blog_close_show']; ?>

	</div>
<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_list.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

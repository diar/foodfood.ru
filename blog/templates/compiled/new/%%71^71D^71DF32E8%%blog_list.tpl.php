<?php /* Smarty version 2.6.19, created on 2010-05-30 10:34:14
         compiled from blog_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'blog_list.tpl', 6, false),array('function', 'router', 'blog_list.tpl', 18, false),array('modifier', 'escape', 'blog_list.tpl', 19, false),)), $this); ?>
				<table>
					<thead>
						<tr>
							<td class="user"><?php echo $this->_tpl_vars['aLang']['blogs_title']; ?>
</td>
							<?php if ($this->_tpl_vars['oUserCurrent']): ?>
							<td class="join-head"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/join-head.gif" alt="" /></td>
							<?php endif; ?>
							<td class="readers"><?php echo $this->_tpl_vars['aLang']['blogs_readers']; ?>
</td>														
							<td class="rating"><?php echo $this->_tpl_vars['aLang']['blogs_rating']; ?>
</td>
						</tr>
					</thead>
					
					<tbody>
						<?php $_from = $this->_tpl_vars['aBlogs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlog']):
?>
						<?php $this->assign('oUserOwner', $this->_tpl_vars['oBlog']->getOwner()); ?>
						<tr>
							<td class="name">
								<a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
<?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/"><img src="<?php echo $this->_tpl_vars['oBlog']->getAvatarPath(24); ?>
" alt="" /></a>
								<a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
<?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/" class="title <?php if ($this->_tpl_vars['oBlog']->getType() == 'close'): ?>close<?php endif; ?>"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><br />
								<?php echo $this->_tpl_vars['aLang']['blogs_owner']; ?>
: <a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUserOwner']->getLogin(); ?>
/" class="author"><?php echo $this->_tpl_vars['oUserOwner']->getLogin(); ?>
</a>
							</td>
							<?php if ($this->_tpl_vars['oUserCurrent']): ?>
							<td class="join <?php if ($this->_tpl_vars['oBlog']->getUserIsJoin()): ?>active<?php endif; ?>">
								<?php if ($this->_tpl_vars['oUserCurrent']->getId() != $this->_tpl_vars['oBlog']->getOwnerId() && $this->_tpl_vars['oBlog']->getType() == 'open'): ?>
									<a href="#" onclick="ajaxJoinLeaveBlog(this,<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
); return false;"></a>
								<?php endif; ?>
							</td>
							<?php endif; ?>
							<td id="blog_user_count_<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
" class="readers"><?php echo $this->_tpl_vars['oBlog']->getCountUser(); ?>
</td>													
							<td class="rating"><strong><?php echo $this->_tpl_vars['oBlog']->getRating(); ?>
</strong></td>
						</tr>
						<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
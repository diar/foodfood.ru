<?php /* Smarty version 2.6.19, created on 2010-05-26 20:35:58
         compiled from menu.blog_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'menu.blog_edit.tpl', 5, false),array('function', 'hook', 'menu.blog_edit.tpl', 9, false),)), $this); ?>

		<ul class="menu">
			<li class="active"><font color="#333333"><?php echo $this->_tpl_vars['aLang']['blog_admin']; ?>
</font>
				<ul class="sub-menu">					
					<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'profile'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
edit/<?php echo $this->_tpl_vars['oBlogEdit']->getId(); ?>
/"><?php echo $this->_tpl_vars['aLang']['blog_admin_profile']; ?>
</a></div></li>
					<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'admin'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
admin/<?php echo $this->_tpl_vars['oBlogEdit']->getId(); ?>
/"><?php echo $this->_tpl_vars['aLang']['blog_admin_users']; ?>
</a></div></li>
				</ul>
			</li>
			<?php echo smarty_function_hook(array('run' => 'menu_blog_edit'), $this);?>

		</ul>
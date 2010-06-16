<?php /* Smarty version 2.6.19, created on 2010-05-26 20:32:26
         compiled from menu.blog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'menu.blog.tpl', 4, false),array('function', 'router', 'menu.blog.tpl', 8, false),array('function', 'hook', 'menu.blog.tpl', 45, false),)), $this); ?>
		<ul class="menu">
		
			<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'index'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/"><?php echo $this->_tpl_vars['aLang']['blog_menu_all']; ?>
</a> <?php if ($this->_tpl_vars['iCountTopicsNew'] > 0): ?>+<?php echo $this->_tpl_vars['iCountTopicsNew']; ?>
<?php endif; ?>
				<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'index'): ?>
					<ul class="sub-menu" >
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'good'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/"><?php echo $this->_tpl_vars['aLang']['blog_menu_all_good']; ?>
</a></div></li>						
						<?php if ($this->_tpl_vars['iCountTopicsNew'] > 0): ?><li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'new'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'new'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['blog_menu_all_new']; ?>
</a> +<?php echo $this->_tpl_vars['iCountTopicsNew']; ?>
</div></li><?php endif; ?>
					</ul>
				<?php endif; ?>
			</li>
			
			<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'restaurant'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'restaurant'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['blog_menu_collective']; ?>
</a> <?php if ($this->_tpl_vars['iCountTopicsCollectiveNew'] > 0): ?>+<?php echo $this->_tpl_vars['iCountTopicsCollectiveNew']; ?>
<?php endif; ?>
				<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'restaurant'): ?>
					<ul class="sub-menu" >											
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'good'): ?>class="active"<?php endif; ?>><div><a href="<?php echo $this->_tpl_vars['sMenuSubBlogUrl']; ?>
"><?php echo $this->_tpl_vars['aLang']['blog_menu_collective_good']; ?>
</a></div></li>
						<?php if ($this->_tpl_vars['iCountTopicsBlogNew'] > 0): ?><li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'new'): ?>class="active"<?php endif; ?>><div><a href="<?php echo $this->_tpl_vars['sMenuSubBlogUrl']; ?>
new/"><?php echo $this->_tpl_vars['aLang']['blog_menu_collective_new']; ?>
</a> +<?php echo $this->_tpl_vars['iCountTopicsBlogNew']; ?>
</div></li><?php endif; ?>
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'bad'): ?>class="active"<?php endif; ?>><div><a href="<?php echo $this->_tpl_vars['sMenuSubBlogUrl']; ?>
bad/"><?php echo $this->_tpl_vars['aLang']['blog_menu_collective_bad']; ?>
</a></div></li>
					</ul>
				<?php endif; ?>
			</li>
			
			<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'log'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'personal_blog'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['blog_menu_personal']; ?>
</a> <?php if ($this->_tpl_vars['iCountTopicsPersonalNew'] > 0): ?>+<?php echo $this->_tpl_vars['iCountTopicsPersonalNew']; ?>
<?php endif; ?>
				<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'log'): ?>
					<ul class="sub-menu" style="left: -50px;">											
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'good'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'personal_blog'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['blog_menu_personal_good']; ?>
</a></div></li>
						<?php if ($this->_tpl_vars['iCountTopicsPersonalNew'] > 0): ?><li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'new'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'personal_blog'), $this);?>
new/"><?php echo $this->_tpl_vars['aLang']['blog_menu_personal_new']; ?>
</a> +<?php echo $this->_tpl_vars['iCountTopicsPersonalNew']; ?>
</div></li><?php endif; ?>
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'bad'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'personal_blog'), $this);?>
bad/"><?php echo $this->_tpl_vars['aLang']['blog_menu_personal_bad']; ?>
</a></div></li>
					</ul>
				<?php endif; ?>
			</li>
			
			<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'top'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'top'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['blog_menu_top']; ?>
</a>
				<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'top'): ?>
					<ul class="sub-menu" style="left: -80px;">											
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'blog'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'top'), $this);?>
blog/"><?php echo $this->_tpl_vars['aLang']['blog_menu_top_blog']; ?>
</a></div></li>
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'topic'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'top'), $this);?>
topic/"><?php echo $this->_tpl_vars['aLang']['blog_menu_top_topic']; ?>
</a></div></li>
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'comment'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'top'), $this);?>
comment/"><?php echo $this->_tpl_vars['aLang']['blog_menu_top_comment']; ?>
</a></div></li>
					</ul>
				<?php endif; ?>
			</li>
			<?php echo smarty_function_hook(array('run' => 'menu_blog'), $this);?>

		</ul>
		
		
		

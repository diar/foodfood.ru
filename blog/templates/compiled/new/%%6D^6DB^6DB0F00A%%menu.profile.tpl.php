<?php /* Smarty version 2.6.19, created on 2010-05-26 20:39:31
         compiled from menu.profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'menu.profile.tpl', 4, false),array('function', 'hook', 'menu.profile.tpl', 24, false),)), $this); ?>
		<ul class="menu">
		
			<li <?php if ($this->_tpl_vars['sAction'] == 'profile'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/"><?php echo $this->_tpl_vars['aLang']['user_menu_profile']; ?>
</a>
				<?php if ($this->_tpl_vars['sAction'] == 'profile'): ?>
					<ul class="sub-menu" >
						<li <?php if ($this->_tpl_vars['aParams'][0] == 'whois' || $this->_tpl_vars['aParams'][0] == ''): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/"><?php echo $this->_tpl_vars['aLang']['user_menu_profile_whois']; ?>
</a></div></li>						
						<li <?php if ($this->_tpl_vars['aParams'][0] == 'favourites' && $this->_tpl_vars['aParams'][1] != 'comments'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/favourites/"><?php echo $this->_tpl_vars['aLang']['user_menu_profile_favourites']; ?>
</a><?php if ($this->_tpl_vars['iCountTopicFavourite']): ?> (<?php echo $this->_tpl_vars['iCountTopicFavourite']; ?>
)<?php endif; ?></div></li>	
						<li <?php if ($this->_tpl_vars['aParams'][1] == 'comments'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/favourites/comments/"><?php echo $this->_tpl_vars['aLang']['user_menu_profile_favourites_comments']; ?>
</a><?php if ($this->_tpl_vars['iCountCommentFavourite']): ?> (<?php echo $this->_tpl_vars['iCountCommentFavourite']; ?>
)<?php endif; ?></div></li>					
					</ul>
				<?php endif; ?>
			</li>
			
			
			<li <?php if ($this->_tpl_vars['sAction'] == 'my'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'my'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/"><?php echo $this->_tpl_vars['aLang']['user_menu_publication']; ?>
 <?php if (( $this->_tpl_vars['iCountCommentUser']+$this->_tpl_vars['iCountTopicUser'] ) > 0): ?> (<?php echo $this->_tpl_vars['iCountCommentUser']+$this->_tpl_vars['iCountTopicUser']; ?>
)<?php endif; ?></a>
				<?php if ($this->_tpl_vars['sAction'] == 'my'): ?>
					<ul class="sub-menu" >
						<li <?php if ($this->_tpl_vars['aParams'][0] == 'blog' || $this->_tpl_vars['aParams'][0] == ''): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'my'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/"><?php echo $this->_tpl_vars['aLang']['user_menu_publication_blog']; ?>
</a><?php if ($this->_tpl_vars['iCountTopicUser']): ?>(<?php echo $this->_tpl_vars['iCountTopicUser']; ?>
)<?php endif; ?></div></li>						
						<li <?php if ($this->_tpl_vars['aParams'][0] == 'comment'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'my'), $this);?>
<?php echo $this->_tpl_vars['oUserProfile']->getLogin(); ?>
/comment/"><?php echo $this->_tpl_vars['aLang']['user_menu_publication_comment']; ?>
</a><?php if ($this->_tpl_vars['iCountCommentUser']): ?>(<?php echo $this->_tpl_vars['iCountCommentUser']; ?>
)<?php endif; ?></div></li>
					</ul>
				<?php endif; ?>
			</li>
			<?php echo smarty_function_hook(array('run' => 'menu_profile'), $this);?>

		</ul>
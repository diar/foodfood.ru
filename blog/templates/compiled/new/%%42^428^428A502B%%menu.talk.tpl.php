<?php /* Smarty version 2.6.19, created on 2010-06-04 19:34:55
         compiled from menu.talk.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'menu.talk.tpl', 5, false),array('function', 'hook', 'menu.talk.tpl', 10, false),)), $this); ?>

		<ul class="menu">
			<li class="active"><font color="#333333"><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox']; ?>
</font>
				<ul class="sub-menu">					
					<li <?php if ($this->_tpl_vars['sEvent'] == 'inbox'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox_list']; ?>
</a></div></li>
					<li <?php if ($this->_tpl_vars['sEvent'] == 'add'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
add/"><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox_create']; ?>
</a></div></li>
					<li <?php if ($this->_tpl_vars['sEvent'] == 'favourites'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
favourites/"><?php echo $this->_tpl_vars['aLang']['talk_menu_inbox_favourites']; ?>
</a><?php if ($this->_tpl_vars['iCountTalkFavourite']): ?> (<?php echo $this->_tpl_vars['iCountTalkFavourite']; ?>
)<?php endif; ?></div></li>
				</ul>
			</li>
			<?php echo smarty_function_hook(array('run' => 'menu_talk'), $this);?>

		</ul>
<?php /* Smarty version 2.6.19, created on 2010-06-16 20:45:13
         compiled from header_nav.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'header_nav.tpl', 7, false),)), $this); ?>
	<!-- Navigation -->
	
	<div id="nav">
		<div class="left"></div>
		<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['sAction'] == 'restaurant' || $this->_tpl_vars['sAction'] == 'index' || $this->_tpl_vars['sAction'] == 'new' || $this->_tpl_vars['sAction'] == 'personal_blog' )): ?>
			<div class="write">
				<a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
add/" alt="<?php echo $this->_tpl_vars['aLang']['topic_create']; ?>
" title="<?php echo $this->_tpl_vars['aLang']['topic_create']; ?>
" class="button small">
					<span><em><?php echo $this->_tpl_vars['aLang']['topic_create']; ?>
</em></span>
				</a>
			</div>
		<?php endif; ?>
		
		<?php if ($this->_tpl_vars['menu']): ?>
			<?php if (in_array ( $this->_tpl_vars['menu'] , $this->_tpl_vars['aMenuContainers'] )): ?><?php echo $this->_tpl_vars['aMenuFetch'][$this->_tpl_vars['menu']]; ?>
<?php else: ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.".($this->_tpl_vars['menu']).".tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
		<?php endif; ?>
	
				
		<div class="right"></div>
		<!--<a href="#" class="rss" onclick="return false;"></a>-->
	</div>
	<!-- /Navigation -->
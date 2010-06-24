<?php /* Smarty version 2.6.19, created on 2010-06-18 06:03:27
         compiled from actions/ActionError/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'actions/ActionError/index.tpl', 8, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.light.tpl', 'smarty_include_vars' => array('noShowSystemMessage' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<div class="lite-center error">
		<?php if ($this->_tpl_vars['aMsgError'][0]['title']): ?>
			<h1><?php echo $this->_tpl_vars['aLang']['error']; ?>
: <?php echo $this->_tpl_vars['aMsgError'][0]['title']; ?>
</h1>
		<?php endif; ?>
		<p><?php echo $this->_tpl_vars['aMsgError'][0]['msg']; ?>
</p>
		<p><a href="javascript:history.go(-1);"><?php echo $this->_tpl_vars['aLang']['site_history_back']; ?>
</a>, <a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['site_go_main']; ?>
</a></p>
	</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
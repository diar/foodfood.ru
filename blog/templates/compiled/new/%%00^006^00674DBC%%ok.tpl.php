<?php /* Smarty version 2.6.19, created on 2010-06-19 01:32:22
         compiled from actions/ActionRegistration/ok.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'actions/ActionRegistration/ok.tpl', 5, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<div class="lite-center">
		<h3><?php echo $this->_tpl_vars['aLang']['registration_ok']; ?>
</h3>
		<a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['site_go_main']; ?>
</a>
	</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
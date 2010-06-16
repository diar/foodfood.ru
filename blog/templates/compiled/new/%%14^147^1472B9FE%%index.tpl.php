<?php /* Smarty version 2.6.19, created on 2010-06-04 20:25:54
         compiled from actions/ActionSearch/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionSearch/index.tpl', 4, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('showWhiteBack' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h1><?php echo $this->_tpl_vars['aLang']['search']; ?>
</h1>
<form action="<?php echo smarty_function_router(array('page' => 'search'), $this);?>
topics/" method="GET">
	<p>
		<input type="text" value="" name="q" class="w300">
		<input type="submit" value="<?php echo $this->_tpl_vars['aLang']['search_submit']; ?>
">
	</p>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php /* Smarty version 2.6.19, created on 2010-06-02 09:04:12
         compiled from actions/ActionLogin/reminder.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionLogin/reminder.tpl', 4, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<div class="lite-center">
		<form action="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
reminder/" method="POST">
				<h3><?php echo $this->_tpl_vars['aLang']['password_reminder']; ?>
</h3>
				<div class="lite-note"><label for="mail"><?php echo $this->_tpl_vars['aLang']['password_reminder_email']; ?>
:</label></div>
				<p><input type="text" class="input-text" name="mail" id="name"/></p>				
				<input type="submit" name="submit_reminder" value="<?php echo $this->_tpl_vars['aLang']['password_reminder_submit']; ?>
" />
		</form>
	</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
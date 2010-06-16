<?php /* Smarty version 2.6.19, created on 2010-05-31 16:08:33
         compiled from actions/ActionLogin/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionLogin/index.tpl', 9, false),array('function', 'hook', 'actions/ActionLogin/index.tpl', 11, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<div class="lite-center">
	
		<?php if ($this->_tpl_vars['bLoginError']): ?>
			<p><span class=""><?php echo $this->_tpl_vars['aLang']['user_login_bad']; ?>
</span><br />
		<?php endif; ?>

		<form action="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
" method="POST">
				<h3><?php echo $this->_tpl_vars['aLang']['user_authorization']; ?>
</h3>
				<?php echo smarty_function_hook(array('run' => 'form_login_begin'), $this);?>

				<div class="lite-note"><a href="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['user_registration']; ?>
</a><label for="login-input"><?php echo $this->_tpl_vars['aLang']['user_login']; ?>
</label></div>
				<p><input type="text" class="input-text" name="login" tabindex="1" id="login-input"/></p>
				<div class="lite-note"><a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
reminder/" tabindex="-1"><?php echo $this->_tpl_vars['aLang']['user_password_reminder']; ?>
</a><label for="password-input"><?php echo $this->_tpl_vars['aLang']['user_password']; ?>
</label></div>
				<p><input type="password" name="password" class="input-text" tabindex="2" id="password-input"/></p>
				<?php echo smarty_function_hook(array('run' => 'form_login_end'), $this);?>

				<div class="lite-note">
					<button type="submit" class="button"><span><em><?php echo $this->_tpl_vars['aLang']['user_login_submit']; ?>
</em></span></button>
					<label for="" class="input-checkbox"><input type="checkbox" name="remember" checked tabindex="3" ><?php echo $this->_tpl_vars['aLang']['user_login_remember']; ?>
</label>
				</div>
				<input type="hidden" name="submit_login">
		</form>
		
		<?php if ($this->_tpl_vars['oConfig']->GetValue('general.reg.invite')): ?> 	
			<br><br>		
			<form action="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
invite/" method="POST">
				<h3><?php echo $this->_tpl_vars['aLang']['registration_invite']; ?>
</h3>
				<div class="lite-note"><label for="invite_code"><?php echo $this->_tpl_vars['aLang']['registration_invite_code']; ?>
:</label></div>
				<p><input type="text" class="input-text" name="invite_code" id="invite_code"/></p>				
				<input type="submit" name="submit_invite" value="<?php echo $this->_tpl_vars['aLang']['registration_invite_check']; ?>
">
			</form>
		<?php endif; ?>
	</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
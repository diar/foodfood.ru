<?php /* Smarty version 2.6.19, created on 2010-06-04 12:03:32
         compiled from actions/ActionRegistration/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionRegistration/index.tpl', 5, false),array('function', 'hook', 'actions/ActionRegistration/index.tpl', 7, false),array('function', 'cfg', 'actions/ActionRegistration/index.tpl', 28, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


	<div class="lite-center register">
		<form action="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
" method="POST">
			<h3><?php echo $this->_tpl_vars['aLang']['registration']; ?>
</h3>
			<?php echo smarty_function_hook(array('run' => 'form_registration_begin'), $this);?>

			<label for="login"><?php echo $this->_tpl_vars['aLang']['registration_login']; ?>
:</label><br />
			<p><input type="text" class="input-text" name="login" id="login" value="<?php echo $this->_tpl_vars['_aRequest']['login']; ?>
"/>
			<span class="input-note"><?php echo $this->_tpl_vars['aLang']['registration_login_notice']; ?>
</span></p>

                        <label for="phone"><?php echo $this->_tpl_vars['aLang']['registration_phone']; ?>
:</label><br />
			<p><input type="text" class="input-text" id="phone" value="<?php echo $this->_tpl_vars['_aRequest']['phone']; ?>
" name="phone"/><br />
			<span class="input-note"><?php echo $this->_tpl_vars['aLang']['registration_phone_notice']; ?>
</span></p>

			<label for="email"><?php echo $this->_tpl_vars['aLang']['registration_mail']; ?>
:</label><br />
			<p><input type="text" class="input-text" id="email" name="mail" value="<?php echo $this->_tpl_vars['_aRequest']['mail']; ?>
"/>
			<span class="input-note"><?php echo $this->_tpl_vars['aLang']['registration_mail_notice']; ?>
</span></p><br />
			
			<label for="pass"><?php echo $this->_tpl_vars['aLang']['registration_password']; ?>
:</label><br />
			<p><input type="password" class="input-text" id="pass" value="" name="password"/><br />
			<span class="input-note"><?php echo $this->_tpl_vars['aLang']['registration_password_notice']; ?>
</span></p>
			
			<label for="repass"><?php echo $this->_tpl_vars['aLang']['registration_password_retry']; ?>
:</label><br />
			<p><input type="password" class="input-text"  value="" id="repass" name="password_confirm"/></p><br />

			<?php echo $this->_tpl_vars['aLang']['registration_captcha']; ?>
:<br />
			<img src="<?php echo smarty_function_cfg(array('name' => 'path.root.engine_lib'), $this);?>
/external/kcaptcha/index.php?<?php echo $this->_tpl_vars['_sPhpSessionName']; ?>
=<?php echo $this->_tpl_vars['_sPhpSessionId']; ?>
"  onclick="this.src='<?php echo smarty_function_cfg(array('name' => 'path.root.engine_lib'), $this);?>
/external/kcaptcha/index.php?<?php echo $this->_tpl_vars['_sPhpSessionName']; ?>
=<?php echo $this->_tpl_vars['_sPhpSessionId']; ?>
&n='+Math.random();">
			<p><input type="text" class="input-text" style="width: 80px;" name="captcha" value="" maxlength=3 /></p>
			<?php echo smarty_function_hook(array('run' => 'form_registration_end'), $this);?>

			<div class="lite-note">
				<button type="submit" name="submit_register" class="button" style="float: none;"><span><em><?php echo $this->_tpl_vars['aLang']['registration_submit']; ?>
</em></span></button>
			</div>		
		</form>
	</div>
<br><br><br>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.light.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
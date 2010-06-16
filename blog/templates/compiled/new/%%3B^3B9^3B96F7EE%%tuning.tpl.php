<?php /* Smarty version 2.6.19, created on 2010-05-28 20:46:02
         compiled from actions/ActionSettings/tuning.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionSettings/tuning.tpl', 5, false),array('function', 'hook', 'actions/ActionSettings/tuning.tpl', 6, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'settings','showWhiteBack' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<h1><?php echo $this->_tpl_vars['aLang']['settings_tuning']; ?>
</h1>
			<strong><?php echo $this->_tpl_vars['aLang']['settings_tuning_notice']; ?>
</strong>
			<form action="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
tuning/" method="POST" enctype="multipart/form-data">
				<?php echo smarty_function_hook(array('run' => 'form_settings_tuning_begin'), $this);?>

				<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /> 
				<p>
					<label for=""><input <?php if ($this->_tpl_vars['oUserCurrent']->getSettingsNoticeNewTopic()): ?>checked<?php endif; ?>  type="checkbox" id="settings_notice_new_topic" name="settings_notice_new_topic" value="1" class="checkbox" /> &mdash; <?php echo $this->_tpl_vars['aLang']['settings_tuning_notice_new_topic']; ?>
</label><br />
					<label for=""><input <?php if ($this->_tpl_vars['oUserCurrent']->getSettingsNoticeNewComment()): ?>checked<?php endif; ?> type="checkbox"   id="settings_notice_new_comment" name="settings_notice_new_comment" value="1" class="checkbox" /> &mdash; <?php echo $this->_tpl_vars['aLang']['settings_tuning_notice_new_comment']; ?>
</label><br />
					<label for=""><input <?php if ($this->_tpl_vars['oUserCurrent']->getSettingsNoticeNewTalk()): ?>checked<?php endif; ?> type="checkbox" id="settings_notice_new_talk" name="settings_notice_new_talk" value="1" class="checkbox" /> &mdash; <?php echo $this->_tpl_vars['aLang']['settings_tuning_notice_new_talk']; ?>
</label><br />
					<label for=""><input <?php if ($this->_tpl_vars['oUserCurrent']->getSettingsNoticeReplyComment()): ?>checked<?php endif; ?> type="checkbox" id="settings_notice_reply_comment" name="settings_notice_reply_comment" value="1" class="checkbox" /> &mdash; <?php echo $this->_tpl_vars['aLang']['settings_tuning_notice_reply_comment']; ?>
</label><br />
					<label for=""><input <?php if ($this->_tpl_vars['oUserCurrent']->getSettingsNoticeNewFriend()): ?>checked<?php endif; ?> type="checkbox" id="settings_notice_new_friend" name="settings_notice_new_friend" value="1" class="checkbox" /> &mdash; <?php echo $this->_tpl_vars['aLang']['settings_tuning_notice_new_friend']; ?>
</label>
				</p>
				<p><input type="submit" name="submit_settings_tuning" value="<?php echo $this->_tpl_vars['aLang']['settings_tuning_submit']; ?>
" /></p>
				<?php echo smarty_function_hook(array('run' => 'form_settings_tuning_end'), $this);?>

			</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
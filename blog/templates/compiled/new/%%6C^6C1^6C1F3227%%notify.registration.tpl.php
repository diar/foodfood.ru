<?php /* Smarty version 2.6.19, created on 2010-06-19 01:32:21
         compiled from notify/russian/notify.registration.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'notify/russian/notify.registration.tpl', 1, false),)), $this); ?>
Вы зарегистрировались на сайте <a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
"><?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
</a><br>
Ваши регистрационные данные:<br>
&nbsp;&nbsp;&nbsp;логин: <b><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</b><br>
&nbsp;&nbsp;&nbsp;пароль: <b><?php echo $this->_tpl_vars['sPassword']; ?>
</b><br>						
<br><br>
С уважением, администрация сайта <a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
"><?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
</a>
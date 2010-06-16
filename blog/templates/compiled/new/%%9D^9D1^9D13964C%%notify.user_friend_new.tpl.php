<?php /* Smarty version 2.6.19, created on 2010-06-15 12:18:10
         compiled from notify/russian/notify.user_friend_new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'notify/russian/notify.user_friend_new.tpl', 1, false),array('function', 'cfg', 'notify/russian/notify.user_friend_new.tpl', 6, false),)), $this); ?>
Пользователь «<a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUserFrom']->getLogin(); ?>
/"><?php echo $this->_tpl_vars['oUserFrom']->getLogin(); ?>
</a>»</b> хочет добавить вас в друзья.						
<br /><br />
<i><?php echo $this->_tpl_vars['sText']; ?>
</i>
<a href='<?php echo $this->_tpl_vars['sPath']; ?>
'>Посмотреть заявку</a> (Не забудьте предварительно авторизоваться!)
<br />
С уважением, администрация сайта <a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
"><?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
</a>
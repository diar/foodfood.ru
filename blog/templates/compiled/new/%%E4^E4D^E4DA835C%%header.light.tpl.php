<?php /* Smarty version 2.6.19, created on 2010-07-02 17:21:23
         compiled from header.light.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'header.light.tpl', 9, false),array('function', 'hook', 'header.light.tpl', 18, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
	<title><?php echo $this->_tpl_vars['sHtmlTitle']; ?>
</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/css/style.css?v=1" />	
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/css/ie6.css?v=1" /><![endif]-->
	<!--[if gte IE 7]><link rel="stylesheet" type="text/css" href="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/css/ie7.css?v=1" /><![endif]-->
	<?php if ($this->_tpl_vars['bRefreshToHome']): ?>
		<meta  HTTP-EQUIV="Refresh" CONTENT="3; URL=<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/">
	<?php endif; ?>
</head>

<body>
<?php echo smarty_function_hook(array('run' => 'body_begin'), $this);?>

<div id="container">
	<h1 class="lite-header"><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
">Food<span>Food</span></a></h1>
	
	<?php if (! $this->_tpl_vars['noShowSystemMessage']): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'system_message.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
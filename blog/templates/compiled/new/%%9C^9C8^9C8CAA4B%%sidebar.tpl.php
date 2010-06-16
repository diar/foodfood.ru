<?php /* Smarty version 2.6.19, created on 2010-05-26 20:32:26
         compiled from sidebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'block', 'sidebar.tpl', 7, false),)), $this); ?>
		<!-- Sidebar -->
		<div id="sidebar">
			
			<?php if (isset ( $this->_tpl_vars['aBlocks']['right'] )): ?>
				<?php $_from = $this->_tpl_vars['aBlocks']['right']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aBlock']):
?>
					<?php if ($this->_tpl_vars['aBlock']['type'] == 'block'): ?>
						<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'block', 'block' => ($this->_tpl_vars['aBlock']['name']), 'params' => ($this->_tpl_vars['aBlock']['params']))), $this); ?>
 
					<?php endif; ?>
					<?php if ($this->_tpl_vars['aBlock']['type'] == 'template'): ?>						 
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['aBlock']['name']), 'smarty_include_vars' => array('params' => ($this->_tpl_vars['aBlock']['params']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<?php endif; ?>	
				<?php endforeach; endif; unset($_from); ?>			
			<?php endif; ?>		
			
		</div>
		<!-- /Sidebar -->
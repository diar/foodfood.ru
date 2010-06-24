<?php /* Smarty version 2.6.19, created on 2010-06-16 20:45:13
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'footer.tpl', 15, false),)), $this); ?>
		</div>
		<!-- /Content -->
		<?php if (! $this->_tpl_vars['bNoSidebar']): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'sidebar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
		
	</div>

	<!-- Footer -->
	<div id="footer">
		
	<!-- /Footer -->

</div>
<?php echo smarty_function_hook(array('run' => 'body_end'), $this);?>

</body>
</html>
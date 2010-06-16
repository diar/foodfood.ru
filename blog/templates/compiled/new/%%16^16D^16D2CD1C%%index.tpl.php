<?php /* Smarty version 2.6.19, created on 2010-05-27 23:08:47
         compiled from actions/ActionTag/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'actions/ActionTag/index.tpl', 14, false),array('modifier', 'escape', 'actions/ActionTag/index.tpl', 15, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'blog')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script>
function submitTags(sTag) {		
	window.location=DIR_WEB_ROOT+\'/tag/\'+sTag+\'/\';
	return false;
}
</script>
'; ?>


	&nbsp;&nbsp;
	<form action="" method="GET" onsubmit="return submitTags(this.tag.value);">
		<img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/tagcloud.gif" border="0" style="margin-left: 13px;">&nbsp;
		<input type="text" name="tag" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['sTag'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" class="tags-input" >
	</form>

<br>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_list.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
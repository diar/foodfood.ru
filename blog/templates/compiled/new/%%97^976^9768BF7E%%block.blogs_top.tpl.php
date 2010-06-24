<?php /* Smarty version 2.6.19, created on 2010-06-16 23:20:21
         compiled from block.blogs_top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'block.blogs_top.tpl', 3, false),array('modifier', 'escape', 'block.blogs_top.tpl', 3, false),)), $this); ?>
<ul class="list">
	<?php $_from = $this->_tpl_vars['aBlogs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlog']):
?>
		<li><div class="total"><?php echo $this->_tpl_vars['oBlog']->getRating(); ?>
</div><a href="<?php echo smarty_function_router(array('page' => 'restaurant'), $this);?>
<?php echo $this->_tpl_vars['oBlog']->getUrl(); ?>
/" class="stream-author <?php if ($this->_tpl_vars['oBlog']->getType() == 'close'): ?>close<?php endif; ?>"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></li>
	<?php endforeach; endif; unset($_from); ?>
</ul>				
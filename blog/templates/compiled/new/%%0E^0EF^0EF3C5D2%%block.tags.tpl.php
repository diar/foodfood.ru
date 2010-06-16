<?php /* Smarty version 2.6.19, created on 2010-05-26 20:32:26
         compiled from block.tags.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'block.tags.tpl', 7, false),array('modifier', 'escape', 'block.tags.tpl', 7, false),)), $this); ?>
			<div class="block tags">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
					<ul class="cloud">						
						<?php $_from = $this->_tpl_vars['aTags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oTag']):
?>
							<li><a class="w<?php echo $this->_tpl_vars['oTag']->getSize(); ?>
" rel="tag" href="<?php echo smarty_function_router(array('page' => 'tag'), $this);?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['oTag']->getText())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTag']->getText())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></li>	
						<?php endforeach; endif; unset($_from); ?>
					</ul>
					
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
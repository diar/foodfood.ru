<?php /* Smarty version 2.6.19, created on 2010-05-27 19:22:46
         compiled from block.tagsCountry.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'block.tagsCountry.tpl', 8, false),array('modifier', 'escape', 'block.tagsCountry.tpl', 8, false),)), $this); ?>
		<?php if ($this->_tpl_vars['aCountryList'] && count ( $this->_tpl_vars['aCountryList'] ) > 0): ?>
			<div class="block white tags">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">					
					<h1><?php echo $this->_tpl_vars['aLang']['block_country_tags']; ?>
</h1>					
					<ul class="cloud">
						<?php $_from = $this->_tpl_vars['aCountryList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aCountry']):
?>
							<li><a class="w<?php echo $this->_tpl_vars['aCountry']['size']; ?>
" rel="tag" href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
country/<?php echo ((is_array($_tmp=$this->_tpl_vars['aCountry']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['aCountry']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a></li>	
						<?php endforeach; endif; unset($_from); ?>					
					</ul>									
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
		<?php endif; ?>
<?php /* Smarty version 2.6.19, created on 2010-07-02 17:18:36
         compiled from block.blogs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'block.blogs.tpl', 27, false),)), $this); ?>
			<div class="block blogs">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
					<h1><?php echo $this->_tpl_vars['aLang']['block_blogs']; ?>
</h1>
					
					<ul class="block-nav">
						<li class="active"><strong></strong><a href="#" id="block_blogs_top" onclick="lsBlockBlogs.toggle(this,'blogs_top'); return false;"><?php echo $this->_tpl_vars['aLang']['block_blogs_top']; ?>
</a><?php if (! $this->_tpl_vars['oUserCurrent']): ?><em></em><?php endif; ?></li>
						<?php if ($this->_tpl_vars['oUserCurrent']): ?>
							<li><a href="#" id="block_blogs_join" onclick="lsBlockBlogs.toggle(this,'blogs_join'); return false;"><?php echo $this->_tpl_vars['aLang']['block_blogs_join']; ?>
</a></li>
							<li><a href="#" id="block_blogs_self" onclick="lsBlockBlogs.toggle(this,'blogs_self'); return false;"><?php echo $this->_tpl_vars['aLang']['block_blogs_self']; ?>
</a><em></em></li>
						<?php endif; ?>
					</ul>
					
					<div class="block-content">
					<?php echo '
						<script language="JavaScript" type="text/javascript">
						var lsBlockBlogs;
						window.addEvent(\'domready\', function() {       
							lsBlockBlogs=new lsBlockLoaderClass();
						});
						</script>
					'; ?>

					<?php echo $this->_tpl_vars['sBlogsTop']; ?>

					</div>
					
					<div class="right"><a href="<?php echo smarty_function_router(array('page' => 'blogs'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['block_blogs_all']; ?>
</a></div>

					
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
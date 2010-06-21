<?php /* Smarty version 2.6.19, created on 2010-06-18 06:19:32
         compiled from comment_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'comment_list.tpl', 9, false),array('function', 'date_format', 'comment_list.tpl', 31, false),)), $this); ?>
	<?php $_from = $this->_tpl_vars['aComments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oComment']):
?>
	
		<?php $this->assign('oUser', $this->_tpl_vars['oComment']->getUser()); ?>
		<?php $this->assign('oTopic', $this->_tpl_vars['oComment']->getTarget()); ?>
		<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
		
				<div class="comments padding-none">
					<div class="comment">
						<div class="comment-topic"><a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a> / <a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
" class="comment-blog"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a> <a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comments" class="comment-total"><?php echo $this->_tpl_vars['oTopic']->getCountComment(); ?>
</a></div>				
						<div class="voting <?php if ($this->_tpl_vars['oComment']->getRating() > 0): ?>positive<?php elseif ($this->_tpl_vars['oComment']->getRating() < 0): ?>negative<?php endif; ?>">
							<div class="total"><?php if ($this->_tpl_vars['oComment']->getRating() > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['oComment']->getRating(); ?>
</div>
						</div>										
						<div class="content">
							<div class="tb"><div class="tl"><div class="tr"></div></div></div>							
							<div class="text">
								<?php if ($this->_tpl_vars['oComment']->isBad()): ?>
					        		<div style="display: none;" id="comment_text_<?php echo $this->_tpl_vars['oComment']->getId(); ?>
">
					        		<?php echo $this->_tpl_vars['oComment']->getText(); ?>

					        		</div>
					         		<a href="#" onclick="$('comment_text_<?php echo $this->_tpl_vars['oComment']->getId(); ?>
').setStyle('display','block');$(this).setStyle('display','none');return false;"><?php echo $this->_tpl_vars['aLang']['comment_bad_open']; ?>
</a>
					        	<?php else: ?>	
					        		<?php echo $this->_tpl_vars['oComment']->getText(); ?>

					        	<?php endif; ?>
							</div>			
							<div class="bl"><div class="bb"><div class="br"></div></div></div>
						</div>						
						<div class="info">
							<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><img src="<?php echo $this->_tpl_vars['oUser']->getProfileAvatarPath(24); ?>
" alt="avatar" class="avatar" /></a>
							<p><a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="author"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a></p>
							<ul>
								<li class="date"><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oComment']->getDate()), $this);?>
</li>								
								<li><a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comment<?php echo $this->_tpl_vars['oComment']->getId(); ?>
" class="imglink link"></a></li>  									
   								<?php if ($this->_tpl_vars['oUserCurrent']): ?>
									<li class="favorite <?php if ($this->_tpl_vars['oComment']->getIsFavourite()): ?>active<?php endif; ?>"><a href="#" onclick="lsFavourite.toggle(<?php echo $this->_tpl_vars['oComment']->getId(); ?>
,this,'comment'); return false;"></a></li>	
								<?php endif; ?>	
							</ul>
							
						</div>
					</div>
				</div>
	<?php endforeach; endif; unset($_from); ?>	
	
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array('aPaging' => ($this->_tpl_vars['aPaging']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
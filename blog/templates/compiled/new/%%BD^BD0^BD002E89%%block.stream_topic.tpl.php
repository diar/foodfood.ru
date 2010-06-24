<?php /* Smarty version 2.6.19, created on 2010-06-19 08:25:44
         compiled from block.stream_topic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'block.stream_topic.tpl', 8, false),array('function', 'router', 'block.stream_topic.tpl', 14, false),)), $this); ?>
					<ul class="stream-content">
						<?php $_from = $this->_tpl_vars['oTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cmt'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cmt']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oTopic']):
        $this->_foreach['cmt']['iteration']++;
?>
							<?php $this->assign('oUser', $this->_tpl_vars['oTopic']->getUser()); ?>							
							<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
							
							<li <?php if ($this->_foreach['cmt']['iteration'] % 2 == 1): ?>class="even"<?php endif; ?>>
								<a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
" class="stream-author"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a>&nbsp;&#8594;
								<span class="stream-topic-icon"></span><a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
" class="stream-topic"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
								<span><?php echo $this->_tpl_vars['oTopic']->getCountComment(); ?>
</span> в <a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
" class="stream-blog"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
							</li>						
						<?php endforeach; endif; unset($_from); ?>				
					</ul>

					<div class="right"><a href="<?php echo smarty_function_router(array('page' => 'new'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['block_stream_topics_all']; ?>
</a> | <a href="<?php echo smarty_function_router(array('page' => 'rss'), $this);?>
new/">RSS</a></div>
					
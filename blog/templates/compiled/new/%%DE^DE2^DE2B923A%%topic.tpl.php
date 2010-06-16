<?php /* Smarty version 2.6.19, created on 2010-05-26 20:51:08
         compiled from actions/ActionBlog/topic.tpl */ ?>
<?php if ($this->_tpl_vars['oUserCurrent']): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'blog','showUpdateButton' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'blog')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>			
			
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'comment_tree.tpl', 'smarty_include_vars' => array('iTargetId' => $this->_tpl_vars['oTopic']->getId(),'sTargetType' => 'topic','iCountComment' => $this->_tpl_vars['oTopic']->getCountComment(),'sDateReadLast' => $this->_tpl_vars['oTopic']->getDateRead(),'bAllowNewComment' => $this->_tpl_vars['oTopic']->getForbidComment(),'sNoticeNotAllow' => $this->_tpl_vars['aLang']['topic_comment_notallow'],'sNoticeCommentAdd' => $this->_tpl_vars['aLang']['topic_comment_add'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
	
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
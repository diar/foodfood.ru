<?php /* Smarty version 2.6.19, created on 2010-06-16 23:20:21
         compiled from topic_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'topic_list.tpl', 13, false),array('function', 'router', 'topic_list.tpl', 15, false),array('function', 'date_format', 'topic_list.tpl', 74, false),array('modifier', 'escape', 'topic_list.tpl', 15, false),)), $this); ?>
<?php if (count ( $this->_tpl_vars['aTopics'] ) > 0): ?>	
	<?php $_from = $this->_tpl_vars['aTopics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oTopic']):
?>   
			<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?> 
			<?php $this->assign('oUser', $this->_tpl_vars['oTopic']->getUser()); ?> 
			<?php $this->assign('oVote', $this->_tpl_vars['oTopic']->getVote()); ?> 
			<!-- Topic -->			
			<div class="topic">
				
				<div class="favorite <?php if ($this->_tpl_vars['oUserCurrent']): ?><?php if ($this->_tpl_vars['oTopic']->getIsFavourite()): ?>active<?php endif; ?><?php else: ?>fav-guest<?php endif; ?>"><a href="#" onclick="lsFavourite.toggle(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,'topic'); return false;"></a></div>
				
				<h1 class="title">		
					<?php if ($this->_tpl_vars['oTopic']->getPublish() == 0): ?>	
						<img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/topic_unpublish.gif" border="0" title="<?php echo $this->_tpl_vars['aLang']['topic_unpublish']; ?>
" width="16" height="16" alt="<?php echo $this->_tpl_vars['aLang']['topic_unpublish']; ?>
">
					<?php endif; ?>			
					<a href="<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?><?php echo smarty_function_router(array('page' => 'link'), $this);?>
go/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/<?php else: ?><?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
<?php endif; ?>"><?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>
					<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?>
  						<img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/link_url_big.gif" border="0" title="<?php echo $this->_tpl_vars['aLang']['topic_link']; ?>
" width="16" height="16" alt="<?php echo $this->_tpl_vars['aLang']['topic_link']; ?>
">
  					<?php endif; ?>
				</h1>
				<ul class="action">
					<li><a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>&nbsp;&nbsp;</li>										
					<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->getId() == $this->_tpl_vars['oTopic']->getUserId() || $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() || $this->_tpl_vars['oBlog']->getUserIsModerator() || $this->_tpl_vars['oBlog']->getOwnerId() == $this->_tpl_vars['oUserCurrent']->getId() )): ?>
  						<li class="edit"><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/<?php echo $this->_tpl_vars['oTopic']->getType(); ?>
/edit/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['topic_edit']; ?>
"><?php echo $this->_tpl_vars['aLang']['topic_edit']; ?>
</a></li>
  					<?php endif; ?>
					<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() || $this->_tpl_vars['oBlog']->getOwnerId() == $this->_tpl_vars['oUserCurrent']->getId() )): ?>
							<li class="delete"><a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
delete/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" title="<?php echo $this->_tpl_vars['aLang']['topic_delete']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['aLang']['topic_delete_confirm']; ?>
');"><?php echo $this->_tpl_vars['aLang']['topic_delete']; ?>
</a></li>
					<?php endif; ?>
				</ul>				
				<div class="content">
				
			<?php if ($this->_tpl_vars['oTopic']->getType() == 'question'): ?>   
    		
    		<div id="topic_question_area_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
">
    		<?php if (! $this->_tpl_vars['oTopic']->getUserQuestionIsVote()): ?> 		
    			<ul class="poll-new">	
				<?php $_from = $this->_tpl_vars['oTopic']->getQuestionAnswers(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aAnswer']):
?>				
					<li><label for="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_<?php echo $this->_tpl_vars['key']; ?>
"><input type="radio" id="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_<?php echo $this->_tpl_vars['key']; ?>
" name="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
"  value="<?php echo $this->_tpl_vars['key']; ?>
" onchange="$('topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value').setProperty('value',this.value);"/> <?php echo ((is_array($_tmp=$this->_tpl_vars['aAnswer']['text'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</label></li>				
				<?php endforeach; endif; unset($_from); ?>
					<li>
					<input type="submit"  value="<?php echo $this->_tpl_vars['aLang']['topic_question_vote']; ?>
" onclick="ajaxQuestionVote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,$('topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value').getProperty('value'));">
					<input type="submit"  value="<?php echo $this->_tpl_vars['aLang']['topic_question_abstain']; ?>
"  onclick="ajaxQuestionVote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,-1)">
					</li>				
					<input type="hidden" id="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value" value="-1">				
				</ul>				
				<span><?php echo $this->_tpl_vars['aLang']['topic_question_vote_result']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getQuestionCountVote(); ?>
. <?php echo $this->_tpl_vars['aLang']['topic_question_abstain_result']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getQuestionCountVoteAbstain(); ?>
</span><br>			
			<?php else: ?>			
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_question.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
			</div>
			<br>	
						
    		<?php endif; ?>
				
					<?php echo $this->_tpl_vars['oTopic']->getTextShort(); ?>

					<?php if ($this->_tpl_vars['oTopic']->getTextShort() != $this->_tpl_vars['oTopic']->getText()): ?>
      					<br><br>( <a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
" title="<?php echo $this->_tpl_vars['aLang']['topic_read_more']; ?>
">
      					<?php if ($this->_tpl_vars['oTopic']->getCutText()): ?>
      						<?php echo $this->_tpl_vars['oTopic']->getCutText(); ?>

      					<?php else: ?>
      						<?php echo $this->_tpl_vars['aLang']['topic_read_more']; ?>

      					<?php endif; ?>      			
      					</a> )
      				<?php endif; ?>
				</div>				
				<ul class="tags">
					<?php $_from = $this->_tpl_vars['oTopic']->getTagsArray(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tags_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tags_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sTag']):
        $this->_foreach['tags_list']['iteration']++;
?>
						<li><a href="<?php echo smarty_function_router(array('page' => 'tag'), $this);?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['sTag'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['sTag'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['tags_list']['iteration'] == $this->_foreach['tags_list']['total'])): ?>, <?php endif; ?></li>
					<?php endforeach; endif; unset($_from); ?>								
				</ul>				
				<ul class="voting <?php if ($this->_tpl_vars['oVote'] || ( $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() ) || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?><?php if ($this->_tpl_vars['oTopic']->getRating() > 0): ?>positive<?php elseif ($this->_tpl_vars['oTopic']->getRating() < 0): ?>negative<?php endif; ?><?php endif; ?> <?php if (! $this->_tpl_vars['oUserCurrent'] || $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?>guest<?php endif; ?> <?php if ($this->_tpl_vars['oVote']): ?> voted <?php if ($this->_tpl_vars['oVote']->getDirection() > 0): ?>plus<?php elseif ($this->_tpl_vars['oVote']->getDirection() < 0): ?>minus<?php endif; ?><?php endif; ?>">
					<li class="plus"><a href="#" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,1,'topic'); return false;"></a></li>
					<li class="total" title="<?php echo $this->_tpl_vars['aLang']['topic_vote_count']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getCountVote(); ?>
"><?php if ($this->_tpl_vars['oVote'] || ( $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() ) || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?> <?php if ($this->_tpl_vars['oTopic']->getRating() > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['oTopic']->getRating(); ?>
 <?php else: ?> <a href="#" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,0,'topic'); return false;">&mdash;</a> <?php endif; ?></li>
					<li class="minus"><a href="#" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,-1,'topic'); return false;"></a></li>
					<li class="date"><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oTopic']->getDateAdd()), $this);?>
</li>
					<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?>
						<li class="link"><a href="<?php echo smarty_function_router(array('page' => 'link'), $this);?>
go/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['topic_link_count_jump']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getLinkCountJump(); ?>
"><?php echo $this->_tpl_vars['oTopic']->getLinkUrl(true); ?>
</a></li>
					<?php endif; ?>
					<li class="author"><a href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a></li>		
					<li class="comments-total">
						<?php if ($this->_tpl_vars['oTopic']->getCountComment() > 0): ?>
							<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comments" title="<?php echo $this->_tpl_vars['aLang']['topic_comment_read']; ?>
"><span class="red"><?php echo $this->_tpl_vars['oTopic']->getCountComment(); ?>
</span><?php if ($this->_tpl_vars['oTopic']->getCountCommentNew()): ?><span class="green">+<?php echo $this->_tpl_vars['oTopic']->getCountCommentNew(); ?>
</span><?php endif; ?></a>
						<?php else: ?>
							<a href="<?php echo $this->_tpl_vars['oTopic']->getUrl(); ?>
#comments" title="<?php echo $this->_tpl_vars['aLang']['topic_comment_add']; ?>
"><span class="red"><?php echo $this->_tpl_vars['aLang']['topic_comment_add']; ?>
</span></a>
						<?php endif; ?>
					</li>
				</ul>
			</div>
			<!-- /Topic -->
	<?php endforeach; endif; unset($_from); ?>	
		
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array('aPaging' => ($this->_tpl_vars['aPaging']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>			
	
<?php else: ?>
<?php echo $this->_tpl_vars['aLang']['blog_no_topic']; ?>

<?php endif; ?>
<?php /* Smarty version 2.6.19, created on 2010-05-26 20:51:08
         compiled from comment_tree.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'comment_tree.tpl', 1, false),array('function', 'router', 'comment_tree.tpl', 24, false),array('function', 'hook', 'comment_tree.tpl', 89, false),)), $this); ?>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/js/comments.js"></script>

			<!-- Comments -->
			<div class="comments">
				<?php if ($this->_tpl_vars['oUserCurrent']): ?>
				<div class="update" id="update">
					<div class="tl"></div>
					<div class="wrapper">
						<div class="refresh">
							<img class="update-comments" id="update-comments" alt="" src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/update.gif" onclick="lsCmtTree.responseNewComment(<?php echo $this->_tpl_vars['iTargetId']; ?>
,'<?php echo $this->_tpl_vars['sTargetType']; ?>
',this); return false;"/>
						</div>
						<div class="new-comments" id="new-comments" style="display: none;" onclick="lsCmtTree.goNextComment();">							
						</div>
					</div>
					<div class="bl"></div>
				</div>
				<?php endif; ?>
				
				<!-- Comments Header -->
				<div class="header">
					<h3><?php echo $this->_tpl_vars['aLang']['comment_title']; ?>
 (<span id="count-comments"><?php echo $this->_tpl_vars['iCountComment']; ?>
</span>)</h3>
					<a name="comments" ></a>
					<?php if ($this->_tpl_vars['sTargetType'] == 'topic'): ?>
					<a href="<?php echo smarty_function_router(array('page' => 'rss'), $this);?>
comments/<?php echo $this->_tpl_vars['iTargetId']; ?>
/" class="rss">RSS</a>
					<?php endif; ?>
					<a href="#" onclick="lsCmtTree.collapseNodeAll(); return false;" onfocus="blur();"><?php echo $this->_tpl_vars['aLang']['comment_collapse']; ?>
</a> /
					<a href="#" onclick="lsCmtTree.expandNodeAll(); return false;" onfocus="blur();"><?php echo $this->_tpl_vars['aLang']['comment_expand']; ?>
</a>
				</div>
				<!-- /Comments Header -->			
				
				<?php echo '
				<script language="JavaScript" type="text/javascript">
					window.addEvent(\'domready\', function() {
						'; ?>

						lsCmtTree.setIdCommentLast(<?php echo $this->_tpl_vars['iMaxIdComment']; ?>
);
						<?php echo '
					});					
				</script>
				'; ?>

				
				<?php $this->assign('nesting', "-1"); ?>
				<?php $_from = $this->_tpl_vars['aComments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rublist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rublist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['oComment']):
        $this->_foreach['rublist']['iteration']++;
?>
					<?php $this->assign('cmtlevel', $this->_tpl_vars['oComment']->getLevel()); ?>
					<?php if ($this->_tpl_vars['cmtlevel'] > $this->_tpl_vars['oConfig']->GetValue('module.comment.max_tree')): ?>
						<?php $this->assign('cmtlevel', $this->_tpl_vars['oConfig']->GetValue('module.comment.max_tree')); ?>
					<?php endif; ?>
   					<?php if ($this->_tpl_vars['nesting'] < $this->_tpl_vars['cmtlevel']): ?>        
    				<?php elseif ($this->_tpl_vars['nesting'] > $this->_tpl_vars['cmtlevel']): ?>    	
        				<?php unset($this->_sections['closelist1']);
$this->_sections['closelist1']['name'] = 'closelist1';
$this->_sections['closelist1']['loop'] = is_array($_loop=($this->_tpl_vars['nesting']-$this->_tpl_vars['cmtlevel']+1)) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['closelist1']['show'] = true;
$this->_sections['closelist1']['max'] = $this->_sections['closelist1']['loop'];
$this->_sections['closelist1']['step'] = 1;
$this->_sections['closelist1']['start'] = $this->_sections['closelist1']['step'] > 0 ? 0 : $this->_sections['closelist1']['loop']-1;
if ($this->_sections['closelist1']['show']) {
    $this->_sections['closelist1']['total'] = $this->_sections['closelist1']['loop'];
    if ($this->_sections['closelist1']['total'] == 0)
        $this->_sections['closelist1']['show'] = false;
} else
    $this->_sections['closelist1']['total'] = 0;
if ($this->_sections['closelist1']['show']):

            for ($this->_sections['closelist1']['index'] = $this->_sections['closelist1']['start'], $this->_sections['closelist1']['iteration'] = 1;
                 $this->_sections['closelist1']['iteration'] <= $this->_sections['closelist1']['total'];
                 $this->_sections['closelist1']['index'] += $this->_sections['closelist1']['step'], $this->_sections['closelist1']['iteration']++):
$this->_sections['closelist1']['rownum'] = $this->_sections['closelist1']['iteration'];
$this->_sections['closelist1']['index_prev'] = $this->_sections['closelist1']['index'] - $this->_sections['closelist1']['step'];
$this->_sections['closelist1']['index_next'] = $this->_sections['closelist1']['index'] + $this->_sections['closelist1']['step'];
$this->_sections['closelist1']['first']      = ($this->_sections['closelist1']['iteration'] == 1);
$this->_sections['closelist1']['last']       = ($this->_sections['closelist1']['iteration'] == $this->_sections['closelist1']['total']);
?></div></div><?php endfor; endif; ?>
    				<?php elseif (! ($this->_foreach['rublist']['iteration'] <= 1)): ?>
        				</div></div>
    				<?php endif; ?>
    				
    				
    				 
    				<div class="comment" id="comment_id_<?php echo $this->_tpl_vars['oComment']->getId(); ?>
">
    				    				
    					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'comment.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>      												
							  
    				<?php $this->assign('nesting', $this->_tpl_vars['cmtlevel']); ?>    
    				<?php if (($this->_foreach['rublist']['iteration'] == $this->_foreach['rublist']['total'])): ?>
        				<?php unset($this->_sections['closelist2']);
$this->_sections['closelist2']['name'] = 'closelist2';
$this->_sections['closelist2']['loop'] = is_array($_loop=($this->_tpl_vars['nesting']+1)) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['closelist2']['show'] = true;
$this->_sections['closelist2']['max'] = $this->_sections['closelist2']['loop'];
$this->_sections['closelist2']['step'] = 1;
$this->_sections['closelist2']['start'] = $this->_sections['closelist2']['step'] > 0 ? 0 : $this->_sections['closelist2']['loop']-1;
if ($this->_sections['closelist2']['show']) {
    $this->_sections['closelist2']['total'] = $this->_sections['closelist2']['loop'];
    if ($this->_sections['closelist2']['total'] == 0)
        $this->_sections['closelist2']['show'] = false;
} else
    $this->_sections['closelist2']['total'] = 0;
if ($this->_sections['closelist2']['show']):

            for ($this->_sections['closelist2']['index'] = $this->_sections['closelist2']['start'], $this->_sections['closelist2']['iteration'] = 1;
                 $this->_sections['closelist2']['iteration'] <= $this->_sections['closelist2']['total'];
                 $this->_sections['closelist2']['index'] += $this->_sections['closelist2']['step'], $this->_sections['closelist2']['iteration']++):
$this->_sections['closelist2']['rownum'] = $this->_sections['closelist2']['iteration'];
$this->_sections['closelist2']['index_prev'] = $this->_sections['closelist2']['index'] - $this->_sections['closelist2']['step'];
$this->_sections['closelist2']['index_next'] = $this->_sections['closelist2']['index'] + $this->_sections['closelist2']['step'];
$this->_sections['closelist2']['first']      = ($this->_sections['closelist2']['iteration'] == 1);
$this->_sections['closelist2']['last']       = ($this->_sections['closelist2']['iteration'] == $this->_sections['closelist2']['total']);
?></div></div><?php endfor; endif; ?>    
    				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
				
				<span id="comment-children-0"></span>				
				<br>
				
				<?php if ($this->_tpl_vars['bAllowNewComment']): ?>
					<?php echo $this->_tpl_vars['sNoticeNotAllow']; ?>

				<?php else: ?>
					<?php if ($this->_tpl_vars['oUserCurrent']): ?>
						<h3 class="reply-title"><a href="javascript:lsCmtTree.toggleCommentForm(0);"><?php echo $this->_tpl_vars['sNoticeCommentAdd']; ?>
</a></h3>						
						<div class="comment"><div class="content"><div class="text" id="comment_preview_0" style="display: none;"></div></div></div>
						<div style="display: block;" id="reply_0" class="reply">						
						<?php if (! $this->_tpl_vars['oConfig']->GetValue('view.tinymce')): ?>
            					<div class="panel_form" style="background: #eaecea; margin-top: 2px;">       	 
	 								<a href="#" onclick="lsPanel.putTagAround('form_comment_text','b'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/bold_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_b']; ?>
"></a>
	 								<a href="#" onclick="lsPanel.putTagAround('form_comment_text','i'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/italic_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_i']; ?>
"></a>	 			
	 								<a href="#" onclick="lsPanel.putTagAround('form_comment_text','u'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/underline_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_u']; ?>
"></a>	 			
	 								<a href="#" onclick="lsPanel.putTagAround('form_comment_text','s'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/strikethrough.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_s']; ?>
"></a>	 			
	 								&nbsp;
	 								<a href="#" onclick="lsPanel.putTagUrl('form_comment_text','<?php echo $this->_tpl_vars['aLang']['panel_url_promt']; ?>
'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/link.gif" width="20" height="20"  title="<?php echo $this->_tpl_vars['aLang']['panel_url']; ?>
"></a>
	 								<a href="#" onclick="lsPanel.putQuote('form_comment_text'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/quote.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_quote']; ?>
"></a>
	 								<a href="#" onclick="lsPanel.putTagAround('form_comment_text','code'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/code.gif" width="30" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_code']; ?>
"></a>
	 							</div>
	 					<?php endif; ?>
						<form action="" method="POST" id="form_comment" onsubmit="return false;" enctype="multipart/form-data">
							<?php echo smarty_function_hook(array('run' => 'form_add_comment_begin'), $this);?>

    						<textarea name="comment_text" id="form_comment_text" style="width: 100%; height: 100px;"></textarea>
    						<?php echo smarty_function_hook(array('run' => 'form_add_comment_end'), $this);?>

    						<input type="submit" name="submit_preview" value="<?php echo $this->_tpl_vars['aLang']['comment_preview']; ?>
" onclick="lsCmtTree.preview($('form_comment_reply').getProperty('value')); return false;" />&nbsp;
    						<input type="submit" name="submit_comment" value="<?php echo $this->_tpl_vars['aLang']['comment_add']; ?>
" onclick="lsCmtTree.addComment('form_comment',<?php echo $this->_tpl_vars['iTargetId']; ?>
,'<?php echo $this->_tpl_vars['sTargetType']; ?>
'); return false;">    	
    						<input type="hidden" name="reply" value="" id="form_comment_reply">
    						<input type="hidden" name="cmt_target_id" value="<?php echo $this->_tpl_vars['iTargetId']; ?>
">
    					</form>
						</div>
					<?php else: ?>
						<?php echo $this->_tpl_vars['aLang']['comment_unregistered']; ?>
<br>
					<?php endif; ?>
				<?php endif; ?>				
			</div>
			<!-- /Comments -->
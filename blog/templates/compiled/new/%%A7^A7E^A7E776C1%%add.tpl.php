<?php /* Smarty version 2.6.19, created on 2010-05-26 20:38:05
         compiled from actions/ActionTopic/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'actions/ActionTopic/add.tpl', 19, false),array('function', 'hook', 'actions/ActionTopic/add.tpl', 67, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'topic_action','showWhiteBack' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php echo '
<script language="JavaScript" type="text/javascript">
document.addEvent(\'domready\', function() {	
	new Autocompleter.Request.HTML($(\'topic_tags\'), DIR_WEB_ROOT+\'/include/ajax/tagAutocompleter.php?security_ls_key=\'+LIVESTREET_SECURITY_KEY, {
		\'indicatorClass\': \'autocompleter-loading\', // class added to the input during request
		\'minLength\': 2, // We need at least 1 character
		\'selectMode\': \'pick\', // Instant completion
		\'multiple\': true // Tag support, by default comma separated
	}); 
});
</script>
'; ?>



<?php if ($this->_tpl_vars['oConfig']->GetValue('view.tinymce')): ?>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.engine_lib'), $this);?>
/external/tinymce_3.2.7/tiny_mce.js"></script>

<script type="text/javascript">
<?php echo '
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_buttons1 : "lshselect,bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo,|,lslink,unlink,lsvideo,lsimage,pagebreak,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : 0,
	theme_advanced_resizing_use_cookie : 0,
	theme_advanced_path : false,
	object_resizing : true,
	force_br_newlines : true,
    forced_root_block : \'\', // Needed for 3.x
    force_p_newlines : false,    
    plugins : "lseditor,safari,inlinepopups,media,pagebreak",
    convert_urls : false,
    extended_valid_elements : "embed[src|type|allowscriptaccess|allowfullscreen|width|height]",
    pagebreak_separator :"<cut>",
    language : TINYMCE_LANG
});
'; ?>

</script>

<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'window_load_img.tpl', 'smarty_include_vars' => array('sToLoad' => 'topic_text')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>


			

			<div class="topic" style="display: none;">
				<div class="content" id="text_preview"></div>
			</div>

			<div class="profile-user">
				<?php if ($this->_tpl_vars['sEvent'] == 'add'): ?>
					<h1><?php echo $this->_tpl_vars['aLang']['topic_topic_create']; ?>
</h1>
				<?php else: ?>
					<h1><?php echo $this->_tpl_vars['aLang']['topic_topic_edit']; ?>
</h1>
				<?php endif; ?>
				<form action="" method="POST" enctype="multipart/form-data">
					<?php echo smarty_function_hook(array('run' => 'form_add_topic_topic_begin'), $this);?>

					<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /> 
					
					<p><label for="blog_id"><?php echo $this->_tpl_vars['aLang']['topic_create_blog']; ?>
</label>
					<select name="blog_id" id="blog_id" onChange="ajaxBlogInfo(this.value);">
     					<option value="0"><?php echo $this->_tpl_vars['aLang']['topic_create_blog_personal']; ?>
</option>
     					<?php $_from = $this->_tpl_vars['aBlogsAllow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlog']):
?>
     						<option value="<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
" <?php if ($this->_tpl_vars['_aRequest']['blog_id'] == $this->_tpl_vars['oBlog']->getId()): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['oBlog']->getTitle(); ?>
</option>
     					<?php endforeach; endif; unset($_from); ?>     					
     				</select></p>
					
     				<script language="JavaScript" type="text/javascript">
     					ajaxBlogInfo($('blog_id').value);
     				</script>
					
					<p><label for="topic_title"><?php echo $this->_tpl_vars['aLang']['topic_create_title']; ?>
:</label><br />
					<input type="text" id="topic_title" name="topic_title" value="<?php echo $this->_tpl_vars['_aRequest']['topic_title']; ?>
" class="w100p" /><br />
       				<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_title_notice']; ?>
</span>
					</p>

					<p><?php if (! $this->_tpl_vars['oConfig']->GetValue('view.tinymce')): ?><div class="note"><?php echo $this->_tpl_vars['aLang']['topic_create_text_notice']; ?>
</div><?php endif; ?><label for="topic_text"><?php echo $this->_tpl_vars['aLang']['topic_create_text']; ?>
:</label>
					<?php if (! $this->_tpl_vars['oConfig']->GetValue('view.tinymce')): ?>
            			<div class="panel_form">
							<select onchange="lsPanel.putTagAround('topic_text',this.value); this.selectedIndex=0; return false;" style="width: 91px;">
            					<option value=""><?php echo $this->_tpl_vars['aLang']['panel_title']; ?>
</option>
            					<option value="h4"><?php echo $this->_tpl_vars['aLang']['panel_title_h4']; ?>
</option>
            					<option value="h5"><?php echo $this->_tpl_vars['aLang']['panel_title_h5']; ?>
</option>
            					<option value="h6"><?php echo $this->_tpl_vars['aLang']['panel_title_h6']; ?>
</option>
            				</select>            			
            				<select onchange="lsPanel.putList('topic_text',this); return false;">
            					<option value=""><?php echo $this->_tpl_vars['aLang']['panel_list']; ?>
</option>
            					<option value="ul"><?php echo $this->_tpl_vars['aLang']['panel_list_ul']; ?>
</option>
            					<option value="ol"><?php echo $this->_tpl_vars['aLang']['panel_list_ol']; ?>
</option>
            				</select>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','b'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/bold_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_b']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','i'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/italic_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_i']; ?>
"></a>	 			
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','u'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/underline_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_u']; ?>
"></a>	 			
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','s'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/strikethrough.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_s']; ?>
"></a>	 			
	 						&nbsp;
	 						<a href="#" onclick="lsPanel.putTagUrl('topic_text','<?php echo $this->_tpl_vars['aLang']['panel_url_promt']; ?>
'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/link.gif" width="20" height="20"  title="<?php echo $this->_tpl_vars['aLang']['panel_url']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putQuote('topic_text'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/quote.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_quote']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','code'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/code.gif" width="30" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_code']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','video'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/video.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_video']; ?>
"></a>
	 				
	 						<a href="#" onclick="showImgUploadForm(); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/img.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_image']; ?>
"></a> 			
	 						<a href="#" onclick="lsPanel.putText('topic_text','<cut>'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/cut.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_cut']; ?>
"></a>	
	 					</div>
	 				<?php endif; ?>
					<textarea name="topic_text" id="topic_text" rows="20"><?php echo $this->_tpl_vars['_aRequest']['topic_text']; ?>
</textarea></p>
					
					<p><label for="topic_tags"><?php echo $this->_tpl_vars['aLang']['topic_create_tags']; ?>
:</label><br />
					<input type="text" id="topic_tags" name="topic_tags" value="<?php echo $this->_tpl_vars['_aRequest']['topic_tags']; ?>
" class="w100p" /><br />
       				<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_tags_notice']; ?>
</span></p>
												
					<p><label for=""><input type="checkbox" id="topic_forbid_comment" name="topic_forbid_comment" class="checkbox" value="1" <?php if ($this->_tpl_vars['_aRequest']['topic_forbid_comment'] == 1): ?>checked<?php endif; ?>/> 
					&mdash; <?php echo $this->_tpl_vars['aLang']['topic_create_forbid_comment']; ?>
</label><br />
					<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_forbid_comment_notice']; ?>
</span></p>

					<?php if ($this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>
						<p><label for=""><input type="checkbox" id="topic_publish_index" name="topic_publish_index" class="checkbox" value="1" <?php if ($this->_tpl_vars['_aRequest']['topic_publish_index'] == 1): ?>checked<?php endif; ?>/> 
						&mdash; <?php echo $this->_tpl_vars['aLang']['topic_create_publish_index']; ?>
</label><br />
						<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_publish_index_notice']; ?>
</span></p>
					<?php endif; ?>
					
					<?php echo smarty_function_hook(array('run' => 'form_add_topic_topic_end'), $this);?>
					
					<p class="buttons">
					<input type="submit" name="submit_topic_publish" value="<?php echo $this->_tpl_vars['aLang']['topic_create_submit_publish']; ?>
" class="right" />
					<input type="submit" name="submit_preview" value="<?php echo $this->_tpl_vars['aLang']['topic_create_submit_preview']; ?>
" onclick="$('text_preview').getParent('div').setStyle('display','block'); ajaxTextPreview('topic_text',false); return false;" />&nbsp;
					<input type="submit" name="submit_topic_save" value="<?php echo $this->_tpl_vars['aLang']['topic_create_submit_save']; ?>
" />
					</p>
				</form>

			</div>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

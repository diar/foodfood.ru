<?php /* Smarty version 2.6.19, created on 2010-06-04 19:35:22
         compiled from actions/ActionTalk/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'actions/ActionTalk/add.tpl', 18, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'talk')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php echo '
<script language="JavaScript" type="text/javascript">
document.addEvent(\'domready\', function() {	
	new Autocompleter.Request.HTML($(\'talk_users\'), DIR_WEB_ROOT+\'/include/ajax/userAutocompleter.php?security_ls_key=\'+LIVESTREET_SECURITY_KEY, {
		\'indicatorClass\': \'autocompleter-loading\', // class added to the input during request
		\'minLength\': 1, // We need at least 1 character
		\'selectMode\': \'pick\', // Instant completion
		\'multiple\': true // Tag support, by default comma separated
	});
});
</script>
'; ?>


<?php if ($this->_tpl_vars['oConfig']->GetValue('view.tinymce')): ?>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.engine_lib'), $this);?>
/external/tinymce_3.2.7/tiny_mce.js"></script>

<?php echo '
<script type="text/javascript">
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
    language : TINYMCE_LANG
});
'; ?>

</script>

<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'window_load_img.tpl', 'smarty_include_vars' => array('sToLoad' => 'talk_text')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>



			<div class="topic">
				<h1><?php echo $this->_tpl_vars['aLang']['talk_create']; ?>
</h1>
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /> 
					
					<p><label for="talk_users"><?php echo $this->_tpl_vars['aLang']['talk_create_users']; ?>
:</label><input type="text" class="w100p" id="talk_users" name="talk_users" value="<?php echo $this->_tpl_vars['_aRequest']['talk_users']; ?>
"/></p>
					<p><label for="talk_title"><?php echo $this->_tpl_vars['aLang']['talk_create_title']; ?>
:</label><input type="text" class="w100p" id="talk_title" name="talk_title" value="<?php echo $this->_tpl_vars['_aRequest']['talk_title']; ?>
"/></p>

					<p><div class="note"></div><label for="talk_text"><?php echo $this->_tpl_vars['aLang']['talk_create_text']; ?>
:</label>
					<?php if (! $this->_tpl_vars['oConfig']->GetValue('view.tinymce')): ?>
            			<div class="panel_form">
							<select onchange="lsPanel.putTagAround('talk_text',this.value); this.selectedIndex=0; return false;" style="width: 91px;">
            					<option value=""><?php echo $this->_tpl_vars['aLang']['panel_title']; ?>
</option>
            					<option value="h4"><?php echo $this->_tpl_vars['aLang']['panel_title_h4']; ?>
</option>
            					<option value="h5"><?php echo $this->_tpl_vars['aLang']['panel_title_h5']; ?>
</option>
            					<option value="h6"><?php echo $this->_tpl_vars['aLang']['panel_title_h6']; ?>
</option>
            				</select>            			
            				<select onchange="lsPanel.putList('talk_text',this); return false;">
            					<option value=""><?php echo $this->_tpl_vars['aLang']['panel_list']; ?>
</option>
            					<option value="ul"><?php echo $this->_tpl_vars['aLang']['panel_list_ul']; ?>
</option>
            					<option value="ol"><?php echo $this->_tpl_vars['aLang']['panel_list_ol']; ?>
</option>
            				</select>
	 						<a href="#" onclick="lsPanel.putTagAround('talk_text','b'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/bold_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_b']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('talk_text','i'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/italic_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_i']; ?>
"></a>	 			
	 						<a href="#" onclick="lsPanel.putTagAround('talk_text','u'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/underline_ru.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_u']; ?>
"></a>	 			
	 						<a href="#" onclick="lsPanel.putTagAround('talk_text','s'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/strikethrough.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_s']; ?>
"></a>	 			
	 						&nbsp;
	 						<a href="#" onclick="lsPanel.putTagUrl('talk_text','<?php echo $this->_tpl_vars['aLang']['panel_url_promt']; ?>
'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/link.gif" width="20" height="20"  title="<?php echo $this->_tpl_vars['aLang']['panel_url']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putQuote('talk_text'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/quote.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_quote']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('talk_text','code'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/code.gif" width="30" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_code']; ?>
"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('talk_text','video'); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/video.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_video']; ?>
"></a>
	 				
	 						<a href="#" onclick="showImgUploadForm(); return false;" class="button"><img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/panel/img.gif" width="20" height="20" title="<?php echo $this->_tpl_vars['aLang']['panel_image']; ?>
"></a> 			
	 					</div>
	 				<?php endif; ?>					
					<textarea name="talk_text" id="talk_text" rows="12"><?php echo $this->_tpl_vars['_aRequest']['talk_text']; ?>
</textarea>
					</p>
					
					<p><input type="submit" value="<?php echo $this->_tpl_vars['aLang']['talk_create_submit']; ?>
" name="submit_talk_add"/></p>
				</form>
			</div>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
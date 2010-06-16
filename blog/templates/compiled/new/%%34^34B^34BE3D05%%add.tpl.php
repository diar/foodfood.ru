<?php /* Smarty version 2.6.19, created on 2010-05-26 20:35:58
         compiled from actions/ActionBlog/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionBlog/add.tpl', 10, false),array('function', 'hook', 'actions/ActionBlog/add.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['sEvent'] == 'add'): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'topic_action','showWhiteBack' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'blog_edit','showWhiteBack' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

		<?php if ($this->_tpl_vars['sEvent'] == 'add'): ?>
			<h1><?php echo $this->_tpl_vars['aLang']['blog_create']; ?>
</h1>
		<?php else: ?>
			<h1><?php echo $this->_tpl_vars['aLang']['blog_admin']; ?>
: <a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
<?php echo $this->_tpl_vars['oBlogEdit']->getUrl(); ?>
/"><?php echo $this->_tpl_vars['oBlogEdit']->getTitle(); ?>
</a></h1>
		<?php endif; ?>
		<form action="" method="POST" enctype="multipart/form-data">
			<?php echo smarty_function_hook(array('run' => 'form_add_blog_begin'), $this);?>

			<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /> 
				
			<p><label for="blog_title"><?php echo $this->_tpl_vars['aLang']['blog_create_title']; ?>
:</label><br />
			<input type="text" id="blog_title" name="blog_title" value="<?php echo $this->_tpl_vars['_aRequest']['blog_title']; ?>
" class="w100p" /><br />
			<span class="form_note"><?php echo $this->_tpl_vars['aLang']['blog_create_title_notice']; ?>
</span></p>

			<p><label for="blog_url"><?php echo $this->_tpl_vars['aLang']['blog_create_url']; ?>
:</label><br />
			<input type="text" id="blog_url" name="blog_url" value="<?php echo $this->_tpl_vars['_aRequest']['blog_url']; ?>
" class="w100p"  <?php if ($this->_tpl_vars['_aRequest']['blog_id']): ?>disabled<?php endif; ?> /><br />
			<span class="form_note"><?php echo $this->_tpl_vars['aLang']['blog_create_url_notice']; ?>
</span></p>
			
			<p><label for="blog_type"><?php echo $this->_tpl_vars['aLang']['blog_create_type']; ?>
:</label><br />
			<select name="blog_type" id="blog_type" onChange="">
				<option value="open" <?php if ($this->_tpl_vars['_aRequest']['blog_type'] == 'open'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['aLang']['blog_create_type_open']; ?>
</option>
				<option value="close" <?php if ($this->_tpl_vars['_aRequest']['blog_type'] == 'close'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['aLang']['blog_create_type_close']; ?>
</option>
			</select><br />
			<span class="form_note"><?php echo $this->_tpl_vars['aLang']['blog_create_type_open_notice']; ?>
</span></p>

			<p><label for="blog_description"><?php echo $this->_tpl_vars['aLang']['blog_create_description']; ?>
:</label><br />
			<textarea name="blog_description" id="blog_description" rows="20"><?php echo $this->_tpl_vars['_aRequest']['blog_description']; ?>
</textarea><br />
			<span class="form_note"><?php echo $this->_tpl_vars['aLang']['blog_create_description_notice']; ?>
</span></p>
			
			<p><label for="blog_limit_rating_topic"><?php echo $this->_tpl_vars['aLang']['blog_create_rating']; ?>
:</label><br />
			<input type="text" id="blog_limit_rating_topic" name="blog_limit_rating_topic" value="<?php echo $this->_tpl_vars['_aRequest']['blog_limit_rating_topic']; ?>
" class="w100p" /><br />
			<span class="form_note"><?php echo $this->_tpl_vars['aLang']['blog_create_rating_notice']; ?>
</span></p>
				
			<p>
			<?php if ($this->_tpl_vars['oBlogEdit'] && $this->_tpl_vars['oBlogEdit']->getAvatar()): ?>
				<img src="<?php echo $this->_tpl_vars['oBlogEdit']->getAvatarPath(48); ?>
" />
				<img src="<?php echo $this->_tpl_vars['oBlogEdit']->getAvatarPath(24); ?>
" />
				<label for="avatar_delete"><input type="checkbox" id="avatar_delete" name="avatar_delete" value="on"> &mdash; <?php echo $this->_tpl_vars['aLang']['blog_create_avatar_delete']; ?>
</label><br /><br />
			<?php endif; ?>
			<label for="avatar"><?php echo $this->_tpl_vars['aLang']['blog_create_avatar']; ?>
:</label><br />
			<input type="file" name="avatar" id="avatar"></p>
					
			<?php echo smarty_function_hook(array('run' => 'form_add_blog_end'), $this);?>
		
			<p><input type="submit" name="submit_blog_add" value="<?php echo $this->_tpl_vars['aLang']['blog_create_submit']; ?>
">						
			<input type="hidden" name="blog_id" value="<?php echo $this->_tpl_vars['_aRequest']['blog_id']; ?>
"></p>
			
		</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
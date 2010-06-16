<?php /* Smarty version 2.6.19, created on 2010-05-26 20:38:05
         compiled from window_load_img.tpl */ ?>
<div style="display: none;">
<div class="login-popup upload-image" id="window_load_img">
	<div class="login-popup-top"><a href="#" class="close-block" onclick="return false;"></a></div>
	<div class="content">
		<form method="POST" action="" enctype="multipart/form-data" id="form_upload_img" >
			<h3><?php echo $this->_tpl_vars['aLang']['uploadimg']; ?>
</h3>
			<p><label for="img_file"><?php echo $this->_tpl_vars['aLang']['uploadimg_file']; ?>
:</label><br /><input type="file" name="img_file" value="" class="w100p" /></p>
			<p><label for="img_url"><?php echo $this->_tpl_vars['aLang']['uploadimg_url']; ?>
:</label><br /><input  type="text" name="img_url" value="http://" class="w100p"/></p>
			<p><label for="align"><?php echo $this->_tpl_vars['aLang']['uploadimg_align']; ?>
:</label><br />				
				<select name="align" class="w100p">
					<option value=""><?php echo $this->_tpl_vars['aLang']['uploadimg_align_no']; ?>
</option>
					<option value="left"><?php echo $this->_tpl_vars['aLang']['uploadimg_align_left']; ?>
</option>
					<option value="right"><?php echo $this->_tpl_vars['aLang']['uploadimg_align_right']; ?>
</option>
				</select>
			</p>
			<p style="margin-bottom: 20px;"><label for="title"><?php echo $this->_tpl_vars['aLang']['uploadimg_title']; ?>
:</label><br /><input type="text" class="w100p" name="title" value="" /></p>
			<input type="button" value="<?php echo $this->_tpl_vars['aLang']['uploadimg_submit']; ?>
" onclick="ajaxUploadImg(document.getElementById('form_upload_img'),'<?php echo $this->_tpl_vars['sToLoad']; ?>
');">
			<input type="button" value="<?php echo $this->_tpl_vars['aLang']['uploadimg_cancel']; ?>
" onclick="hideImgUploadForm(); return false;">
		</form>
	</div>
	<div class="login-popup-bottom"></div>
</div>
</div>
<?php /* Smarty version 2.6.19, created on 2010-05-28 20:45:50
         compiled from actions/ActionSettings/profile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'actions/ActionSettings/profile.tpl', 32, false),array('modifier', 'escape', 'actions/ActionSettings/profile.tpl', 37, false),array('modifier', 'date_format', 'actions/ActionSettings/profile.tpl', 56, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'settings','showWhiteBack' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<script language="JavaScript" type="text/javascript">
document.addEvent(\'domready\', function() {	

	var inputCity = $(\'profile_city\');
 
	new Autocompleter.Request.HTML(inputCity, DIR_WEB_ROOT+\'/include/ajax/cityAutocompleter.php?security_ls_key=\'+LIVESTREET_SECURITY_KEY, {
		\'indicatorClass\': \'autocompleter-loading\', // class added to the input during request
		\'minLength\': 2, // We need at least 1 character
		\'selectMode\': \'pick\', // Instant completion
		\'multiple\': false // Tag support, by default comma separated
	});
	
	
	var inputCountry = $(\'profile_country\');
 
	new Autocompleter.Request.HTML(inputCountry, DIR_WEB_ROOT+\'/include/ajax/countryAutocompleter.php?security_ls_key=\'+LIVESTREET_SECURITY_KEY, {
		\'indicatorClass\': \'autocompleter-loading\', // class added to the input during request
		\'minLength\': 2, // We need at least 1 character
		\'selectMode\': \'pick\', // Instant completion
		\'multiple\': false // Tag support, by default comma separated
	});
});
</script>
'; ?>



			<h1><?php echo $this->_tpl_vars['aLang']['settings_profile_edit']; ?>
</h1>
			<form action="" method="POST" enctype="multipart/form-data">
				<?php echo smarty_function_hook(array('run' => 'form_settings_profile_begin'), $this);?>

				<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /> 
				
				<p>
					<label for="profile_name"><?php echo $this->_tpl_vars['aLang']['settings_profile_name']; ?>
:</label>
					<input type="text" name="profile_name" id="profile_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" class="w100p" /><br />
					<span class="form_note"><?php echo $this->_tpl_vars['aLang']['settings_profile_name_notice']; ?>
</span>
				</p>
				<p>
					<label for="mail"><?php echo $this->_tpl_vars['aLang']['settings_profile_mail']; ?>
:</label>
					<input type="text" class="w100p" name="mail" id="mail" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getMail())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/><br />
					<span class="form_note"><?php echo $this->_tpl_vars['aLang']['settings_profile_mail_notice']; ?>
</span>
				</p>
				<p>
					<label for=""><?php echo $this->_tpl_vars['aLang']['settings_profile_sex']; ?>
:</label><br />
					<label for=""><input type="radio" name="profile_sex" id="profile_sex_m" value="man" <?php if ($this->_tpl_vars['oUserCurrent']->getProfileSex() == 'man'): ?>checked<?php endif; ?> class="radio" />  &mdash;  <?php echo $this->_tpl_vars['aLang']['settings_profile_sex_man']; ?>
</label><br />
					<label for=""><input type="radio" name="profile_sex" id="profile_sex_w" value="woman" <?php if ($this->_tpl_vars['oUserCurrent']->getProfileSex() == 'woman'): ?>checked<?php endif; ?> class="radio" />  &mdash;  <?php echo $this->_tpl_vars['aLang']['settings_profile_sex_woman']; ?>
</label><br />
					<label for=""><input type="radio" name="profile_sex" id="profile_sex_o"  value="other" <?php if ($this->_tpl_vars['oUserCurrent']->getProfileSex() == 'other'): ?>checked<?php endif; ?> class="radio" />  &mdash;  <?php echo $this->_tpl_vars['aLang']['settings_profile_sex_other']; ?>
</label>
				</p>
				<p>
					<label for=""><?php echo $this->_tpl_vars['aLang']['settings_profile_birthday']; ?>
:</label><br />					
					<select name="profile_birthday_day" class="w70">
						<option value=""><?php echo $this->_tpl_vars['aLang']['date_day']; ?>
</option>
						<?php unset($this->_sections['date_day']);
$this->_sections['date_day']['name'] = 'date_day';
$this->_sections['date_day']['start'] = (int)1;
$this->_sections['date_day']['loop'] = is_array($_loop=32) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['date_day']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['date_day']['show'] = true;
$this->_sections['date_day']['max'] = $this->_sections['date_day']['loop'];
if ($this->_sections['date_day']['start'] < 0)
    $this->_sections['date_day']['start'] = max($this->_sections['date_day']['step'] > 0 ? 0 : -1, $this->_sections['date_day']['loop'] + $this->_sections['date_day']['start']);
else
    $this->_sections['date_day']['start'] = min($this->_sections['date_day']['start'], $this->_sections['date_day']['step'] > 0 ? $this->_sections['date_day']['loop'] : $this->_sections['date_day']['loop']-1);
if ($this->_sections['date_day']['show']) {
    $this->_sections['date_day']['total'] = min(ceil(($this->_sections['date_day']['step'] > 0 ? $this->_sections['date_day']['loop'] - $this->_sections['date_day']['start'] : $this->_sections['date_day']['start']+1)/abs($this->_sections['date_day']['step'])), $this->_sections['date_day']['max']);
    if ($this->_sections['date_day']['total'] == 0)
        $this->_sections['date_day']['show'] = false;
} else
    $this->_sections['date_day']['total'] = 0;
if ($this->_sections['date_day']['show']):

            for ($this->_sections['date_day']['index'] = $this->_sections['date_day']['start'], $this->_sections['date_day']['iteration'] = 1;
                 $this->_sections['date_day']['iteration'] <= $this->_sections['date_day']['total'];
                 $this->_sections['date_day']['index'] += $this->_sections['date_day']['step'], $this->_sections['date_day']['iteration']++):
$this->_sections['date_day']['rownum'] = $this->_sections['date_day']['iteration'];
$this->_sections['date_day']['index_prev'] = $this->_sections['date_day']['index'] - $this->_sections['date_day']['step'];
$this->_sections['date_day']['index_next'] = $this->_sections['date_day']['index'] + $this->_sections['date_day']['step'];
$this->_sections['date_day']['first']      = ($this->_sections['date_day']['iteration'] == 1);
$this->_sections['date_day']['last']       = ($this->_sections['date_day']['iteration'] == $this->_sections['date_day']['total']);
?>    		
    						<option value="<?php echo $this->_sections['date_day']['index']; ?>
" <?php if ($this->_sections['date_day']['index'] == ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileBirthday())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d") : smarty_modifier_date_format($_tmp, "%d"))): ?>selected<?php endif; ?>><?php echo $this->_sections['date_day']['index']; ?>
</option>
						<?php endfor; endif; ?>
					</select>
					<select name="profile_birthday_month" class="w100">
						<option value=""><?php echo $this->_tpl_vars['aLang']['date_month']; ?>
</option>		
						<?php unset($this->_sections['date_month']);
$this->_sections['date_month']['name'] = 'date_month';
$this->_sections['date_month']['start'] = (int)1;
$this->_sections['date_month']['loop'] = is_array($_loop=13) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['date_month']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['date_month']['show'] = true;
$this->_sections['date_month']['max'] = $this->_sections['date_month']['loop'];
if ($this->_sections['date_month']['start'] < 0)
    $this->_sections['date_month']['start'] = max($this->_sections['date_month']['step'] > 0 ? 0 : -1, $this->_sections['date_month']['loop'] + $this->_sections['date_month']['start']);
else
    $this->_sections['date_month']['start'] = min($this->_sections['date_month']['start'], $this->_sections['date_month']['step'] > 0 ? $this->_sections['date_month']['loop'] : $this->_sections['date_month']['loop']-1);
if ($this->_sections['date_month']['show']) {
    $this->_sections['date_month']['total'] = min(ceil(($this->_sections['date_month']['step'] > 0 ? $this->_sections['date_month']['loop'] - $this->_sections['date_month']['start'] : $this->_sections['date_month']['start']+1)/abs($this->_sections['date_month']['step'])), $this->_sections['date_month']['max']);
    if ($this->_sections['date_month']['total'] == 0)
        $this->_sections['date_month']['show'] = false;
} else
    $this->_sections['date_month']['total'] = 0;
if ($this->_sections['date_month']['show']):

            for ($this->_sections['date_month']['index'] = $this->_sections['date_month']['start'], $this->_sections['date_month']['iteration'] = 1;
                 $this->_sections['date_month']['iteration'] <= $this->_sections['date_month']['total'];
                 $this->_sections['date_month']['index'] += $this->_sections['date_month']['step'], $this->_sections['date_month']['iteration']++):
$this->_sections['date_month']['rownum'] = $this->_sections['date_month']['iteration'];
$this->_sections['date_month']['index_prev'] = $this->_sections['date_month']['index'] - $this->_sections['date_month']['step'];
$this->_sections['date_month']['index_next'] = $this->_sections['date_month']['index'] + $this->_sections['date_month']['step'];
$this->_sections['date_month']['first']      = ($this->_sections['date_month']['iteration'] == 1);
$this->_sections['date_month']['last']       = ($this->_sections['date_month']['iteration'] == $this->_sections['date_month']['total']);
?>
							<option value="<?php echo $this->_sections['date_month']['index']; ?>
" <?php if ($this->_sections['date_month']['index'] == ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileBirthday())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m") : smarty_modifier_date_format($_tmp, "%m"))): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['aLang']['month_array'][$this->_sections['date_month']['index']][0]; ?>
</option>
						<?php endfor; endif; ?>
					</select>
					<select name="profile_birthday_year" class="w70">
						<option value=""><?php echo $this->_tpl_vars['aLang']['date_year']; ?>
</option>
						<?php unset($this->_sections['date_year']);
$this->_sections['date_year']['name'] = 'date_year';
$this->_sections['date_year']['start'] = (int)1940;
$this->_sections['date_year']['loop'] = is_array($_loop=2000) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['date_year']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['date_year']['show'] = true;
$this->_sections['date_year']['max'] = $this->_sections['date_year']['loop'];
if ($this->_sections['date_year']['start'] < 0)
    $this->_sections['date_year']['start'] = max($this->_sections['date_year']['step'] > 0 ? 0 : -1, $this->_sections['date_year']['loop'] + $this->_sections['date_year']['start']);
else
    $this->_sections['date_year']['start'] = min($this->_sections['date_year']['start'], $this->_sections['date_year']['step'] > 0 ? $this->_sections['date_year']['loop'] : $this->_sections['date_year']['loop']-1);
if ($this->_sections['date_year']['show']) {
    $this->_sections['date_year']['total'] = min(ceil(($this->_sections['date_year']['step'] > 0 ? $this->_sections['date_year']['loop'] - $this->_sections['date_year']['start'] : $this->_sections['date_year']['start']+1)/abs($this->_sections['date_year']['step'])), $this->_sections['date_year']['max']);
    if ($this->_sections['date_year']['total'] == 0)
        $this->_sections['date_year']['show'] = false;
} else
    $this->_sections['date_year']['total'] = 0;
if ($this->_sections['date_year']['show']):

            for ($this->_sections['date_year']['index'] = $this->_sections['date_year']['start'], $this->_sections['date_year']['iteration'] = 1;
                 $this->_sections['date_year']['iteration'] <= $this->_sections['date_year']['total'];
                 $this->_sections['date_year']['index'] += $this->_sections['date_year']['step'], $this->_sections['date_year']['iteration']++):
$this->_sections['date_year']['rownum'] = $this->_sections['date_year']['iteration'];
$this->_sections['date_year']['index_prev'] = $this->_sections['date_year']['index'] - $this->_sections['date_year']['step'];
$this->_sections['date_year']['index_next'] = $this->_sections['date_year']['index'] + $this->_sections['date_year']['step'];
$this->_sections['date_year']['first']      = ($this->_sections['date_year']['iteration'] == 1);
$this->_sections['date_year']['last']       = ($this->_sections['date_year']['iteration'] == $this->_sections['date_year']['total']);
?>    		
    						<option value="<?php echo $this->_sections['date_year']['index']; ?>
" <?php if ($this->_sections['date_year']['index'] == ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileBirthday())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y"))): ?>selected<?php endif; ?>><?php echo $this->_sections['date_year']['index']; ?>
</option>
						<?php endfor; endif; ?>
					</select>
				</p>
				
				<p>
					<label for="profile_country"><?php echo $this->_tpl_vars['aLang']['settings_profile_country']; ?>
:</label><br /><input type="text" class="w300" 	id="profile_country" name="profile_country" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileCountry())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/><br />
					<label for="profile_city"><?php echo $this->_tpl_vars['aLang']['settings_profile_city']; ?>
:</label><br /><input type="text" class="w300" id="profile_city" name="profile_city" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileCity())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/><br />
				</p>
				
				<p><label for="profile_icq"><?php echo $this->_tpl_vars['aLang']['settings_profile_icq']; ?>
:</label><br /><input type="text" class="w300" name="profile_icq" id="profile_icq" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileIcq())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/></p>
				
				<p>
					<label for="profile_site"><?php echo $this->_tpl_vars['aLang']['settings_profile_site']; ?>
:</label><br />
					<label for="profile_site"><input type="text" class="w300" style="margin-bottom: 5px;" id="profile_site" name="profile_site" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileSite())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/> &mdash; <?php echo $this->_tpl_vars['aLang']['settings_profile_site_url']; ?>
</label><br />
					<label for="profile_site_name"><input type="text" class="w300" id="profile_site_name"	name="profile_site_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileSiteName())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/> &mdash; <?php echo $this->_tpl_vars['aLang']['settings_profile_site_name']; ?>
</label>
				</p>
				
				<p>
					<label for="profile_about"><?php echo $this->_tpl_vars['aLang']['settings_profile_about']; ?>
:</label><br />
					<textarea class="small" name="profile_about" id="profile_about"><?php echo ((is_array($_tmp=$this->_tpl_vars['oUserCurrent']->getProfileAbout())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</textarea>
				</p>
				
				<p>
					<label for="password_now"><?php echo $this->_tpl_vars['aLang']['settings_profile_password_current']; ?>
:</label><br /><input type="password" class="w300" name="password_now" id="password_now" value=""/><br />
					<label for="password"><?php echo $this->_tpl_vars['aLang']['settings_profile_password_new']; ?>
:</label><br /><input type="password" class="w300" id="password"	name="password" value=""/><br />
					<label for="password_confirm"><?php echo $this->_tpl_vars['aLang']['settings_profile_password_confirm']; ?>
:</label><br /><input type="password" class="w300" id="password_confirm"	name="password_confirm" value=""/>
				</p>
				
				<?php if ($this->_tpl_vars['oUserCurrent']->getProfileAvatar()): ?>
					<img src="<?php echo $this->_tpl_vars['oUserCurrent']->getProfileAvatarPath(100); ?>
" border="0">
					<img src="<?php echo $this->_tpl_vars['oUserCurrent']->getProfileAvatarPath(64); ?>
" border="0">
					<img src="<?php echo $this->_tpl_vars['oUserCurrent']->getProfileAvatarPath(24); ?>
" border="0">
					<input type="checkbox" id="avatar_delete" name="avatar_delete" value="on"> &mdash; <label for="avatar_delete"><span class="form"><?php echo $this->_tpl_vars['aLang']['settings_profile_avatar_delete']; ?>
</span></label><br /><br>
				<?php endif; ?>
				<p><label for="avatar"><?php echo $this->_tpl_vars['aLang']['settings_profile_avatar']; ?>
:</label><br /><input type="file" id="avatar" name="avatar"/></p>
				
				<?php if ($this->_tpl_vars['oUserCurrent']->getProfileFoto()): ?>
					<img src="<?php echo $this->_tpl_vars['oUserCurrent']->getProfileFoto(); ?>
" border="0">					
					<input type="checkbox" id="foto_delete" name="foto_delete" value="on"> &mdash; <label for="foto_delete"><span class="form"><?php echo $this->_tpl_vars['aLang']['settings_profile_foto_delete']; ?>
</span></label><br /><br>
				<?php endif; ?>
				<p><label for="foto"><?php echo $this->_tpl_vars['aLang']['settings_profile_foto']; ?>
:</label><br /><input type="file" id="foto" name="foto"/></p>
				
				<?php echo smarty_function_hook(array('run' => 'form_settings_profile_end'), $this);?>

				<p><input type="submit" value="<?php echo $this->_tpl_vars['aLang']['settings_profile_submit']; ?>
" name="submit_profile_edit"/></p>
			</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
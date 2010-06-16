<?php /* Smarty version 2.6.19, created on 2010-06-04 19:34:55
         compiled from actions/ActionTalk/filter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionTalk/filter.tpl', 60, false),)), $this); ?>
			<div class="block blogs">
				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
					<h1><?php echo $this->_tpl_vars['aLang']['talk_filter_title']; ?>
</h1>
<?php echo '
<script language="JavaScript" type="text/javascript">
document.addEvent(\'domready\', function() {	
	new Autocompleter.Request.HTML(
		$(\'talk_filter_sender\'),
		 DIR_WEB_ROOT+\'/include/ajax/userAutocompleter.php?security_ls_key=\'+LIVESTREET_SECURITY_KEY, 
		 {
			\'indicatorClass\': \'autocompleter-loading\',
			\'minLength\': 1,
			\'selectMode\': \'pick\',
			\'multiple\': false
		}
	);
	new vlaDatePicker(
		$(\'talk_filter_start\'),
		{ 
			separator: \'.\', 
			leadingZero: true, 
			twoDigitYear: false,
			alignX: \'center\', 
			alignY: \'top\',
			offset: { y: 3 },
			filePath: DIR_WEB_ROOT+\'/engine/lib/external/MooTools_1.2/plugs/vlaCal-v2.1/inc/\', 
			prefillDate: false,
			startMonday: true
		} 
	);
	new vlaDatePicker(
		$(\'talk_filter_end\'),
		{ 
			separator: \'.\', 
			leadingZero: true, 
			twoDigitYear: false,
			alignX: \'center\', 
			alignY: \'top\',
			offset: { y: 3 },
			filePath: DIR_WEB_ROOT+\'/engine/lib/external/MooTools_1.2/plugs/vlaCal-v2.1/inc/\', 
			prefillDate: false,
			startMonday: true
		} 
	);	
});

	function eraseFilterForm() {
		$$("#talk_filter_sender, #talk_filter_keyword, #talk_filter_start, #talk_filter_end").each(
			function(item,index){
				return item.set(\'value\',\'\');
			}
		);
		return false;
	}
</script>
'; ?>
					
					<div class="block-content">
						<form action="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
" method="GET" name="talk_filter_form">
							<p><label for="talk_filter_sender"><?php echo $this->_tpl_vars['aLang']['talk_filter_label_sender']; ?>
:</label><br />
							<input type="text" id="talk_filter_sender" name="sender" value="<?php echo $this->_tpl_vars['_aRequest']['sender']; ?>
" class="w100p" /><br />
       						<span class="form_note"><?php echo $this->_tpl_vars['aLang']['talk_filter_notice_sender']; ?>
</span>
							</p>						
							<p><label for="talk_filter_keyword"><?php echo $this->_tpl_vars['aLang']['talk_filter_label_keyword']; ?>
:</label><br />
							<input type="text" id="talk_filter_keyword" name="keyword" value="<?php echo $this->_tpl_vars['_aRequest']['keyword']; ?>
" class="w100p" /><br />
       						<span class="form_note"><?php echo $this->_tpl_vars['aLang']['talk_filter_notice_keyword']; ?>
</span>
							</p>
							
							<p><label for="talk_filter_start"><?php echo $this->_tpl_vars['aLang']['talk_filter_label_date']; ?>
:</label><br />
							<input type="text" id="talk_filter_start" name="start" value="<?php echo $this->_tpl_vars['_aRequest']['start']; ?>
" class="w100p" style="width: 44%" readonly="readonly" /> &mdash; 
							<input type="text" id="talk_filter_end" name="end" value="<?php echo $this->_tpl_vars['_aRequest']['end']; ?>
" class="w100p" style="width: 44%" readonly="readonly" /><br />
       						<span class="form_note"><?php echo $this->_tpl_vars['aLang']['talk_filter_notice_date']; ?>
</span>
							</p>	
							<p class="buttons">								
								<input type="submit" name="submit_talk_filter" value="<?php echo $this->_tpl_vars['aLang']['talk_filter_submit']; ?>
"/>
							</p>													
						</form>
					</div>
					<div class="right"><a href="#" onclick="return eraseFilterForm();"><?php echo $this->_tpl_vars['aLang']['talk_filter_erase_form']; ?>
</a> | <a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['talk_filter_erase']; ?>
</a></div>					
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
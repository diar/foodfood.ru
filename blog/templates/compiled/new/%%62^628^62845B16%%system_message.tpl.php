<?php /* Smarty version 2.6.19, created on 2010-06-16 20:45:13
         compiled from system_message.tpl */ ?>
<?php if ($this->_tpl_vars['aMsgError']): ?>
<div id="system_messages_error">
<ul>
<?php $_from = $this->_tpl_vars['aMsgError']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aMsg']):
?>
	<li>
		<?php if ($this->_tpl_vars['aMsg']['title'] != ''): ?>
			<b><?php echo $this->_tpl_vars['aMsg']['title']; ?>
</b>:
		<?php endif; ?>
		<?php echo $this->_tpl_vars['aMsg']['msg']; ?>

	</li>
<?php endforeach; endif; unset($_from); ?>
</ul>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['aMsgNotice']): ?>
<br>
<br>
<div id="system_messages_notice">
<ul>
<?php $_from = $this->_tpl_vars['aMsgNotice']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aMsg']):
?>
	<li>
		<?php if ($this->_tpl_vars['aMsg']['title'] != ''): ?>
			<b><?php echo $this->_tpl_vars['aMsg']['title']; ?>
</b>:
		<?php endif; ?>
		<?php echo $this->_tpl_vars['aMsg']['msg']; ?>

	</li>
<?php endforeach; endif; unset($_from); ?>
</ul>
</div>
<?php endif; ?>
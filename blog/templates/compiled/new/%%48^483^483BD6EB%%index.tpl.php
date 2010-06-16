<?php /* Smarty version 2.6.19, created on 2010-05-28 03:11:46
         compiled from actions/ActionRss/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'actions/ActionRss/index.tpl', 11, false),array('function', 'date_format', 'actions/ActionRss/index.tpl', 22, false),array('modifier', 'escape', 'actions/ActionRss/index.tpl', 17, false),array('modifier', 'replace', 'actions/ActionRss/index.tpl', 23, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="UTF-8"<?php echo '?>'; ?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
	<title><?php echo $this->_tpl_vars['aChannel']['title']; ?>
</title>
	<link><?php echo $this->_tpl_vars['aChannel']['link']; ?>
</link>
	<atom:link href="<?php echo $this->_tpl_vars['PATH_WEB_CURRENT']; ?>
/" rel="self" type="application/rss+xml" />
	<description><![CDATA[<?php echo $this->_tpl_vars['aChannel']['description']; ?>
]]></description>
	<language><?php echo $this->_tpl_vars['aChannel']['language']; ?>
</language>
	<managingEditor><?php echo $this->_tpl_vars['aChannel']['managingEditor']; ?>
 (<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
)</managingEditor>
	<webMaster><?php echo $this->_tpl_vars['aChannel']['managingEditor']; ?>
 (<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
)</webMaster>
	<copyright><?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
</copyright>
	<generator><?php echo $this->_tpl_vars['aChannel']['generator']; ?>
</generator>
<?php $_from = $this->_tpl_vars['aItems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oItem']):
?>
		<item>
			<title><![CDATA[<?php echo ((is_array($_tmp=$this->_tpl_vars['oItem']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
]]></title>
			<guid isPermaLink="true"><?php echo $this->_tpl_vars['oItem']['guid']; ?>
</guid>
			<link><?php echo $this->_tpl_vars['oItem']['link']; ?>
</link>
			<dc:creator><?php echo $this->_tpl_vars['oItem']['author']; ?>
</dc:creator>
			<description><![CDATA[<?php echo $this->_tpl_vars['oItem']['description']; ?>
]]></description>
			<pubDate><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oItem']['pubDate'],'format' => 'r'), $this);?>
</pubDate>			
			<category><?php echo ((is_array($_tmp=$this->_tpl_vars['oItem']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ',', '</category>
			<category>') : smarty_modifier_replace($_tmp, ',', '</category>
			<category>')); ?>
</category>
		</item>
<?php endforeach; endif; unset($_from); ?>
</channel>
</rss>
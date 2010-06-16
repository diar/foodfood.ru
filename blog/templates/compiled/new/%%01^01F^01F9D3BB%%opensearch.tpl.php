<?php /* Smarty version 2.6.19, created on 2010-05-30 15:57:55
         compiled from actions/ActionSearch/opensearch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'actions/ActionSearch/opensearch.tpl', 2, false),array('function', 'router', 'actions/ActionSearch/opensearch.tpl', 5, false),)), $this); ?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/"> 
	<ShortName><?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
</ShortName> 
	<Description><?php echo $this->_tpl_vars['sHtmlTitle']; ?>
</Description> 
	<Contact><?php echo $this->_tpl_vars['sAdminMail']; ?>
</Contact> 
	<Url type="text/html" template="<?php echo smarty_function_router(array('page' => 'search'), $this);?>
topics/?q=<?php echo '{searchTerms}'; ?>
" /> 
	<LongName><?php echo $this->_tpl_vars['sHtmlDescription']; ?>
</LongName> 
	<Image height="64" width="64" type="image/png"><?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/logo.gif</Image> 
	<Image height="16" width="16" type="image/vnd.microsoft.icon"><?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/favicon.ico</Image> 
	<Developer><?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
 (<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
)</Developer> 
	<Attribution> 
		© «<?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
»
	</Attribution> 
	<SyndicationRight>open</SyndicationRight> 
	<AdultContent>false</AdultContent> 
	<Language>ru-ru</Language> 
	<OutputEncoding>UTF-8</OutputEncoding> 
	<InputEncoding>UTF-8</InputEncoding> 
</OpenSearchDescription>
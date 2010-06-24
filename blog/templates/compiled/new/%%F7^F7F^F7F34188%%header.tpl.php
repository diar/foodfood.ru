<?php /* Smarty version 2.6.19, created on 2010-06-16 20:45:13
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'header.tpl', 6, false),array('function', 'cfg', 'header.tpl', 14, false),array('function', 'router', 'header.tpl', 15, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">

<head>
	<?php echo smarty_function_hook(array('run' => 'html_head_begin'), $this);?>

	<title><?php echo $this->_tpl_vars['sHtmlTitle']; ?>
</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
	<meta name="DESCRIPTION" content="<?php echo $this->_tpl_vars['sHtmlDescription']; ?>
" />
	<meta name="KEYWORDS" content="<?php echo $this->_tpl_vars['sHtmlKeywords']; ?>
" />	

	<?php echo $this->_tpl_vars['aHtmlHeadFiles']['css']; ?>

	
	<link href="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/favicon.ico" rel="shortcut icon" />
	<link rel="search" type="application/opensearchdescription+xml" href="<?php echo smarty_function_router(array('page' => 'search'), $this);?>
opensearch/" title="<?php echo smarty_function_cfg(array('name' => 'view.name'), $this);?>
" />
	
	<?php if ($this->_tpl_vars['aHtmlRssAlternate']): ?>
		<link rel="alternate" type="application/rss+xml" href="<?php echo $this->_tpl_vars['aHtmlRssAlternate']['url']; ?>
" title="<?php echo $this->_tpl_vars['aHtmlRssAlternate']['title']; ?>
">
	<?php endif; ?>

<script language="JavaScript" type="text/javascript">
var DIR_WEB_ROOT='<?php echo smarty_function_cfg(array('name' => "path.root.web"), $this);?>
';
var DIR_STATIC_SKIN='<?php echo smarty_function_cfg(array('name' => "path.static.skin"), $this);?>
';
var BLOG_USE_TINYMCE='<?php echo smarty_function_cfg(array('name' => "view.tinymce"), $this);?>
';
var TALK_RELOAD_PERIOD='<?php echo smarty_function_cfg(array('name' => "module.talk.period"), $this);?>
';
var TALK_RELOAD_REQUEST='<?php echo smarty_function_cfg(array('name' => "module.talk.request"), $this);?>
'; 
var TALK_RELOAD_MAX_ERRORS='<?php echo smarty_function_cfg(array('name' => "module.talk.max_errors"), $this);?>
';
var LIVESTREET_SECURITY_KEY = '<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
';

var TINYMCE_LANG='en';
<?php if ($this->_tpl_vars['oConfig']->GetValue('lang.current') == 'russian'): ?>
TINYMCE_LANG='ru';
<?php endif; ?>

var aRouter=new Array();
<?php $_from = $this->_tpl_vars['aRouter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sPage'] => $this->_tpl_vars['sPath']):
?>
aRouter['<?php echo $this->_tpl_vars['sPage']; ?>
']='<?php echo $this->_tpl_vars['sPath']; ?>
';
<?php endforeach; endif; unset($_from); ?>

</script>

	<?php echo $this->_tpl_vars['aHtmlHeadFiles']['js']; ?>


<?php echo '
<script language="JavaScript" type="text/javascript">
var tinyMCE=false;
var msgErrorBox=new Roar({
			position: \'upperRight\',
			className: \'roar-error\',
			margin: {x: 30, y: 10}
		});	
var msgNoticeBox=new Roar({
			position: \'upperRight\',
			className: \'roar-notice\',
			margin: {x: 30, y: 10}
		});	
</script>
'; ?>


<?php if ($this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oConfig']->GetValue('module.talk.reload')): ?>
<?php echo '
<script language="JavaScript" type="text/javascript">
    var talkNewMessages=new lsTalkMessagesClass({
    	reload: {
            request: TALK_RELOAD_REQUEST,
        	url: DIR_WEB_ROOT+\'/include/ajax/talkNewMessages.php\',
        	errors: TALK_RELOAD_MAX_ERRORS
    	}
    });  
	(function(){
   		talkNewMessages.get();
	}).periodical(TALK_RELOAD_PERIOD);
</script>
'; ?>

<?php endif; ?>
</head>

<body onload="prettyPrint()">

<?php echo smarty_function_hook(array('run' => 'body_begin'), $this);?>


<div id="debug" style="border: 2px #dd0000 solid; display: none;"></div>

<div id="container">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
	
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header_nav.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<!--
	<div id="extra">
		<a href="#">К списку постов</a>
	</div>
	-->
	
	<div id="wrapper" class="<?php if (! $this->_tpl_vars['showUpdateButton']): ?>update-hide<?php endif; ?> <?php if ($this->_tpl_vars['showWhiteBack']): ?>white-back<?php endif; ?>">
		
		<!-- Content -->
		<div id="content" <?php if ($this->_tpl_vars['bNoSidebar']): ?>style="width:100%;"<?php endif; ?>>
		
		<?php if (! $this->_tpl_vars['noShowSystemMessage']): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'system_message.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
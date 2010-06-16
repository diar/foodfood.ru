<?php /* Smarty version 2.6.19, created on 2010-06-04 19:34:28
         compiled from actions/ActionPeople/online.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'actions/ActionPeople/online.tpl', 22, false),array('function', 'date_format', 'actions/ActionPeople/online.tpl', 23, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('showWhiteBack' => true,'menu' => 'people')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<div class="page people">
				
				<h1><?php echo $this->_tpl_vars['aLang']['user_list_online_last']; ?>
</h1>
				
				<?php if ($this->_tpl_vars['aUsersLast']): ?>
				<table>
					<thead>
						<tr>
							<td class="user"><?php echo $this->_tpl_vars['aLang']['user']; ?>
</td>													
							<td class="date"><?php echo $this->_tpl_vars['aLang']['user_date_last']; ?>
</td>
							<td class="strength"><?php echo $this->_tpl_vars['aLang']['user_skill']; ?>
</td>
							<td class="rating"><?php echo $this->_tpl_vars['aLang']['user_rating']; ?>
</td>
						</tr>
					</thead>
					
					<tbody>
					<?php $_from = $this->_tpl_vars['aUsersLast']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oUser']):
?>
					<?php $this->assign('oSession', $this->_tpl_vars['oUser']->getSession()); ?>
						<tr>
							<td class="user"><a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
/"><img src="<?php echo $this->_tpl_vars['oUser']->getProfileAvatarPath(24); ?>
" alt="" /></a><a href="<?php echo smarty_function_router(array('page' => 'profile'), $this);?>
<?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
/" class="link"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a></td>														
							<td class="date"><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oSession']->getDateLast()), $this);?>
</td>
							<td class="strength"><?php echo $this->_tpl_vars['oUser']->getSkill(); ?>
</td>							
							<td class="rating"><strong><?php echo $this->_tpl_vars['oUser']->getRating(); ?>
</strong></td>
						</tr>
					<?php endforeach; endif; unset($_from); ?>						
					</tbody>
				</table>
				<?php else: ?>
					<?php echo $this->_tpl_vars['aLang']['user_empty']; ?>

				<?php endif; ?>
			</div>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array('aPaging' => ($this->_tpl_vars['aPaging']))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			
			
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
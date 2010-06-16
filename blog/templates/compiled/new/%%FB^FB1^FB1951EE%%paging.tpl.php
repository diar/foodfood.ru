<?php /* Smarty version 2.6.19, created on 2010-05-26 20:32:26
         compiled from paging.tpl */ ?>
	<?php if ($this->_tpl_vars['aPaging'] && $this->_tpl_vars['aPaging']['iCountPage'] > 1): ?> 
			<div id="pagination">
				<p>
					&larr;				
					<?php if ($this->_tpl_vars['aPaging']['iPrevPage']): ?>
    					<a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['aPaging']['iPrevPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
"><?php echo $this->_tpl_vars['aLang']['paging_previos']; ?>
</a>
    				<?php else: ?>
    					<?php echo $this->_tpl_vars['aLang']['paging_previos']; ?>

    				<?php endif; ?>
    				&nbsp; &nbsp;
    				<?php if ($this->_tpl_vars['aPaging']['iNextPage']): ?>
    					<a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['aPaging']['iNextPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
"><?php echo $this->_tpl_vars['aLang']['paging_next']; ?>
</a>
    				<?php else: ?>
    					<?php echo $this->_tpl_vars['aLang']['paging_next']; ?>

    				<?php endif; ?>
					&rarr;
				</p>
				<ul>
					<li><?php echo $this->_tpl_vars['aLang']['paging']; ?>
:</li>				
					
					<?php if ($this->_tpl_vars['aPaging']['iCurrentPage'] > 1): ?>
						<li><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
">&larr;</a></li>
					<?php endif; ?>
					<?php $_from = $this->_tpl_vars['aPaging']['aPagesLeft']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['iPage']):
?>
						<li><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['iPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
"><?php echo $this->_tpl_vars['iPage']; ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
					<li class="active"><?php echo $this->_tpl_vars['aPaging']['iCurrentPage']; ?>
</li>
					<?php $_from = $this->_tpl_vars['aPaging']['aPagesRight']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['iPage']):
?>
						<li><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['iPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
"><?php echo $this->_tpl_vars['iPage']; ?>
</a></li>
					<?php endforeach; endif; unset($_from); ?>
					<?php if ($this->_tpl_vars['aPaging']['iCurrentPage'] < $this->_tpl_vars['aPaging']['iCountPage']): ?>
						<li><a href="<?php echo $this->_tpl_vars['aPaging']['sBaseUrl']; ?>
/page<?php echo $this->_tpl_vars['aPaging']['iCountPage']; ?>
/<?php echo $this->_tpl_vars['aPaging']['sGetParams']; ?>
"><?php echo $this->_tpl_vars['aLang']['paging_last']; ?>
</a></li>
					<?php endif; ?>					
				</ul>
			</div>
	<?php endif; ?>
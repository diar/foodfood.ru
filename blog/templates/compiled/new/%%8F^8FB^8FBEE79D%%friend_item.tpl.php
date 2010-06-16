<?php /* Smarty version 2.6.19, created on 2010-06-02 19:32:19
         compiled from actions/ActionProfile/friend_item.tpl */ ?>
<?php if ($this->_tpl_vars['oUserFriend'] && ( $this->_tpl_vars['oUserFriend']->getFriendStatus() == $this->_tpl_vars['USER_FRIEND_ACCEPT']+$this->_tpl_vars['USER_FRIEND_OFFER'] || $this->_tpl_vars['oUserFriend']->getFriendStatus() == $this->_tpl_vars['USER_FRIEND_ACCEPT']+$this->_tpl_vars['USER_FRIEND_ACCEPT'] )): ?>
	<li class="del"><a href="#"  title="<?php echo $this->_tpl_vars['aLang']['user_friend_del']; ?>
" onclick="ajaxDeleteUserFriend(this,<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
,'del'); return false;"><?php echo $this->_tpl_vars['aLang']['user_friend_del']; ?>
</a></li>
<?php elseif ($this->_tpl_vars['oUserFriend'] && $this->_tpl_vars['oUserFriend']->getStatusTo() == $this->_tpl_vars['USER_FRIEND_REJECT'] && $this->_tpl_vars['oUserFriend']->getStatusFrom() == $this->_tpl_vars['USER_FRIEND_OFFER'] && $this->_tpl_vars['oUserFriend']->getUserTo() == $this->_tpl_vars['oUserCurrent']->getId()): ?>
	<li class="add">
		<a href="#"  title="<?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
" onclick="ajaxAddUserFriend(this,<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
,'accept'); return false;"><?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
</a>
	</li>
<?php elseif ($this->_tpl_vars['oUserFriend'] && $this->_tpl_vars['oUserFriend']->getFriendStatus() == $this->_tpl_vars['USER_FRIEND_OFFER']+$this->_tpl_vars['USER_FRIEND_REJECT'] && $this->_tpl_vars['oUserFriend']->getUserTo() != $this->_tpl_vars['oUserCurrent']->getId()): ?>
	<li class="del"><?php echo $this->_tpl_vars['aLang']['user_friend_offer_reject']; ?>
</li>							
<?php elseif ($this->_tpl_vars['oUserFriend'] && $this->_tpl_vars['oUserFriend']->getFriendStatus() == $this->_tpl_vars['USER_FRIEND_OFFER']+$this->_tpl_vars['USER_FRIEND_NULL'] && $this->_tpl_vars['oUserFriend']->getUserFrom() == $this->_tpl_vars['oUserCurrent']->getId()): ?>
	<li class="add"><?php echo $this->_tpl_vars['aLang']['user_friend_offer_send']; ?>
</li>						
<?php elseif ($this->_tpl_vars['oUserFriend'] && $this->_tpl_vars['oUserFriend']->getFriendStatus() == $this->_tpl_vars['USER_FRIEND_OFFER']+$this->_tpl_vars['USER_FRIEND_NULL'] && $this->_tpl_vars['oUserFriend']->getUserTo() == $this->_tpl_vars['oUserCurrent']->getId()): ?>
	<li class="add">
		<a href="#"  title="<?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
" onclick="ajaxAddUserFriend(this,<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
,'accept'); return false;"><?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
</a>
	</li>
<?php elseif (! $this->_tpl_vars['oUserFriend']): ?>	
	<li class="add">
		<a href="#"  title="<?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
" onclick="toogleFriendForm(this); return false;"><?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
</a>
		<form id="add_friend_form" onsubmit="ajaxAddUserFriend(this,<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
,'add'); return false;"  style="display:none;">
			<label for="add_friend_text"><?php echo $this->_tpl_vars['aLang']['user_friend_add_text_label']; ?>
</label>
			<textarea id="add_friend_text"></textarea>
			<input type="submit" value="<?php echo $this->_tpl_vars['aLang']['user_friend_add_submit']; ?>
" />
			<input type="submit" value="<?php echo $this->_tpl_vars['aLang']['user_friend_add_cansel']; ?>
" onclick="toogleFriendForm(this); return false;" />
		</form>							
	</li>
<?php else: ?>
	<li class="add">
		<a href="#"  title="<?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
" onclick="ajaxAddUserFriend(this,<?php echo $this->_tpl_vars['oUserProfile']->getId(); ?>
,'link'); return false;"><?php echo $this->_tpl_vars['aLang']['user_friend_add']; ?>
</a>
	</li>
<?php endif; ?>
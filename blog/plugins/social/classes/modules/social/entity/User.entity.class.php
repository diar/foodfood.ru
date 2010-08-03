<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

class PluginSocial_ModuleSocial_EntityUser extends PluginSocial_Inherit_ModuleUser_EntityUser {
	
    public function getProfileSkype() {
        return $this->_aData['user_profile_skype'];
    }
   
    public function setProfileSkype($data) {
    	$this->_aData['user_profile_skype']=$data;
    }

    public function getProfileJabber() {
        return $this->_aData['user_profile_jabber'];
    }
   
    public function setProfileJabber($data) {
    	$this->_aData['user_profile_jabber']=$data;
    }

    public function getProfilePhone() {
        return $this->_aData['user_phone'];
    }
   
    public function setProfilePhone($data) {
    	$this->_aData['user_phone']=$data;
    }
    public function getProfileVk() {
        return $this->_aData['user_profile_vk'];
    }
   
    public function setProfileVk($data) {
    	$this->_aData['user_profile_vk']=$data;
    }
    public function getProfileLj() {
        return $this->_aData['user_profile_lj'];
    }
   
    public function setProfileLj($data) {
    	$this->_aData['user_profile_lj']=$data;
    }
}
?>

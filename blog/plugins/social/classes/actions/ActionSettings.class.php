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

/**
 * Обрабатывает настройки профила юзера
 *
 */
class PluginSocial_ActionSettings extends PluginSocial_Inherit_ActionSettings {


	protected function RegisterEvent() {		
		parent::RegisterEvent();		
		$this->AddEvent('social','EventSocial');			
	}
		
	
	/**********************************************************************************
	 ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
	 **********************************************************************************
	 */
	

	/**
	 * Выводит форму для редактирования контактов и обрабатывает её
	 *
	 */
	protected function EventSocial() {
		$this->sMenuItemSelect='settings';
		$this->sMenuSubItemSelect='social';
		$this->Viewer_AddHtmlTitle($this->Lang_Get('settings_menu_social'));
		/**
		 * Если нажали кнопку "Сохранить"
		 */
		if (isPost('submit_social_edit')) {
			$this->Security_ValidateSendForm();
						
			$bError=false;			
			/**
		 	* Заполняем профиль из полей формы
		 	*/
			/**
			 * Проверяем ICQ
			 */
			if (func_check(getRequest('profile_icq'),'id',4,15)) {
				$this->oUserCurrent->setProfileIcq(getRequest('profile_icq'));
			} else {
				$this->oUserCurrent->setProfileIcq(null);
			}
			/**
			 * Проверяем Skype
			 */
			if (func_check(getRequest('profile_skype'),'text',3,300)) {
				$this->oUserCurrent->setProfileSkype(getRequest('profile_skype'));
			} else {
				$this->oUserCurrent->setProfileSkype(null);
			}
			/**
			 * Проверяем Jabber
			 */
			if (func_check(getRequest('profile_jabber'),'text',3,300)) {
				$this->oUserCurrent->setProfileJabber(getRequest('profile_jabber'));
			} else {
				$this->oUserCurrent->setProfileJabber(null);
			}
			/**
			 * Проверяем номер телефона
			 */
                        $phone = preg_replace("/[^0-9]/",'',getRequest('profile_phone'));
                        $phone = preg_replace("/^(79|89|9)/",'+79',$phone);
			if (func_check($phone,'phone')) {
				$this->oUserCurrent->setProfilePhone($phone);
			} else {
				$this->oUserCurrent->setProfilePhone($this->oUserCurrent->getProfilePhone());
			}
			/**
			 * Проверяем номер Вконтакте
			 */
			if (func_check(getRequest('profile_vk'),'text',3,30)) {
				$this->oUserCurrent->setProfileVk(getRequest('profile_vk'));
			} else {
				$this->oUserCurrent->setProfileVk(null);
			}
			/**
			 * Проверяем номер Живой Журнал
			 */
			if (func_check(getRequest('profile_lj'),'text',3,200)) {
				$this->oUserCurrent->setProfileLj(getRequest('profile_lj'));
			} else {
				$this->oUserCurrent->setProfileLj(null);
			}
			/**
			 * Проверяем сайт
			 */
			if (func_check(getRequest('profile_site'),'text',3,200)) {
				$this->oUserCurrent->setProfileSite(getRequest('profile_site'));
			} else {
				$this->oUserCurrent->setProfileSite(null);
			} 
			/**
			 * Проверяем название сайта
			 */
			if (func_check(getRequest('profile_site_name'),'text',3,50)) {
				$this->oUserCurrent->setProfileSiteName(getRequest('profile_site_name'));
			} else {
				$this->oUserCurrent->setProfileSiteName(null);
			} 
			/**
			 * Ставим дату последнего изменения профиля
			 */
			$this->oUserCurrent->setProfileDate(date("Y-m-d H:i:s"));
			/**
			 * Сохраняем изменения профиля
		 	*/		
			if (!$bError) {
				if ($this->User_Update($this->oUserCurrent)) {
					
					$this->Message_AddNoticeSingle($this->Lang_Get('settings_social_submit_ok'));
				} else {
					$this->Message_AddErrorSingle($this->Lang_Get('system_error'));
				}
			}
		}
	}
	
}
?>

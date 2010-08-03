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

class PluginSocial_ModuleSocial_MapperUser extends PluginSocial_Inherit_ModuleUser_MapperUser {
	public function Update(ModuleUser_EntityUser $oUser) {
		$sql = "UPDATE ".Config::Get('db.table.user')." 
			SET 
				user_password = ? ,
				user_mail = ? ,					
				user_skill = ? ,				
				user_date_activate = ? ,
				user_date_comment_last = ? ,				
				user_rating = ? ,
				user_count_vote = ? ,
				user_activate = ? , 
				user_profile_name = ? ,  
				user_profile_sex = ? , 
				user_profile_country = ? , 
				user_profile_region = ? , 
				user_profile_city = ? , 
				user_profile_birthday = ? , 
				user_profile_site = ? , 
				user_profile_site_name = ? , 
				user_profile_icq = ? , 
				user_profile_skype = ? , 
				user_profile_jabber = ? , 
				user_phone = ? , 
				user_profile_vk = ? , 
				user_profile_lj = ? , 
				user_profile_about = ? ,
				user_profile_date = ? ,
				user_profile_avatar = ?	,
				user_profile_foto = ? ,	
				user_settings_notice_new_topic = ?	,
				user_settings_notice_new_comment = ? ,
				user_settings_notice_new_talk = ?	,
				user_settings_notice_reply_comment = ? ,
				user_settings_notice_new_friend = ? 		
			WHERE user_id = ?
		";			
		if ($this->oDb->query($sql,$oUser->getPassword(),
								   $oUser->getMail(),								   
								   $oUser->getSkill(),								   
								   $oUser->getDateActivate(),
								   $oUser->getDateCommentLast(),							   
								   $oUser->getRating(),
								   $oUser->getCountVote(),
								   $oUser->getActivate(),								   
								   $oUser->getProfileName(),
								   $oUser->getProfileSex(),
								   $oUser->getProfileCountry(),
								   $oUser->getProfileRegion(),
								   $oUser->getProfileCity(),
								   $oUser->getProfileBirthday(),
								   $oUser->getProfileSite(),
								   $oUser->getProfileSiteName(),
								   $oUser->getProfileIcq(),
								   $oUser->getProfileSkype(),
								   $oUser->getProfileJabber(),
								   $oUser->getProfilePhone(),
								   $oUser->getProfileVk(),
								   $oUser->getProfileLj(),
								   $oUser->getProfileAbout(),	
								   $oUser->getProfileDate(),	
								   $oUser->getProfileAvatar(),
								   $oUser->getProfileFoto(),
								   $oUser->getSettingsNoticeNewTopic(),
								   $oUser->getSettingsNoticeNewComment(),
								   $oUser->getSettingsNoticeNewTalk(),
								   $oUser->getSettingsNoticeReplyComment(),	
								   $oUser->getSettingsNoticeNewFriend(),			   
								   $oUser->getId())) {
			return true;
		}		
		return false;
	}
}
?>

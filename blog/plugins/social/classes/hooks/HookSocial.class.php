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

class PluginSocial_HookSocial extends Hook {

    public function RegisterHook() {
    	
        $this->AddHook('template_menu_settings_settings_item', 'Menu', __CLASS__);

    }

   public function Menu() {
                        return $this->Viewer_Fetch(Plugin::GetTemplatePath('social').'menu.social.tpl');
        }
}
?>

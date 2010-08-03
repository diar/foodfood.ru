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
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}
class PluginSocial extends Plugin {

    protected $aDelegates=array(
        'template'=>array('actions/ActionProfile/sidebar.tpl'=>'_actions/ActionProfile/sidebar.tpl'),
    );
    
    protected $aInherits=array( 
       'action'  =>array('ActionSettings'=>'_ActionSettings'),
       'mapper'  =>array('ModuleUser_MapperUser'=>'_ModuleSocial_MapperUser'),
       'entity'  =>array('ModuleUser_EntityUser'=>'_ModuleSocial_EntityUser'),
    );

    public function Activate() {
		$this->ExportSQL(dirname(__FILE__).'/sql/dump.sql');
        return true;
    }

    public function Deactivate() {
		$this->ExportSQL(dirname(__FILE__).'/sql/delete.sql');
        return true;
    }
	
    
    public function Init() { }
}
?>

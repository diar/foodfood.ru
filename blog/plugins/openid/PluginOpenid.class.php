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
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}
/**
 * Плагин "OpenID"
 *
 */
class PluginOpenid extends Plugin {
	/**
	 * Активация плагина.	 
	 */
	public function Activate() {		
		if (!$this->isTableExists('prefix_openid')) {
			/**
			 * При активации выполняем SQL дамп
			 */
			$this->ExportSQL(dirname(__FILE__).'/dump.sql');
		}
		return true;
	}
	
	/**
	 * Инициализация плагина
	 */
	public function Init() {
		
	}
	
	/**
	 * Проверяет наличие таблицы в БД
	 *
	 * @param unknown_type $sTableName
	 * @return unknown
	 */
	protected function isTableExists($sTableName) {
		$sTableName = str_replace('prefix_', Config::Get('db.table.prefix'), $sTableName);
		$sQuery="SHOW TABLES LIKE '{$sTableName}'";
		if ($aRows=$this->Database_GetConnect()->select($sQuery)) {
			return true;
		}
		return false;
	}
}
?>
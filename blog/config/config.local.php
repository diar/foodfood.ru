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
 * Настройки для локального сервера.
 * Для использования - переименовать файл в config.local.php
 */

/**
 * Настройка базы данных
 */
$config['db']['params']['host'] = '88.82.75.4';
$config['db']['params']['port'] = '3306';
$config['db']['params']['user'] = 'z-mode';
$config['db']['params']['pass'] = '150878';
$config['db']['params']['type']   = 'mysql';
$config['db']['params']['dbname'] = 'foodfood';
$config['db']['table']['prefix'] = 'blog_';

$config['path']['offset_request_url'] = '1';
$config['db']['tables']['engine'] = 'MyISAM';
return $config;
?>
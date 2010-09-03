<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Главная страница
 */
class banner_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        define('NO_STAT', true);
        self::$page['site']['city'] = CityPlugin::getCity();
        Cache::disable();
        Debug::disable();
    }

    /*
     * Показ баннера по умолчанию
    */
    public static function viewAction ($type) {
        $tid = Router::getRequest('tid');
        self::$page['banner'] = MD_Banner::getRecord($type,$tid);
        self::showXSLT('pages/banner/view');
    }
}
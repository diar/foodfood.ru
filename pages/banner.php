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
    public static function indexAction ($id) {
        self::$page['banner'] = MD_Banner::getRecordRand(array('vertical'=>0));
        self::showXSLT('blocks/banner');
    }

    /*
     * Показ вертикального баннера
    */
    public static function verticalAction ($id) {
        self::$page['banner'] = MD_Banner::getRecordRand(array('vertical'=>1));
        self::$page['banner']['width']='240';
        self::$page['banner']['height']='350';
        self::showXSLT('blocks/banner');
    }

    /*
     * Показ горизонтального баннера
    */
    public static function horizontalAction ($id) {
        self::$page['banner'] = MD_Banner::getRecordRand(array('vertical'=>0));
        self::$page['banner']['width']='770';
        self::$page['banner']['height']='160';
        self::showXSLT('blocks/banner');
    }
}
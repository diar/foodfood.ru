<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Блог
 */
class blog_Page extends View {

    /*
     * Инициализация страницы
    */
    public static function initController ($action) {
        self::$page['site']['city'] = CityPlugin::getCity();
    }

    /*
     * Перенаправление на блог
    */
    public static function indexAction ($id) {
        Router::setPage('/blog/');
    }

}
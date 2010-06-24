<?php
/**
 * @package PapipuEngine
 * @author valmon, z-mode
 * @version 0.2
 * Страница карты сайта
 */
class sitemap_Page extends View {

    /*
     * Инициализация контроллера
    */
    public static function initController ($action) {
        self::$page['site']['city'] = CityPlugin::getCity();
    }

    /*
     * Скидки
    */
    public static function sitemapAction ($id) {
        // Добавляем переменные xslt
        self::$page['content'] = array();

        // Показываем страницу
        self::showXSLT('pages/sitemap/sitemap');
    }
}
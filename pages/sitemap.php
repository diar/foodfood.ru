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
        header('Content-type: text/xml');
        // Добавляем переменные xslt
        $url = array(
            array('loc'=>'http://foodfood.ru/','priority'=>'1','changefreq'=>'hourly')
        );

        self::$page['content'] = $url;

        // Показываем страницу
        self::showXSLT('pages/sitemap/sitemap');
    }
}